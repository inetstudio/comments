<?php

namespace InetStudio\CommentsPackage\Comments\Services\Front;

use League\Fractal\Manager;
use Illuminate\Database\Eloquent\Relations\Relation;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * @var array
     */
    public $availableTypes = [];

    /**
     * ItemsService constructor.
     *
     * @param  CommentModelContract  $model
     */
    public function __construct(CommentModelContract $model)
    {
        parent::__construct($model);

        $this->availableTypes = config('comments.commentable', []);
    }

    /**
     * Возвращаем тип по классу модели.
     *
     * @param  string  $modelClass
     *
     * @return string
     *
     * @throws BindingResolutionException
     */
    public function getTypeByModel(string $modelClass): string
    {
        $modelClass = Relation::getMorphedModel($modelClass) ?? $modelClass;

        foreach ($this->availableTypes as $type => $model) {
            $object = app()->make($model);

            if ($modelClass == get_class($object)) {
                return $type;
            }
        }

        return '';
    }

    /**
     * Сохраняем комментарий.
     *
     * @param  array  $data
     * @param  string  $type
     * @param  int  $id
     * @param  int  $parentId
     *
     * @return CommentModelContract|null
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, string $type, int $id, int $parentId): ?CommentModelContract
    {
        if (! isset($this->availableTypes[$type])) {
            return null;
        }

        $model = app()->make($this->availableTypes[$type]);

        $usersService = app()->make('InetStudio\ACL\Users\Contracts\Services\Front\ItemsServiceContract');

        $request = request();
        $item = $model::find($id);

        if (! ($item && $item->id)) {
            return null;
        }

        if ($parentId) {
            $parentItem = $this->getItemById(
                $parentId,
                [
                    'columns' => ['_lft', '_rgt'],
                ]
            );
        }

        if (isset($parentItem) && ($item['id'] != $parentItem['commentable_id'] || $item->getTable() != $parentItem['commentable_type'])) {
            return null;
        }

        $data = array_merge($data, [
            'commentable_id' => $item->id,
            'commentable_type' => $item->getTable(),
            'user_id' => $usersService->getUserId(),
            'name' => $usersService->getUserName($request),
            'email' => $usersService->getUserEmail($request),
        ]);

        $item = $this->saveModel($data);

        if (isset($parentItem)) {
            $item->appendToNode($parentItem)->save();
        } else {
            $item->saveAsRoot();
        }

        if ($item && $item->id) {
            event(
                app()->make(
                    'InetStudio\CommentsPackage\Comments\Contracts\Events\Front\SendItemEventContract',
                    compact('item')
                ));
        }

        return $item;
    }

    /**
     * Получаем дерево комментариев по типу и id материала.
     *
     * @param  string  $type
     * @param  int  $id
     * @param  array  $params
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public function getItemsTreeByTypeAndId(string $type, int $id, array $params = [])
    {
        if (! isset($this->availableTypes[$type])) {
            return collect([]);
        }

        $model = app()->make($this->availableTypes[$type]);

        $item = $model::find($id);

        if (! ($item && $item->id)) {
            return collect([]);
        }

        return $item->comments()->get()->toTree();
    }

    /**
     * Преобразуем дерево комментариев.
     *
     * @param $tree
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getTree($tree): array
    {
        $transformer = app()->makeWith('InetStudio\CommentsPackage\Comments\Contracts\Transformers\Front\ItemTransformerContract');
        $resource = $transformer->transformCollection($tree);

        $manager = new Manager();

        $serializer = app()->make('InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract');
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        return $transformation;
    }
}

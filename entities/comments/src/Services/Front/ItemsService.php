<?php

namespace InetStudio\CommentsPackage\Comments\Services\Front;

use League\Fractal\Manager;
use Illuminate\Support\Collection;
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
     *
     * @throws BindingResolutionException
     */
    public function __construct(CommentModelContract $model)
    {
        parent::__construct($model);

        $types = config('comments.commentable');

        foreach ($types ?? [] as $type => $modelContract) {
            $this->availableTypes[$type] = app()->make($modelContract);
        }
    }

    /**
     * Сохраняем комментарий.
     *
     * @param  array  $data
     * @param  string  $type
     * @param  int  $id
     *
     * @return CommentModelContract|null
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, string $type, int $id): ?CommentModelContract
    {
        if (! isset($this->availableTypes[$type])) {
            return null;
        }

        $usersService = app()->make('InetStudio\ACL\Users\Contracts\Services\Front\UsersServiceContract');

        $request = request();
        $item = $this->availableTypes[$type]::find($id);

        if (! ($item && $item->id)) {
            return null;
        }

        $data = array_merge($data, [
            'commentable_id' => $item->id,
            'commentable_type' => get_class($item),
            'user_id' => $usersService->getUserId(),
            'name' => $usersService->getUserName($request),
            'email' => $usersService->getUserEmail($request),
        ]);

        $item = $this->saveModel($data);
        $item->saveAsRoot();

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
     *
     * @return Collection
     */
    public function getItemsTreeByTypeAndId(string $type, int $id): Collection
    {
        if (! isset($this->availableTypes[$type])) {
            return collect([]);
        }

        $item = $this->availableTypes[$type]::find($id);

        if (! ($item && $item->id)) {
            return collect([]);
        }

        return $item->commentsTree();
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

        $serializer = app()->make('InetStudio\AdminPanel\Contracts\Serializers\SimpleDataArraySerializerContract');
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        return $transformation;
    }
}

<?php

namespace InetStudio\Comments\Services\Front;

use League\Fractal\Manager;
use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\Front\BaseService;
use InetStudio\Comments\Contracts\Models\CommentModelContract;
use InetStudio\Comments\Contracts\Services\Front\CommentsServiceContract;

/**
 * Class CommentsService.
 */
class CommentsService extends BaseService implements CommentsServiceContract
{
    public $availableTypes = [];

    /**
     * CommentsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Comments\Contracts\Models\CommentModelContract'));

        $types = config('comments.commentable');

        foreach ($types ?? [] as $type => $modelContract) {
            $this->availableTypes[$type] = app()->make($modelContract);
        }
    }

    /**
     * Сохраняем комментарий.
     *
     * @param array $data
     * @param string $type
     * @param int $id
     *
     * @return CommentModelContract|null
     */
    public function saveComment(array $data,
                                string $type,
                                int $id): ?CommentModelContract
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

        $comment = $this->saveModel($data);
        $comment->saveAsRoot();

        if ($comment && $comment->id) {
            event(app()->makeWith('InetStudio\Comments\Contracts\Events\Front\SendCommentEventContract', [
                'object' => $comment,
            ]));
        }

        return $comment;
    }

    /**
     * Получаем дерево комментариев по типу и id материала.
     *
     * @param string $type
     * @param int $id
     *
     * @return Collection
     */
    public function getCommentsTreeByTypeAndId(string $type,
                                               int $id): Collection
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
     */
    protected function getTree($tree): array
    {
        $resource = (app()->makeWith('InetStudio\Comments\Contracts\Transformers\Front\CommentTransformerContract'))
            ->transformCollection($tree);

        $manager = new Manager();

        $serializer = app()->make('InetStudio\AdminPanel\Contracts\Serializers\SimpleDataArraySerializerContract');
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        return $transformation;
    }
}

<?php

namespace InetStudio\Comments\Models;

use Laravel\Scout\Searchable;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\ACL\Users\Models\Traits\HasUser;

/**
 * InetStudio\Comments\Models\CommentModel.
 *
 * @property int $id
 * @property int $is_read
 * @property int $is_active
 * @property int $commentable_id
 * @property string $commentable_type
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string $user_id
 * @property string $name
 * @property string $email
 * @property string|null $message
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Kalnoy\Nestedset\Collection|\InetStudio\Comments\Models\CommentModel[] $children
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \InetStudio\Comments\Models\CommentModel|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel d()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel inactive()
 * @method static \Illuminate\Database\Query\Builder|\InetStudio\Comments\Models\CommentModel onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel unread()
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Comments\Models\CommentModel whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\InetStudio\Comments\Models\CommentModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\InetStudio\Comments\Models\CommentModel withoutTrashed()
 * @mixin \Eloquent
 */
class CommentModel extends Model
{
    use HasUser;
    use NodeTrait;
    use Notifiable;
    use Searchable;
    use SoftDeletes;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'is_read', 'is_active', 'user_id', 'name', 'email', 'message',
        'commentable_id', 'commentable_type',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Настройка полей для поиска.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $arr = array_only($this->toArray(), ['id', 'user_id', 'name', 'email', 'message']);

        return $arr;
    }

    /**
     * Заготовка запроса "Непрочитанные комментарии".
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }

    /**
     * Заготовка запроса "Активные комментарии".
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Заготовка запроса "Неактивные комментарии".
     *
     * @param $query
     * @return mixed
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

    /**
     * Полиморфное отношение с остальными моделями.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Получаем дерево комментариев.
     *
     * @param $object
     * @return array
     */
    public static function getTree($object): array
    {
        $tree = $object->comments()->where('is_active', 1)->get()->toTree();

        $data = [];

        $traverse = function ($comments) use (&$traverse, $data) {
            foreach ($comments as $comment) {
                $data[$comment->id]['id'] = $comment->id;
                $data[$comment->id]['user'] = [
                    'object' => $comment->user,
                    'name' => $comment->name,
                ];
                $data[$comment->id]['datetime'] = $comment->created_at;
                $data[$comment->id]['message'] = $comment->message;
                $data[$comment->id]['items'] = $traverse($comment->children);
            }

            return $data;
        };

        return $traverse($tree);
    }
}

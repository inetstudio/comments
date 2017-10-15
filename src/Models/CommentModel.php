<?php

namespace InetStudio\Comments\Models;

use App\User;
use Laravel\Scout\Searchable;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentModel extends Model
{
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

    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Обратное отношение с моделью пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Получаем дерево комментариев.
     *
     * @param $object
     * @return array
     */
    public static function getTree($object)
    {
        $tree = $object->comments->toTree();

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

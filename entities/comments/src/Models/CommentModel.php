<?php

namespace InetStudio\CommentsPackage\Comments\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\ACL\Users\Models\Traits\HasUser;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;

/**
 * Class CommentModel.
 */
class CommentModel extends Model implements CommentModelContract
{
    use NodeTrait;
    use HasImages;
    use Notifiable;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    protected $images = [
        'config' => 'comments',
        'model' => 'comment',
    ];

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'comment';

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'is_read',
            'is_active',
            'user_id',
            'name',
            'email',
            'message',
            'commentable_id',
            'commentable_type',
        ];
    }

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
        'is_read',
        'is_active',
        'user_id',
        'name',
        'email',
        'message',
        'commentable_id',
        'commentable_type',
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
     * Сеттер атрибута is_read.
     *
     * @param $value
     */
    public function setIsReadAttribute($value)
    {
        $this->attributes['is_read'] = (bool) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута is_active.
     *
     * @param $value
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = (bool) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута user_id.
     *
     * @param $value
     */
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута name.
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута email.
     *
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута message.
     *
     * @param $value
     */
    public function setMessageAttribute($value)
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['message'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Сеттер атрибута commentable_type.
     *
     * @param $value
     */
    public function setCommentableTypeAttribute($value)
    {
        $this->attributes['commentable_type'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута commentable_id.
     *
     * @param $value
     */
    public function setCommentableIdAttribute($value)
    {
        $this->attributes['commentable_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * Заготовка запроса "Непрочитанные комментарии".
     *
     * @param $query
     *
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
     *
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
     *
     * @return mixed
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

    /**
     * Полиморфное отношение с остальными моделями.
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    use HasUser;
}

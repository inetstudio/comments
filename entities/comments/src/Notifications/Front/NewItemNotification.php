<?php

namespace InetStudio\CommentsPackage\Comments\Notifications\Front;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Mail\Front\NewItemMailContract;
use InetStudio\CommentsPackage\Comments\Contracts\Notifications\Front\NewItemNotificationContract;

/**
 * Class NewItemNotification.
 */
class NewItemNotification extends Notification implements NewItemNotificationContract
{
    /**
     * @var CommentModelContract
     */
    protected $item;

    /**
     * NewCommentNotification constructor.
     *
     * @param  CommentModelContract  $item
     */
    public function __construct(CommentModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return [
            'mail',
            'database',
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param $notifiable
     *
     * @return NewItemMailContract
     *
     * @throws BindingResolutionException
     */
    public function toMail($notifiable): NewItemMailContract
    {
        return app()->make(
            NewItemMailContract::class,
            [
                'item' => $this->item,
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'comment_id' => $this->item['id'],
        ];
    }
}

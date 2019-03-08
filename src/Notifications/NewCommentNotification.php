<?php

namespace InetStudio\Comments\Notifications;

use Illuminate\Notifications\Notification;
use InetStudio\Comments\Contracts\Mail\NewCommentMailContract;
use InetStudio\Comments\Contracts\Models\CommentModelContract;
use InetStudio\Comments\Contracts\Notifications\NewCommentNotificationContract;

/**
 * Class NewCommentNotification.
 */
class NewCommentNotification extends Notification implements NewCommentNotificationContract
{
    /**
     * @var CommentModelContract
     */
    protected $item;

    /**
     * NewCommentNotification constructor.
     *
     * @param CommentModelContract $item
     */
    public function __construct(CommentModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return [
            'mail', 'database',
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param $notifiable
     *
     * @return NewCommentMailContract
     */
    public function toMail($notifiable): NewCommentMailContract
    {
        return app()->makeWith('InetStudio\Comments\Contracts\Mail\NewCommentMailContract', [
            'item' => $this->item,
        ]);
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
            'comment_id' => $this->item->id,
        ];
    }
}

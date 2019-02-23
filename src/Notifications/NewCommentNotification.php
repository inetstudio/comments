<?php

namespace InetStudio\Comments\Notifications;

use Illuminate\Notifications\Notification;
use InetStudio\Comments\Mail\NewCommentMail;
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
    protected $comment;

    /**
     * NewCommentNotification constructor.
     *
     * @param CommentModelContract $comment
     */
    public function __construct(CommentModelContract $comment)
    {
        $this->comment = $comment;
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
     * @return NewCommentMail
     */
    public function toMail($notifiable): NewCommentMail
    {
        return new NewCommentMail($this->comment);
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
            'comment_id' => $this->comment->id,
        ];
    }
}

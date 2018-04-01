<?php

namespace InetStudio\Comments\Notifications;

use Illuminate\Notifications\Notification;
use InetStudio\Comments\Mail\NewCommentMail;
use InetStudio\Comments\Models\CommentModel;

class NewCommentNotification extends Notification
{
    protected $comment;

    /**
     * NewCommentNotification constructor.
     *
     * @param CommentModel $comment
     */
    public function __construct(CommentModel $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
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
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'comment_id' => $this->comment->id,
        ];
    }
}

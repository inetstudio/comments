<?php

namespace InetStudio\CommentsPackage\Comments\Notifications\Back;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Mail\Back\AnswerMailContract;
use InetStudio\CommentsPackage\Comments\Contracts\Notifications\Back\AnswerNotificationContract;

/**
 * Class AnswerNotification.
 */
class AnswerNotification extends Notification implements AnswerNotificationContract
{
    /**
     * @var CommentModelContract
     */
    protected $item;

    /**
     * AnswerNotification constructor.
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
     * @return AnswerMailContract
     *
     * @throws BindingResolutionException
     */
    public function toMail($notifiable): AnswerMailContract
    {
        return app()->make(
            AnswerMailContract::class,
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

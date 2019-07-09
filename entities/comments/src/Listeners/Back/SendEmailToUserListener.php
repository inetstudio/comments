<?php

namespace InetStudio\CommentsPackage\Comments\Listeners\Back;

use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Listeners\Back\SendEmailToUserListenerContract;

/**
 * Class SendEmailToUserListener.
 */
class SendEmailToUserListener implements SendEmailToUserListenerContract
{
    /**
     * Handle the event.
     *
     * @param $event
     *
     * @throws BindingResolutionException
     */
    public function handle($event)
    {
        $item = $event->item;

        if (config('comments.mails_users.send')) {
            if (config('comments.queue.enable')) {
                $queue = config('comments.queue.name', 'comments_notify');

                $item->notify(
                    app()->make(
                        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Back\AnswerQueueableNotificationContract',
                        compact('item')
                    )->onQueue($queue)
                );
            } else {
                $item->notify(
                    app()->make(
                        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Back\AnswerNotificationContract',
                        compact('item')
                    )
                );
            }
        }
    }
}

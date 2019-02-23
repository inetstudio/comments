<?php

namespace InetStudio\Comments\Listeners;

use InetStudio\Comments\Contracts\Listeners\SendEmailToUserListenerContract;

/**
 * Class SendEmailToUserListener.
 */
class SendEmailToUserListener implements SendEmailToUserListenerContract
{
    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        $comment = $event->object;

        if (config('comments.mails_users.send')) {
            if (config('comments.queue.enable')) {
                $queue = config('comments.queue.name') ?? 'comments_notify';

                $comment->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\AnswerQueueableNotificationContract', compact('comment'))
                        ->onQueue($queue)
                );
            } else {
                $comment->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\AnswerNotificationContract', compact('comment'))
                );
            }
        }
    }
}

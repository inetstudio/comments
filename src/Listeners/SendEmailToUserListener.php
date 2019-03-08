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
        $item = $event->object;

        if (config('comments.mails_users.send')) {
            if (config('comments.queue.enable')) {
                $queue = config('comments.queue.name') ?? 'comments_notify';

                $item->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\AnswerQueueableNotificationContract', compact('item'))
                        ->onQueue($queue)
                );
            } else {
                $item->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\AnswerNotificationContract', compact('item'))
                );
            }
        }
    }
}

<?php

namespace InetStudio\Comments\Listeners;

use InetStudio\Comments\Contracts\Listeners\SendEmailToAdminListenerContract;

/**
 * Class SendEmailToAdminListener.
 */
class SendEmailToAdminListener implements SendEmailToAdminListenerContract
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

        if (config('comments.mails_admins.send')) {
            if (config('comments.queue.enable')) {
                $queue = config('comments.queue.name') ?? 'comments_notify';

                $item->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\NewCommentQueueableNotificationContract', compact('item'))
                        ->onQueue($queue)
                );
            } else {
                $item->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\NewCommentNotificationContract', compact('item'))
                );
            }
        }
    }
}

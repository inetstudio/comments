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
        $comment = $event->object;

        if (config('comments.mails_admins.send')) {
            if (config('comments.queue.enable')) {
                $queue = config('comments.queue.name') ?? 'comments_notify';

                $comment->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\NewCommentQueueableNotificationContract', compact('comment'))
                        ->onQueue($queue)
                );
            } else {
                $comment->notify(
                    app()->makeWith('InetStudio\Comments\Contracts\Notifications\NewCommentNotificationContract', compact('comment'))
                );
            }
        }
    }
}

<?php

namespace InetStudio\CommentsPackage\Comments\Listeners\Front;

use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front\SendEmailToAdminListenerContract;

/**
 * Class SendEmailToAdminListener.
 */
class SendEmailToAdminListener implements SendEmailToAdminListenerContract
{
    /**
     * Handle the event.
     *
     * @param $event
     *
     * @throws BindingResolutionException
     */
    public function handle($event): void
    {
        $item = $event->item;

        if (config('comments.mails_admins.send')) {
            if (config('comments.queue.enable')) {
                $queue = config('comments.queue.name', 'comments_notify');

                $item->notify(
                    app()->make(
                        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Front\NewItemQueueableNotificationContract',
                        compact('item')
                    )->onQueue($queue)
                );
            } else {
                $item->notify(
                    app()->makeWith(
                        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Front\NewItemNotificationContract',
                        compact('item')
                    )
                );
            }
        }
    }
}

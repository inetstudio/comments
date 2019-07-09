<?php

namespace InetStudio\CommentsPackage\Comments\Notifications\Front;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use InetStudio\CommentsPackage\Comments\Contracts\Notifications\Front\NewItemQueueableNotificationContract;

/**
 * Class NewItemQueueableNotification.
 */
class NewItemQueueableNotification extends NewItemNotification implements ShouldQueue, NewItemQueueableNotificationContract
{
    use Queueable;
}

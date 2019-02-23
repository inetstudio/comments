<?php

namespace InetStudio\Comments\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use InetStudio\Comments\Contracts\Notifications\NewCommentQueueableNotificationContract;

/**
 * Class NewCommentQueueableNotification.
 */
class NewCommentQueueableNotification extends NewCommentNotification implements ShouldQueue, NewCommentQueueableNotificationContract
{
    use Queueable;
}

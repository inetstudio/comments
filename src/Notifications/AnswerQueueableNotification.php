<?php

namespace InetStudio\Comments\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use InetStudio\Comments\Contracts\Notifications\AnswerQueueableNotificationContract;

/**
 * Class AnswerQueueableNotification.
 */
class AnswerQueueableNotification extends AnswerNotification implements ShouldQueue, AnswerQueueableNotificationContract
{
    use Queueable;
}

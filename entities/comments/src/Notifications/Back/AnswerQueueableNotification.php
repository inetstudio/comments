<?php

namespace InetStudio\CommentsPackage\Comments\Notifications\Back;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use InetStudio\CommentsPackage\Comments\Contracts\Notifications\Back\AnswerQueueableNotificationContract;

/**
 * Class AnswerQueueableNotification.
 */
class AnswerQueueableNotification extends AnswerNotification implements ShouldQueue, AnswerQueueableNotificationContract
{
    use Queueable;
}

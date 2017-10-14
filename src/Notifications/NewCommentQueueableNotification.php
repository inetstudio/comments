<?php

namespace InetStudio\Comments\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCommentQueueableNotification extends NewCommentNotification implements ShouldQueue
{
    use Queueable;
}

<?php

namespace InetStudio\Comments\Observers;

use InetStudio\Comments\Models\CommentModel;
use InetStudio\Comments\Notifications\NewCommentNotification;
use InetStudio\Comments\Notifications\NewCommentQueueableNotification;

class CommentObserver
{
    /**
     * Listen to the CommentModel created event.
     *
     * @param CommentModel $comment
     * @return void
     */
    public function created(CommentModel $comment): void
    {
        if (config('comments.mails.to')) {
            if (config('comments.queue.enable')) {
                $queue = config('comments.queue.name') ?? 'comments_notify';

                $comment->notify((new NewCommentQueueableNotification($comment))->onQueue($queue));
            } else {
                $comment->notify(new NewCommentNotification($comment));
            }
        }
    }
}

<?php

namespace InetStudio\Comments\Listeners;

use InetStudio\Comments\Models\CommentModel;

class AttachUserToCommentsListener
{
    /**
     * AttachUserToSubscriptionListener constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event): void
    {
        $user = $event->user;

        $comments = CommentModel::where('user_id', 0)->where('email', $user->email)->get();

        foreach ($comments as $comment) {
            $comment->user_id = $user->id;
            $comment->name = $user->name;
            $comment->save();
        }
    }
}

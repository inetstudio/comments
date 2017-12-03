<?php

namespace InetStudio\Comments\Listeners;

use InetStudio\Comments\Models\CommentModel;
use InetStudio\AdminPanel\Events\Auth\ActivatedEvent;

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
     * @param ActivatedEvent $event
     * @return void
     */
    public function handle(ActivatedEvent $event): void
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

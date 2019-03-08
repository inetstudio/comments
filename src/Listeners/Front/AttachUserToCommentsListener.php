<?php

namespace InetStudio\Comments\Listeners\Front;

use InetStudio\Comments\Contracts\Listeners\Front\AttachUserToCommentsListenerContract;

/**
 * Class AttachUserToCommentsListener.
 */
class AttachUserToCommentsListener implements AttachUserToCommentsListenerContract
{
    /**
     * Handle the event.
     *
     * @param $event
     *
     * @return void
     */
    public function handle($event): void
    {
        $commentsService = app()->make('InetStudio\Comments\Contracts\Services\Back\CommentsServiceContract');

        $user = $event->user;

        $commentsService->model::where([
            ['user_id', '=', 0],
            ['email', '=', $user->email],
        ])->update([
            'user_id' => $user->id,
            'name' => $user->name,
        ]);
    }
}

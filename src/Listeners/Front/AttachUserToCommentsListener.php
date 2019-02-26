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

        $items = $commentsService->model::where([
            ['user_id', '=', 0],
            ['email', '=', $user->email],
        ]);

        foreach ($items as $item) {
            $data = [
                'user_id' => $user->id,
                'name' => $user->name,
            ];

            $item->update($data);
        }
    }
}

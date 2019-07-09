<?php

namespace InetStudio\CommentsPackage\Comments\Listeners\Front;

use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front\AttachUserToCommentsListenerContract;

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
     * @throws BindingResolutionException
     */
    public function handle($event): void
    {
        $commentsService = app()->make('InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ItemsServiceContract');

        $user = $event->user;

        $commentsService->getModel()::where([
            ['user_id', '=', 0],
            ['email', '=', $user->email],
        ])->update([
            'user_id' => $user->id,
            'name' => $user->name,
        ]);
    }
}

<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front;

/**
 * Interface AttachUserToCommentsListenerContract.
 */
interface AttachUserToCommentsListenerContract
{
    public function handle($event): void;
}

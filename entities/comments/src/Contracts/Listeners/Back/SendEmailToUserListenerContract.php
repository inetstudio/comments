<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Listeners\Back;

/**
 * Interface SendEmailToUserListenerContract.
 */
interface SendEmailToUserListenerContract
{
    public function handle($event): void;
}

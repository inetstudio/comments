<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front;

/**
 * Interface SendEmailToAdminListenerContract.
 */
interface SendEmailToAdminListenerContract
{
    public function handle($event): void;
}

<?php

namespace InetStudio\Comments\Listeners;

use Illuminate\Support\Facades\Cache;
use InetStudio\Comments\Events\UpdateCommentsEvent;

class ClearCommentsCacheListener
{
    /**
     * ClearCacheListener constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UpdateCommentsEvent $event
     * @return void
     */
    public function handle(UpdateCommentsEvent $event)
    {
        $object = $event->object;

        Cache::forget('CommentsService_getCommentsTree_'.md5($object->commentable_type.$object->commentable_id));
    }
}

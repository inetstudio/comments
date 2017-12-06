<?php

namespace InetStudio\Comments\Listeners;

use Illuminate\Support\Facades\Cache;

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
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $object = $event->object;

        Cache::forget('CommentsService_getCommentsTree_'.md5($object->commentable_type.$object->commentable_id));
    }
}

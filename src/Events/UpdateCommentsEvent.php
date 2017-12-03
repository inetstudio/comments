<?php

namespace InetStudio\Comments\Events;

use Illuminate\Queue\SerializesModels;

class UpdateCommentsEvent
{
    use SerializesModels;

    public $object;

    /**
     * Create a new event instance.
     *
     * UpdateCommentsEvent constructor.
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}

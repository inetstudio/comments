<?php

namespace InetStudio\Comments\Events\Front;

use Illuminate\Queue\SerializesModels;
use InetStudio\Comments\Contracts\Events\Front\SendCommentEventContract;

/**
 * Class SendCommentEvent.
 */
class SendCommentEvent implements SendCommentEventContract
{
    use SerializesModels;

    public $object;

    /**
     * SendCommentEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}

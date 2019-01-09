<?php

namespace InetStudio\Comments\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Comments\Contracts\Events\Back\ModifyCommentEventContract;

/**
 * Class ModifyCommentEvent.
 */
class ModifyCommentEvent implements ModifyCommentEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyCommentEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}

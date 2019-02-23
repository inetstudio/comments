<?php

namespace InetStudio\Comments\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Comments\Contracts\Events\Back\AnswerEventContract;

/**
 * Class AnswerEvent.
 */
class AnswerEvent implements AnswerEventContract
{
    use SerializesModels;

    public $object;

    /**
     * AnswerEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}

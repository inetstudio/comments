<?php

namespace InetStudio\CommentsPackage\Comments\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Events\Back\AnswerEventContract;

/**
 * Class AnswerEvent.
 */
class AnswerEvent implements AnswerEventContract
{
    use SerializesModels;

    /**
     * @var CommentModelContract
     */
    public $item;

    /**
     * AnswerEvent constructor.
     *
     * @param  CommentModelContract  $item
     */
    public function __construct(CommentModelContract $item)
    {
        $this->item = $item;
    }
}

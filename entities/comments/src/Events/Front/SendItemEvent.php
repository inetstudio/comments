<?php

namespace InetStudio\CommentsPackage\Comments\Events\Front;

use Illuminate\Queue\SerializesModels;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Events\Front\SendItemEventContract;

/**
 * Class SendItemEvent.
 */
class SendItemEvent implements SendItemEventContract
{
    use SerializesModels;

    /**
     * @var CommentModelContract
     */
    public $item;

    /**
     * SendItemEvent constructor.
     *
     * @param  CommentModelContract  $item
     */
    public function __construct(CommentModelContract $item)
    {
        $this->item = $item;
    }
}

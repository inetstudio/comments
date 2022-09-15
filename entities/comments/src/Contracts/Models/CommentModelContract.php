<?php

namespace InetStudio\CommentsPackage\Comments\Contracts\Models;

use Spatie\MediaLibrary\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface CommentModelContract.
 */
interface CommentModelContract extends BaseModelContract, HasMedia
{
}

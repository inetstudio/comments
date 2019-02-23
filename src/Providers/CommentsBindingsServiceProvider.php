<?php

namespace InetStudio\Comments\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CommentsBindingsServiceProvider.
 */
class CommentsBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Comments\Contracts\Mail\AnswerMailContract' => 'InetStudio\Comments\Mail\AnswerMail',
        'InetStudio\Comments\Contracts\Mail\NewCommentMailContract' => 'InetStudio\Comments\Mail\NewCommentMail',
        'InetStudio\Comments\Contracts\Models\CommentModelContract' => 'InetStudio\Comments\Models\CommentModel',
        'InetStudio\Comments\Contracts\Transformers\Back\CommentTransformerContract' => 'InetStudio\Comments\Transformers\Back\CommentTransformer',
        'InetStudio\Comments\Contracts\Transformers\Front\CommentTransformerContract' => 'InetStudio\Comments\Transformers\Front\CommentTransformer',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Moderate\DestroyResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Moderate\DestroyResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Moderate\ReadResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Moderate\ReadResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Moderate\ActivityResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Moderate\ActivityResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\Comments\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Front\SendCommentResponseContract' => 'InetStudio\Comments\Http\Responses\Front\SendCommentResponse',
        'InetStudio\Comments\Contracts\Http\Responses\Front\GetCommentsResponseContract' => 'InetStudio\Comments\Http\Responses\Front\GetCommentsResponse',
        'InetStudio\Comments\Contracts\Http\Requests\Back\SaveCommentRequestContract' => 'InetStudio\Comments\Http\Requests\Back\SaveCommentRequest',
        'InetStudio\Comments\Contracts\Http\Requests\Front\SendCommentRequestContract' => 'InetStudio\Comments\Http\Requests\Front\SendCommentRequest',
        'InetStudio\Comments\Contracts\Http\Controllers\Back\CommentsDataControllerContract' => 'InetStudio\Comments\Http\Controllers\Back\CommentsDataController',
        'InetStudio\Comments\Contracts\Http\Controllers\Back\CommentsControllerContract' => 'InetStudio\Comments\Http\Controllers\Back\CommentsController',
        'InetStudio\Comments\Contracts\Http\Controllers\Back\CommentsModerateControllerContract' => 'InetStudio\Comments\Http\Controllers\Back\CommentsModerateController',
        'InetStudio\Comments\Contracts\Http\Controllers\Front\CommentsControllerContract' => 'InetStudio\Comments\Http\Controllers\Front\CommentsController',
        'InetStudio\Comments\Contracts\Events\Back\ModifyCommentEventContract' => 'InetStudio\Comments\Events\Back\ModifyCommentEvent',
        'InetStudio\Comments\Contracts\Events\Back\AnswerEventContract' => 'InetStudio\Comments\Events\Back\AnswerEvent',
        'InetStudio\Comments\Contracts\Events\Front\SendCommentEventContract' => 'InetStudio\Comments\Events\Front\SendCommentEvent',
        'InetStudio\Comments\Contracts\Listeners\SendEmailToAdminListenerContract' => 'InetStudio\Comments\Listeners\SendEmailToAdminListener',
        'InetStudio\Comments\Contracts\Listeners\SendEmailToUserListenerContract' => 'InetStudio\Comments\Listeners\SendEmailToUserListener',
        'InetStudio\Comments\Contracts\Listeners\Front\AttachUserToCommentsListenerContract' => 'InetStudio\Comments\Listeners\Front\AttachUserToCommentsListener',
        'InetStudio\Comments\Contracts\Notifications\AnswerQueueableNotificationContract' => 'InetStudio\Comments\Notifications\AnswerQueueableNotification',
        'InetStudio\Comments\Contracts\Notifications\NewCommentQueueableNotificationContract' => 'InetStudio\Comments\Notifications\NewCommentQueueableNotification',
        'InetStudio\Comments\Contracts\Notifications\AnswerNotificationContract' => 'InetStudio\Comments\Notifications\AnswerNotification',
        'InetStudio\Comments\Contracts\Notifications\NewCommentNotificationContract' => 'InetStudio\Comments\Notifications\NewCommentNotification',
        'InetStudio\Comments\Contracts\Services\Back\CommentsModerateServiceContract' => 'InetStudio\Comments\Services\Back\CommentsModerateService',
        'InetStudio\Comments\Contracts\Services\Back\CommentsServiceContract' => 'InetStudio\Comments\Services\Back\CommentsService',
        'InetStudio\Comments\Contracts\Services\Back\CommentsDataTableServiceContract' => 'InetStudio\Comments\Services\Back\CommentsDataTableService',
        'InetStudio\Comments\Contracts\Services\Front\CommentsServiceContract' => 'InetStudio\Comments\Services\Front\CommentsService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}

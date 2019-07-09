<?php

namespace InetStudio\CommentsPackage\Comments\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var array
     */
    public $bindings = [
        'InetStudio\CommentsPackage\Comments\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\CommentsPackage\Comments\Events\Back\ModifyItemEvent',
        'InetStudio\CommentsPackage\Comments\Contracts\Events\Back\AnswerEventContract' => 'InetStudio\CommentsPackage\Comments\Events\Back\AnswerEvent',
        'InetStudio\CommentsPackage\Comments\Contracts\Events\Front\SendItemEventContract' => 'InetStudio\CommentsPackage\Comments\Events\Front\SendItemEvent',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\CommentsPackage\Comments\Http\Controllers\Back\DataController',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back\ModerateControllerContract' => 'InetStudio\CommentsPackage\Comments\Http\Controllers\Back\ModerateController',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\CommentsPackage\Comments\Http\Controllers\Back\ResourceController',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Front\ItemsControllerContract' => 'InetStudio\CommentsPackage\Comments\Http\Controllers\Front\ItemsController',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\CommentsPackage\Comments\Http\Requests\Back\SaveItemRequest',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Front\SendItemRequestContract' => 'InetStudio\CommentsPackage\Comments\Http\Requests\Front\SendItemRequest',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Moderate\DestroyResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Moderate\DestroyResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Moderate\ReadResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Moderate\ReadResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Moderate\ActivityResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Moderate\ActivityResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\SendResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Front\SendResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Http\Responses\Front\GetItemsResponseContract' => 'InetStudio\CommentsPackage\Comments\Http\Responses\Front\GetItemsResponse',
        'InetStudio\CommentsPackage\Comments\Contracts\Listeners\Back\SendEmailToUserListenerContract' => 'InetStudio\CommentsPackage\Comments\Listeners\Back\SendEmailToUserListener',
        'InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front\AttachUserToCommentsListenerContract' => 'InetStudio\CommentsPackage\Comments\Listeners\Front\AttachUserToCommentsListener',
        'InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front\SendEmailToAdminListenerContract' => 'InetStudio\CommentsPackage\Comments\Listeners\Front\SendEmailToAdminListener',
        'InetStudio\CommentsPackage\Comments\Contracts\Mail\Back\AnswerMailContract' => 'InetStudio\CommentsPackage\Comments\Mail\Back\AnswerMail',
        'InetStudio\CommentsPackage\Comments\Contracts\Mail\Front\NewItemMailContract' => 'InetStudio\CommentsPackage\Comments\Mail\Front\NewItemMail',
        'InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract' => 'InetStudio\CommentsPackage\Comments\Models\CommentModel',
        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Back\AnswerNotificationContract' => 'InetStudio\CommentsPackage\Comments\Notifications\Back\AnswerNotification',
        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Back\AnswerQueueableNotificationContract' => 'InetStudio\CommentsPackage\Comments\Notifications\Back\AnswerQueueableNotification',
        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Front\NewItemNotificationContract' => 'InetStudio\CommentsPackage\Comments\Notifications\Front\NewItemNotification',
        'InetStudio\CommentsPackage\Comments\Contracts\Notifications\Front\NewItemQueueableNotificationContract' => 'InetStudio\CommentsPackage\Comments\Notifications\Front\NewItemQueueableNotification',
        'InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ModerateServiceContract' => 'InetStudio\CommentsPackage\Comments\Services\Back\ModerateService',
        'InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\CommentsPackage\Comments\Services\Back\ItemsService',
        'InetStudio\CommentsPackage\Comments\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\CommentsPackage\Comments\Services\Back\DataTableService',
        'InetStudio\CommentsPackage\Comments\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\CommentsPackage\Comments\Services\Front\ItemsService',
        'InetStudio\CommentsPackage\Comments\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\CommentsPackage\Comments\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\CommentsPackage\Comments\Contracts\Transformers\Front\ItemTransformerContract' => 'InetStudio\CommentsPackage\Comments\Transformers\Front\ItemTransformer',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}

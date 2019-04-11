<?php

namespace InetStudio\Comments\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use InetStudio\Comments\Contracts\Services\Front\CommentsServiceContract;
use InetStudio\Comments\Contracts\Http\Responses\Front\GetCommentsResponseContract;
use InetStudio\Comments\Contracts\Http\Responses\Front\SendCommentResponseContract;
use InetStudio\Comments\Contracts\Http\Controllers\Front\CommentsControllerContract;

/**
 * Class CommentsController.
 */
class CommentsController extends Controller implements CommentsControllerContract
{
    /**
     * Отправка комментария.
     *
     * @param CommentsServiceContract $commentsService
     * @param Request $request
     * @param string $type
     * @param string $id
     *
     * @return SendCommentResponseContract
     */
    public function sendComment(CommentsServiceContract $commentsService,
                                Request $request,
                                string $type,
                                string $id): SendCommentResponseContract
    {
        $rules = [
            'message' => 'required',
        ];

        if (! auth()->user()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:255',
                'email' => 'required|max:255|email',
                'g-recaptcha-response' => [
                    'required',
                    new CaptchaRule,
                ],
            ]);
        }

        Validator::make($request->all(), $rules, [
            'message.required' => 'Поле «Сообщение» обязательно для заполнения',
            'name.required' => 'Поле «Имя» обязательно для заполнения',
            'name.max' => 'Поле «Имя» не должно превышать 255 символов',
            'email.required' => 'Поле «Email» обязательно для заполнения',
            'email.max' => 'Поле «Email» не должно превышать 255 символов',
            'email.email' => 'Поле «Email» должно содержать значение в корректном формате',
            'g-recaptcha-response.required' => 'Поле «Капча» обязательно для заполнения',
            'g-recaptcha-response.captcha'  => 'Неверный код капча',
        ])->validate();

        $data = $request->only($commentsService->getModel()->getFillable());

        $item = $commentsService->saveComment($data, $type, $id);

        $result = ($item && isset($item->id));

        return app()->makeWith(SendCommentResponseContract::class, compact('result'));
    }

    /**
     * Получаем комментарии к материалу.
     *
     * @param CommentsServiceContract $commentsService
     * @param Request $request
     * @param string $type
     * @param string $id
     *
     * @return GetCommentsResponseContract
     */
    public function getComments(CommentsServiceContract $commentsService,
                                Request $request,
                                string $type,
                                string $id): GetCommentsResponseContract
    {
        $page = ($request->filled('page')) ? $request->get('page') - 1 : 0;
        $limit = ($request->filled('limit')) ? $request->get('limit') : 3;

        $items = $commentsService->getCommentsTreeByTypeAndId($type, $id)->sortByDesc('datetime');

        return app()->makeWith(GetCommentsResponseContract::class, [
            'data' => [
                'comments' => [
                    'stop' => (($page + 1) * $limit >= $items->count()),
                    'items' => $items->slice($page * $limit, $limit),
                ],
            ]
        ]);
    }
}

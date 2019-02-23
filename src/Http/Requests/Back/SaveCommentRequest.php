<?php

namespace InetStudio\Comments\Http\Requests\Back;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Comments\Contracts\Http\Requests\Back\SaveCommentRequestContract;

/**
 * Class SaveCommentRequest.
 */
class SaveCommentRequest extends FormRequest implements SaveCommentRequestContract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'message.text.required' => 'Поле «Ответ на комментарий» обязательно для заполнения',
            'is_active.required' => 'Поле «Активность» обязательно для заполнения',
            'is_active.boolean' => 'Поле «Активность» должно содержать логическое значение',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request): array
    {
        $rules = ($request->filled('parent_comment_id')) ? [
            'message.text' => 'required',
        ] : [
            'is_active' => 'required|boolean',
        ];

        return $rules;
    }
}

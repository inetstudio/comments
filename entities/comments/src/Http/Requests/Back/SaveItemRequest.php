<?php

namespace InetStudio\CommentsPackage\Comments\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Back\SaveItemRequestContract;

/**
 * Class SaveItemRequest.
 */
class SaveItemRequest extends FormRequest implements SaveItemRequestContract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
     * @return array
     */
    public function rules(): array
    {
        $rules = ($this->filled('parent_comment_id'))
            ? [
                'message.text' => 'required',
            ]
            : [
                'is_active' => 'required|boolean',
            ];

        return $rules;
    }
}

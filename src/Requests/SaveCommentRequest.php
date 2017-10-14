<?php

namespace InetStudio\Comments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCommentRequest extends FormRequest
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
    public function messages()
    {
        return [
            'is_active.required' => 'Поле «Активность» обязательно для заполнения',
            'is_active.boolean' => 'Поле «Активность» должно содержать логическое значение',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_active' => 'required|boolean',
        ];
    }
}

<?php

namespace InetStudio\CommentsPackage\Comments\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\CaptchaPackage\Captcha\Validation\Rules\CaptchaRule;
use InetStudio\CommentsPackage\Comments\Contracts\Http\Requests\Front\SendItemRequestContract;

/**
 * Class SendItemRequest.
 */
class SendItemRequest extends FormRequest implements SendItemRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
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
            'message.required' => 'Поле «Сообщение» обязательно для заполнения',

            'name.required' => 'Поле «Имя» обязательно для заполнения',
            'name.max' => 'Поле «Имя» не должно превышать 255 символов',

            'email.required' => 'Поле «Email» обязательно для заполнения',
            'email.max' => 'Поле «Email» не должно превышать 255 символов',
            'email.email' => 'Поле «Email» должно содержать значение в корректном формате',

            'g-recaptcha-response.required' => 'Поле «Капча» обязательно для заполнения',
            'g-recaptcha-response.captcha' => 'Неверный код капча',

            'files.*.mimes' => 'Допустимый формат изображений - jpeg, jpg, png',
            'files.*.max' => 'Максимальный размер изображения - 5 Мб',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'message' => 'required',
            'files.*' => 'required|mimes:jpg,jpeg,png|max:5000',
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

        return $rules;
    }
}

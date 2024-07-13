<?php

namespace App\Http\Requests\User;

use App\Exceptions\ErrorException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\ErrorMessagesRepository;
use Illuminate\Contracts\Validation\Validator;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'current_password' => ['required', 'current_password', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'password'         => ['required', Password::defaults(), 'confirmed', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
        ];
    }

    public function messages() : array
    {
        return [
            'current_password.required'         => ErrorMessagesRepository::getMessage('current_password_required'),
            'current_password.current_password' => ErrorMessagesRepository::getMessage('current_password_incorrect'),
            'current_password.min'              => ErrorMessagesRepository::getMessage('current_password_min'),
            'current_password.regex'            => ErrorMessagesRepository::getMessage('current_password_regex'),
            'password.min'                      => ErrorMessagesRepository::getMessage('password_min'),
            'password.regex'                    => ErrorMessagesRepository::getMessage('password_regex'),
            'password.required'                 => ErrorMessagesRepository::getMessage('password_required'),
            'password.confirmed'                => ErrorMessagesRepository::getMessage('password_confirmed')
        ];
    }

    /**
     * failedValidation
     *
     * @param  mixed $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {

        if ($validator->stopOnFirstFailure()->fails()) {
            throw new ErrorException(['message' => $validator->errors()->first()]);
        }
    }
}

<?php

namespace App\Http\Requests\User;

use App\Core\Helpers\Validation;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
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
            'current_password' => ['required', 'current_password', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            'password'         => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
        ];
    }

    public function messages() : array
    {
        return [
            '*.required'                        => __('validation.required'),
            '*.min'                             => __('validation.min'),
            'current_password.current_password' => __('validation.current_password'),
            'password.confirmed'                => __('validation.confirmed'),
        ];
    }

    public function attributes() : array
    {
        return [
            'current_password' => __('validation.attributes.current_password'),
            'password'         => __('validation.attributes.password'),
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
        Validation::failedValidation($validator);
    }
}

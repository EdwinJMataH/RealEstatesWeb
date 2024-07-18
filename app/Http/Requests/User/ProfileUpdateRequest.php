<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Core\Helpers\Validation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['string', 'max:255', 'required'],
            'email' => ['email', 'max:255', 'required', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function messages()
    {

        return [
            '*.required'   => __('validation.required'),
            '*.max'        => __('validation.max'),
            'email.email'  => __('validation.email'),
            'name.string'  => __('validation.string'),
            'email.unique' => __('validation.unique'),
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

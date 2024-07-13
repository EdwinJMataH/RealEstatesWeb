<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Exceptions\ErrorException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\ErrorMessagesRepository;
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
            'name.required'     => ErrorMessagesRepository::getMessage('name_required'),
            'name.string'       => ErrorMessagesRepository::getMessage('name_string'),
            'name.max'          => ErrorMessagesRepository::getMessage('name_max'),
            'email.required'    => ErrorMessagesRepository::getMessage('email_required'),
            'email.email'       => ErrorMessagesRepository::getMessage('email_email'),
            'email.max'         => ErrorMessagesRepository::getMessage('email_max'),
            'email.unique'      => ErrorMessagesRepository::getMessage('email_unique'),
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

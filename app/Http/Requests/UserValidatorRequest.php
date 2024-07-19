<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Core\Helpers\Validation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserValidatorRequest extends FormRequest
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
    public function rules(): array
    {
        $unique_user = Rule::unique(User::class)->whereNull('deleted_at');
        
        $rules = [
            'email'   => ['email', 'string', 'max:255', 'required', $unique_user],
            'profile' => ['required'],
        ];

        if ($this->routeIs('users.update')) {
            $uuid = $this->route('uuid');
            array_pop($rules['email']);
            $rules['email'][] = $unique_user->ignore($uuid, 'uuid');
        }

        return $rules;
    }

    public function messages() : array
    {
        return [
            '*.required'   => __('validation.required'),
            '*.max'        => __('validation.max'),
            'email.email'  => __('validation.email'),
            'email.string' => __('validation.string'),
            'email.unique' => __('validation.unique'),
        ];
    }

    public function attributes() : array
    {
        return [
            'profile' => __('validation.attributes.type_profile'),
            // 'type'    => __('validation.attributes.type_permission'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Validation::failedValidation($validator);
    }
}

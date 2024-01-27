<?php

namespace App\Validations;

class UserUpdateValidation extends Validation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(request('id')),
            ],
            'confirm_password' => 'same:password',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => lang('The name field is required.'),
            'email.required' => lang('The email field is required.'),
            'email.email' => lang('You must enter a valid email.'),
            'email.unique' => lang('This email is already registered.'),
            'confirm_password.same' => lang('Passwords do not match.'),
        ];
    }
}

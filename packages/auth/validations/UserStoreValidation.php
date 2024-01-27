<?php

namespace App\Validations;

class UserStoreValidation extends Validation
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
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
            'password.required' => lang('The password field is required.'),
            'password.min' => lang('The password field must be greater than or equal to 8 characters.'),
            'confirm_password.same' => lang('Passwords do not match.'),
        ];
    }
}

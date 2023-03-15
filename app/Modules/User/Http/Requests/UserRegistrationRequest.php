<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:40'],
            'last_name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'unique:users,email', 'max:100'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }
}

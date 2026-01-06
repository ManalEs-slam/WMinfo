<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email,' . $userId],
            'phone' => ['nullable', 'string', 'max:30'],
            'language' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:60'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];
    }
}

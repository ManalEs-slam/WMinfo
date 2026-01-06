<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email,' . $userId],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', 'in:admin,editor,reader'],
            'status' => ['required', 'in:active,inactive'],
            'permissions' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'password' => [$userId ? 'nullable' : 'required', 'confirmed', 'min:8'],
        ];
    }
}

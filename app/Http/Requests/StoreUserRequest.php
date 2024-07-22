<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'firstname.*' => 'required|string|max:255',
            'lastname.*' => 'nullable|string|max:255',
            'email.*' => 'required|email|max:255|unique:users,email',
            'password.*' => 'required|string|min:8',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about' => 'nullable|string|max:255',
            'user_type' => 'required|string|in:user,admin',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}

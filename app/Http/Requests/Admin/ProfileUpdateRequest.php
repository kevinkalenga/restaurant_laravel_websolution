<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
         // users the table in db, email is the column
        return [
            'avatar' => ['nullable', 'image', 'max:3000'],
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:200', 'unique:users,email,'.Auth()->user()->id]
        ];
    }
}

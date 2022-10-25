<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users|string|max:255|email',
            'password' => 'required|string|min:6',
            'role_id' => 'required',
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'province' => 'required|string',
            'city' => 'required|string',
            'districts' => 'required|string',
            'ward' => 'required|string',
        ];
    }
}

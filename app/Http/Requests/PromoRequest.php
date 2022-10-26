<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
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
            'promo_code' => 'required|unique:promos|string|min:6',
            'promo_title' => 'required|string',
            'promo_description' => 'required|string',
            'promo_end' => 'required',
            'promo_total' => 'required|numeric',
        ];
    }
}

<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
{
    return [
        'menu_id'          => ['required', 'integer', 'exists:menus,id'],
        'quantity'         => ['nullable', 'integer', 'min:1', 'max:99'],
        'notes'            => ['nullable', 'string', 'max:200'],
        'customizations'   => ['nullable', 'array'],
        'customizations.*' => ['nullable', 'string', 'max:200'],
    ];
}

    public function messages(): array
    {
        return [
            'menu_id.exists' => 'Menu yang dipilih tidak ditemukan.',
            'quantity.max' => 'Maksimal 99 item per sekali pesan.',
        ];
    }
}

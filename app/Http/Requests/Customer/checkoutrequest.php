<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_type'     => ['required', 'in:dine_in,takeaway,delivery'],
            'special_notes'  => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:cash,qris,transfer,cod'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'Pilih metode pembayaran.',
            'payment_method.in'       => 'Metode pembayaran tidak valid.',
        ];
    }
}
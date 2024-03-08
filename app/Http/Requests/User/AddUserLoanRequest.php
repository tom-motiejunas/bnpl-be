<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddUserLoanRequest extends FormRequest
{
    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'payment_method_id' => 'required|string|max:255',
            'order_id' => 'required|integer',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'payment_method_id' => 'Payment method identifier is required',
            'order_id' => 'Order id is required',
        ];
    }
}

<?php

namespace App\Http\Requests\Orders;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $orderId = $this->route('order');

        $commonRules = [
            'status' => 'sometimes|string|in:pending,processing,paid,cancelled,refunded',
            'currency' => 'sometimes|string|size:3',
            'notes' => 'sometimes|nullable|string',
            'user_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'order_address_id' => ['sometimes', 'nullable', 'exists:order_addresses,id'],
        ];

        if ($this->isMethod('post')) {
            return [
                ...$commonRules,
                'number' => 'sometimes|nullable|string|max:255|unique:orders,number',
                'total' => 'required|numeric|min:0',
                'currency' => 'required|string|size:3',
                'user_id' => ['required', 'exists:users,id'],
                'order_address_id' => ['required', 'exists:order_addresses,id'],
            ];
        }

        return [
            ...$commonRules,
            'number' => ['sometimes', 'nullable', 'string', 'max:255', 'unique:orders,number,' . $orderId],
            'total' => ['sometimes', 'nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'status.in' => 'The selected status is invalid.',
            'currency.size' => 'The currency must be a 3-letter ISO 4217 code.',
            'user_id.required' => 'A user is required.',
            'order_address_id.required' => 'An order address is required.',
            'total.required' => 'The total amount is required.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'order_address_id' => 'order address',
            'user_id' => 'user',
        ];
    }
}

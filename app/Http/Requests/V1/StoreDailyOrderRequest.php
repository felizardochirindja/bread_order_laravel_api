<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDailyOrderRequest extends FormRequest
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
            'day' => ['required'],
            'total' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'productPrice' => ['required'],
            'notes' => ['required'],
            'status' => ['required', Rule::in(['overdue', 'pending', 'paid'])],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_price' => $this->productPrice,
        ]);
    }
}

<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDailyOrderRequest extends FormRequest
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
        if ($this->method() == 'PUT') {
            return [
                'day' => ['required'],
                'total' => ['required', 'numeric'],
                'quantity' => ['required', 'numeric'],
                'productPrice' => ['required'],
                'notes' => ['required'],
                'status' => ['required', Rule::in(['overdue', 'pending', 'paid'])],
            ];
        }

        return [
            'day' => ['sometimes', 'required'],
            'total' => ['sometimes', 'required', 'numeric'],
            'quantity' => ['sometimes', 'required', 'numeric'],
            'productPrice' => ['sometimes', 'required'],
            'notes' => ['sometimes', 'required'],
            'status' => ['sometimes', 'required', Rule::in(['overdue', 'pending', 'paid'])],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->productPrice) {
            $this->merge([
                'product_price' => $this->productPrice,
            ]);
        }
    }
}

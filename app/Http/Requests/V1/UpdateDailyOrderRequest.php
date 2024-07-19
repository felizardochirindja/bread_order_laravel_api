<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

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
                'quantity' => ['required', 'numeric'],
                'notes' => ['required'],
            ];
        }

        return [
            'quantity' => ['sometimes', 'required', 'numeric'],
            'notes' => ['sometimes', 'required'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'idempotency_key' => $this->header('Idempotency-Key'),
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idempotency_key' => ['required', 'string'],

            'items' => ['required', 'array', 'min:1'],

            'items.*.book_id' => [
                'required',
                'integer',
                'exists:books,id'
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Order must have at least one item',
            'items.array' => 'Items must be an array',
            'items.*.book_id.exists' => 'One of the books does not exist',
        ];
    }



//
//    public function withValidator($validator)
//    {
//        $validator->after(function ($validator) {
//
//            if (!$this->header('Idempotency-Key')) {
//                $validator->errors()->add(
//                    'idempotency_key',
//                    'Idempotency-Key header is required'
//                );
//            }
//        });
//    }

}

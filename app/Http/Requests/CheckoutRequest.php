<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address' => 'required|string|max:255',
            'nif' => 'required|digits:9',
            'payment_option' => 'required|string|in:"VISA","MC","PAYPAL"',
            'ref' => 'required',
            'notes' =>  'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => 'Address é obrigatorio',
            'address.string' => 'Address tem que ser uma string',
            'address.max' => 'Address tem um maximo de 255 caracteres',

            'nif.required' => 'Nif é obrigatorio',

            'payment_option.required' => 'A tipo de pagamento é obrigatorio',
            'payment_option.between' => 'Tipo de pagamento não é o permitido',

            'ref.required' => 'Referencia do tipo de pagamento obrigatório',
            'ref.email' => 'Referencia deve ser um email',
            'ref.digits' => 'Referencia deve conter 16 digitos'
        ];
    }
}

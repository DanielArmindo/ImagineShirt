<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'user_type' => 'required|in:"A","E"',
            'password' =>  'sometimes',
            'file_photo' => 'sometimes|image|max:4096'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatorio',
            'name.string' => 'O nome tem que ser uma string',
            'name.max' => 'O nome tem um maximo de 255 caracteres',

            'email.required' => 'O email é obrigatorio',
            'email.email' => 'O formato do email é inválido',

            'user_type.required' => 'O tipo de utilizador é obrigatorio',
            'user_type.between' => 'O tipo de utilizador não é o permitido',

            'file_photo.image' => 'O ficheiro com a foto não é uma imagem',
            'file_photo.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 4 Mb'
        ];
    }
}

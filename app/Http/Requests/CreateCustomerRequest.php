<?php

namespace App\Http\Requests;

use App\Rules\CpfOrCnpj;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CreateCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer.name' => 'required|string|max:255',
            'customer.email' => 'required|email|max:255',
            'customer.phone' => 'required|digits_between:10,11',
            'customer.cpfCnpj' => ['required', new CpfOrCnpj()], 
        ];
    }

    public function messages(): array
    {
        return [
            'customer.name.required' => 'O campo nome é obrigatório.',
            'customer.name.string' => 'O nome deve ser uma string.',
            'customer.name.max' => 'O nome não deve exceder 255 caracteres.',
    
            'customer.email.required' => 'O campo e-mail é obrigatório.',
            'customer.email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'customer.email.max' => 'O e-mail não deve exceder 255 caracteres.',
    
            'customer.phone.required' => 'O campo telefone é obrigatório.',
            'customer.phone.digits_between' => 'O telefone deve ter entre 10 e 11 dígitos.',
    
            'cpfCnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
            'cpfCnpj.cpf_cnpj' => 'O valor fornecido não é um CPF ou CNPJ válido.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], 422)
        );
    }
}

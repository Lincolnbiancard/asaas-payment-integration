<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ProcessPaymentCreationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->billingType === 'CREDIT_CARD') {
            return [
                'payment.billingType' => 'required|string|in:BOLETO,PIX,CREDIT_CARD',
                'payment.value' => 'required|numeric',
                'payment.description' => 'required|string',
                'payment.externalReference' => 'required|string',
                'payment.creditCard.holderName' => 'required|string',
                'payment.creditCard.number' => 'required|digits:16',  // Aqui estou assumindo que é um cartão de 16 dígitos
                'payment.creditCard.expiryMonth' => 'required|digits:2',
                'payment.creditCard.expiryYear' => 'required|digits:4',
                'payment.creditCard.ccv' => 'required|digits_between:3,4',
                'payment.creditCardHolderInfo.name' => 'required|string',
                'payment.creditCardHolderInfo.email' => 'required|email',
                'payment.creditCardHolderInfo.cpfCnpj' => 'required|string',
                'payment.creditCardHolderInfo.phone' => 'required|string',
                'payment.creditCardHolderInfo.postalCode' => 'required|regex:/^[0-9]{5}-[0-9]{3}$/',
                'payment.creditCardHolderInfo.addressNumber' => 'required|string',
                'payment.creditCardToken' => 'required|string',
            ];
        }

        return ['payment.billingType' => 'required|string|in:BOLETO,PIX,CREDIT_CARD'];
    }

    public function messages(): array
    {
        return [
            'payment.billingType.required' => 'O tipo de cobrança é obrigatório.',
            'payment.billingType.string' => 'O tipo de cobrança deve ser um texto.',
            'payment.billingType.in' => 'O tipo de cobrança deve ser BOLETO, PIX ou CREDIT_CARD.',
            'payment.value.required' => 'O valor é obrigatório.',
            'payment.value.numeric' => 'O valor deve ser numérico.',
            'payment.description.required' => 'A descrição é obrigatória.',
            'payment.description.string' => 'A descrição deve ser um texto.',
            'payment.externalReference.required' => 'A referência externa é obrigatória.',
            'payment.externalReference.string' => 'A referência externa deve ser um texto.',
            'payment.creditCard.holderName.required' => 'O nome do titular do cartão é obrigatório.',
            'payment.creditCard.holderName.string' => 'O nome do titular do cartão deve ser um texto.',
            'payment.creditCard.number.required' => 'O número do cartão é obrigatório.',
            'payment.creditCard.number.digits' => 'O número do cartão deve ter 16 dígitos.',
            'payment.creditCard.expiryMonth.required' => 'O mês de expiração é obrigatório.',
            'payment.creditCard.expiryMonth.digits' => 'O mês de expiração deve ter 2 dígitos.',
            'payment.creditCard.expiryYear.required' => 'O ano de expiração é obrigatório.',
            'payment.creditCard.expiryYear.digits' => 'O ano de expiração deve ter 4 dígitos.',
            'payment.creditCard.ccv.required' => 'O código de segurança é obrigatório.',
            'payment.creditCard.ccv.digits_between' => 'O código de segurança deve ter entre 3 e 4 dígitos.',
            'payment.creditCardHolderInfo.name.required' => 'O nome do titular do cartão é obrigatório.',
            'payment.creditCardHolderInfo.name.string' => 'O nome do titular do cartão deve ser um texto.',
            'payment.creditCardHolderInfo.email.required' => 'O email é obrigatório.',
            'payment.creditCardHolderInfo.email.email' => 'O email deve ser um email válido.',
            'payment.creditCardHolderInfo.cpfCnpj.required' => 'O CPF/CNPJ é obrigatório.',
            'payment.creditCardHolderInfo.cpfCnpj.string' => 'O CPF/CNPJ deve ser um texto.',
            'payment.creditCardHolderInfo.phone.required' => 'O telefone é obrigatório.',
            'payment.creditCardHolderInfo.phone.string' => 'O telefone deve ser um texto.',
            'payment.creditCardHolderInfo.postalCode.required' => 'O código postal é obrigatório.',
            'payment.creditCardHolderInfo.postalCode.regex' => 'O código postal não está no formato correto.',
            'payment.creditCardHolderInfo.addressNumber.required' => 'O número do endereço é obrigatório.',
            'payment.creditCardHolderInfo.addressNumber.string' => 'O número do endereço deve ser um texto.',
            'payment.creditCardToken.required' => 'O token do cartão de crédito é obrigatório.',
            'payment.creditCardToken.string' => 'O token do cartão de crédito deve ser um texto.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        $flattenedErrors = [];
        foreach ($errors as $error) {
            $flattenedErrors = array_merge($flattenedErrors, $error);
        }

        throw new HttpResponseException(
            response()->json(['errors' => $flattenedErrors], 422)
        );
    }
}

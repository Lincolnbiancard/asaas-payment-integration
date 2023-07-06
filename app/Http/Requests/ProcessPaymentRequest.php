<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessPaymentRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'customer' => 'required|string|max:20',  // Exemplo de regras
            'billingType' => 'required|string|in:BOLETO,PIX',  // Deve ser BOLETO ou PIX
            'dueDate' => 'required|date',
            'value' => 'required|numeric',
        ];
    }
}

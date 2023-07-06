<?php

namespace App\Services;

use App\Interfaces\PaymentServiceInterface;
use Illuminate\Support\Facades\Http;

class AsaasPaymentService implements PaymentServiceInterface
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('ASAAS_API_URL');
    }
    public function processPayment($paymentData)
    {
        $response = Http::withHeaders([
            'access_token' => env('ASAAS_API_TOKEN'),
            'Accept' => 'application/json'
        ])
        ->post($this->apiUrl . '/api/v3/payments', $paymentData);

        if ($response->successful()) {
            return $response->json();
        }

        // Tratamento de erros de acordo com a API do Asaas
    }
}
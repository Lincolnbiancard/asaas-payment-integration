<?php

namespace App\Services;

use App\Interfaces\CustomerServiceInterface;
use Illuminate\Support\Facades\Http;

class AsaasCustomerService implements CustomerServiceInterface
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('ASAAS_API_URL');
    }

    public function create($customerData)
    {
        $response = Http::withHeaders([
            'access_token' => env('ASAAS_API_TOKEN'),
            'Accept' => 'application/json'
        ])
        ->post($this->apiUrl . '/api/v3/customers', $customerData);
        
        if ($response->successful()) {
            return $response->json();
        }

        return response($response->body(), $response->status());

        // Tratamento de erros de acordo com a API do Asaas
    }
}




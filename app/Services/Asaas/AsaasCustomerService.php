<?php

namespace App\Services\Asaas;

use App\Domain\UseCases\Customer\CustomerServiceInterface;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Http;

class AsaasCustomerService implements CustomerServiceInterface
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('ASAAS_API_URL');
    }

    public function findOrCreate(array $customerData)
    {
        if (!is_null($customerData['customer_id'])) {
            $response = Http::withHeaders([
                'access_token' => env('ASAAS_API_TOKEN'),
                'Accept' => 'application/json'
            ])->get($this->apiUrl . '/api/v3/customers/' . $customerData['customer_id']);

            if ($response->successful() && !$response->json()['deleted']) {
                return $this->normalizeCustomerData($response->json());
            }
        }
        return $this->create($customerData);
    }

    public function create($customerData)
    {
        unset($customerData['id']); // asass não aceita id no cadastro?!
        $response = Http::withHeaders([
            'access_token' => env('ASAAS_API_TOKEN'),
            'Accept' => 'application/json'
        ])->post($this->apiUrl . '/api/v3/customers', $customerData);

        if ($response->successful()) {
            $normalizedData = $this->normalizeCustomerData($response->json());
            (new CustomerService())->update($normalizedData);
            return $normalizedData;
        }

        throw new \Exception('Houve um problema com o nosso provedor de pagamentos. Por favor, entre em contato com o suporte.');
    }


    public function normalizeCustomerData(array $data): array
    {
        return [
            'customer_id' => $data['id'] ?? $data['customer_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'cpfCnpj' => $data['cpfCnpj']
        ];
    }

}




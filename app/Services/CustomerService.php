<?php

namespace App\Services;

use App\Domain\UseCases\Payment\Customer\CustomerServiceInterface;
use App\Models\Customer;
use Exception;

class CustomerService implements CustomerServiceInterface
{
    public function findOrCreate(array $customerData)
    {
        $customer = $this->find($customerData['cpfCnpj']);
        if ($customer) {
            return $this->normalizeCustomerData($customer->toArray()); 
        }
        
        try {
            $customer = Customer::create(
                [
                    'customer_id' => $customerData['customer_id'] ?? null,
                    'name' => $customerData['name'],
                    'email' => $customerData['email'],
                    'cpfCnpj' => $customerData['cpfCnpj'],
                    'phone' => $customerData['phone'],
                ]
            );
            return $this->normalizeCustomerData($customer->toArray());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($customerData)
    {
        $customer = $this->find($customerData['cpfCnpj']);
        try {
            $customer->update([
                'customer_id' => $customerData['customer_id'] ?? null,
                'name' => $customerData['name'],
                'email' => $customerData['email'],
                'cpfCnpj' => $customerData['cpfCnpj'],
                'phone' => $customerData['phone'],
            ]);
            return $this->normalizeCustomerData($customer->toArray());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function normalizeCustomerData($customer): array
    {
        return [
            'customer_id' => $customer['customer_id'],
            'name' => $customer['name'],
            'email' => $customer['email'],
            'phone' => $customer['phone'],
            'cpfCnpj' => $customer['cpfCnpj']
        ];
    }

    private function find($cpfCnpj)
    {
        return Customer::where('cpfCnpj', $cpfCnpj)->first();
    }
}
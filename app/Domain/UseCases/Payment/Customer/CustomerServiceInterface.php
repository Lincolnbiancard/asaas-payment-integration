<?php

namespace App\Domain\UseCases\Payment\Customer;


interface CustomerServiceInterface
{
    public function findOrCreate(array $customerData);
    public function normalizeCustomerData(array $data): array;
}
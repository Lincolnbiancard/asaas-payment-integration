<?php 

namespace App\Domain\UseCases;

use App\Exceptions\PaymentProcessingException;
use App\Services\Asaas\AsaasCustomerService;
use App\Services\CustomerService;
use Carbon\Carbon;

class PaymentBusinessRulesService
{
    /**
     * Get due date
     *
     * @return Carbon
     */
    public function getDueDate(): Carbon
    {
        // adicionar lógica para obter a data de vencimento aqui
        return now()->addDays(5);
    }

    /**
     * Get Customer ID
     *
     * @param array $paymentData
     * @param array $customerServices
     * @return string
     */
    public function getCustomerId(array $paymentData, array $customerServices): string
    {
        $customerData = $paymentData['customer'];
        foreach($customerServices as $service) {
            $customerData = $service->findOrCreate($customerData);
        }

        return $customerData['customer_id'];
    }
}

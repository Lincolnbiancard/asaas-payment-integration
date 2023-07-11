<?php 

namespace App\Domain\UseCases\Payment;
use Carbon\Carbon;

class PaymentBusinessRulesService
{
    public function getDueDate(): Carbon
    {
        return now()->addDays(5);
    }

    public function getCustomerId(array $paymentData, array $customerServices): string
    {
        $customerData = $paymentData['customer'];
        // this foreach is because we can have several ways to save the client in the system, today we have it in asaas and in the DB
        foreach($customerServices as $service) {
            $customerData = $service->findOrCreate($customerData);
        }

        return $customerData['customer_id'];
    }
}

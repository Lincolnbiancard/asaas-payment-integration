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
        foreach($customerServices as $service) {
            $customerData = $service->findOrCreate($customerData);
        }

        return $customerData['customer_id'];
    }
}

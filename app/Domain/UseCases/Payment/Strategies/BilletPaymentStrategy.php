<?php

namespace App\Domain\UseCases\Payment\Strategies;

class BilletPaymentStrategy implements PaymentMethodStrategy
{
    public function prepareData($paymentData, $extraData = null): array
    {
        $paymentData['payment']['billingType'] = 'BOLETO';

        return $paymentData;
    }
}

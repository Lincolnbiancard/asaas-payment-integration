<?php

namespace App\Domain\UseCases\Payment\Strategies;

class PixPaymentStrategy implements PaymentMethodStrategy
{
    public function prepareData($paymentData, $extraData = null): array
    {
        $paymentData['payment']['billingType'] = 'PIX';

        return $paymentData;
    }
}

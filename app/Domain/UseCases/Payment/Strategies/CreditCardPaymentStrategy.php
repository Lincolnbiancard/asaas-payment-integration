<?php

namespace App\Domain\UseCases\Payment\Strategies;

class CreditCardPaymentStrategy implements PaymentMethodStrategy
{
    public function prepareData($paymentData, $extraData = null): array
    {
        $creditCardData = $extraData['creditCardData'] ?? null;
        $creditCardHolderInfo = $extraData['creditCardHolderInfo'] ?? null;

        $paymentData['payment']['billingType'] = 'CREDIT_CARD';

        // Add the credit card information
        if (isset($paymentData['payment']['creditCardToken'])) {
            $paymentData['payment']['creditCardToken'] = $paymentData['payment']['creditCardToken'];
        } else {
            $paymentData['payment']['creditCard'] = $creditCardData;
            $paymentData['payment']['creditCardHolderInfo'] = $creditCardHolderInfo;
        }

        return $paymentData;
    }
}

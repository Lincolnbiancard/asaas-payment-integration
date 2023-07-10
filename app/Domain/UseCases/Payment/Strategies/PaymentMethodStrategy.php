<?php 

namespace App\Domain\UseCases\Payment\Strategies;

interface PaymentMethodStrategy
{
    public function prepareData($paymentData, $extraData): array;
}
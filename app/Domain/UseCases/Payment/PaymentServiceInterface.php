<?php

namespace App\Domain\UseCases\Payment;

interface PaymentServiceInterface
{
    public function processPaymentCreation(array $paymentDetails);
    
}
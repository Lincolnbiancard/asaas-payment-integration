<?php

namespace App\Domain\UseCases\Payment;

interface PaymentServiceInterface
{
    public function processPayment(array $paymentDetails);
    
}
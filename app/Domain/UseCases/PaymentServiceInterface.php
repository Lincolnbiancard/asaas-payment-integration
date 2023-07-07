<?php

namespace App\Domain\UseCases;

interface PaymentServiceInterface
{
    public function processPayment(array $paymentDetails);
    
}
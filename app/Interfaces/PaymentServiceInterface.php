<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{
    public function processPayment(array $paymentDetails);
}
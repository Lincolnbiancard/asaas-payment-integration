<?php 

interface CustomerInterface
{
    public function processPayment(array $paymentDetails);
}
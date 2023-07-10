<?php

namespace App\Factories;

use App\Domain\UseCases\Payment\Strategies\BilletPaymentStrategy;
use App\Domain\UseCases\Payment\Strategies\CreditCardPaymentStrategy;
use App\Domain\UseCases\Payment\Strategies\PixPaymentStrategy;

class PaymentStrategyFactory
{
    public static function make($billingType)
    {
        switch ($billingType) {
            case 'BOLETO':
                return new BilletPaymentStrategy();
            case 'PIX':
                return new PixPaymentStrategy();
            case 'CREDIT_CARD':
                return new CreditCardPaymentStrategy();
            default:
                throw new \Exception("Tipo De Pagamento Inválido.");
        }
    }
}

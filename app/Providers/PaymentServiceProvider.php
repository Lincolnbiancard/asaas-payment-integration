<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Domain\UseCases\Payment\PaymentServiceInterface',
            'App\Services\Asaas\AsaasPaymentService'  
        );
    }
}
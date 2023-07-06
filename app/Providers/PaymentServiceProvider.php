<?php

namespace App\Providers;

use App\Interfaces\PaymentServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\AsaasSimulatedPaymentService;
use App\Services\AsaasPaymentService;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PaymentServiceInterface::class, function($app) {
            // if ($app->environment('testing')) {
            //     return new AsaasSimulatedPaymentService();
            // }
            return new AsaasPaymentService();
        });
    }
}
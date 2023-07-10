<?php

namespace App\Providers;

use App\Domain\UseCases\Payment\Customer\CustomerServiceInterface;
use App\Services\Asaas\AsaasCustomerService;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CustomerServiceInterface::class, function($app) {
            return new AsaasCustomerService();
        });
    }
}
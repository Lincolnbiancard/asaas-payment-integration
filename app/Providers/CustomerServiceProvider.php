<?php

namespace App\Providers;

use App\Interfaces\CustomerServiceInterface;
use App\Services\AsaasCustomerService;
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
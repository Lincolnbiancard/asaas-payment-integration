<?php

namespace App\Http\Controllers;

use App\Domain\UseCases\Payment\Customer\CustomerServiceInterface;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }
}

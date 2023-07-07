<?php

namespace App\Http\Controllers;

use App\Domain\UseCases\CustomerServiceInterface;
use App\Http\Requests\CreateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }
}

<?php

namespace App\Http\Controllers;

use App\Interfaces\CustomerServiceInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    public function store(Request $request)
    {
        $customerData = $request->all();
        return $this->customerService->create($customerData);
    }
}

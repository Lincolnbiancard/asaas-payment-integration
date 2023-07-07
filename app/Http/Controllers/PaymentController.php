<?php

namespace App\Http\Controllers;

use App\Domain\UseCases\CustomerServiceInterface as UseCasesCustomerServiceInterface;
use App\Domain\UseCases\PaymentServiceInterface as UseCasesPaymentServiceInterface;
use App\Http\Requests\ProcessPaymentRequest;
use Exception;

class PaymentController extends Controller
{
    private $paymentService;
    private $customerService;

    public function __construct(UseCasesPaymentServiceInterface $paymentService, UseCasesCustomerServiceInterface $customerService)
    {
        $this->paymentService = $paymentService;
        $this->customerService = $customerService;    
    }

    public function store(ProcessPaymentRequest $request) //TODO validar tbm os campos do payment
    {
        try {
            $payment = $this->paymentService->processPayment($request->all());

            return response()->json(['success' => true, 'payment' => $payment], 201);

        } catch (Exception $e) {
            // Retorne uma resposta de erro adequada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
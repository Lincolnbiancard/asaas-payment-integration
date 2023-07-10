<?php

namespace App\Http\Controllers;

use App\Domain\UseCases\Payment\PaymentServiceInterface;
use App\Http\Requests\ProcessPaymentRequest;
use Exception;

class PaymentController extends Controller
{
    private $paymentService;
    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
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
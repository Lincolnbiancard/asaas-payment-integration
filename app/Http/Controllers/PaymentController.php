<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentServiceInterface;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function store(Request $request)
    {
        $paymentData = $request->all();
        return $this->paymentService->processPayment($paymentData);

        // Lógica de tratamento do resultado do pagamento
    }
}
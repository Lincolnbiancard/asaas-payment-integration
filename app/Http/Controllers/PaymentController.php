<?php

namespace App\Http\Controllers;

use App\Domain\UseCases\Payment\PaymentServiceInterface;
use App\Http\Requests\ProcessPaymentCreationRequest;
use App\Http\Resources\PaymentResource;
use Exception;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PaymentController extends Controller
{
    private PaymentServiceInterface $paymentService;
    private string $apiUrl;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
        $this->apiUrl = env('ASAAS_API_URL');
    }

    public function store(ProcessPaymentCreationRequest $request) //TODO validar tbm os campos do payment
    {
        try {
            $payment = $this->paymentService->processPaymentCreation($request->all());

            return new PaymentResource($payment);

        } catch (Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]], 400);
        }
    }

    public function pix($payId)
    {
        $response = Http::withHeaders([
            'access_token' => env('ASAAS_API_TOKEN'),
            'Accept' => 'application/json'
        ])
        ->post($this->apiUrl . '/api/v3/payments/'. $payId . '/pixQrCode');
        
        if (!$response->successful()) {
            $this->handleErrorResponse($response);
        }
    
        return $response->json();
    }

}
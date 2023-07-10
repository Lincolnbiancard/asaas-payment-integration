<?php

namespace App\Services\Asaas;

use App\Domain\UseCases\Payment\PaymentBusinessRulesService;
use App\Domain\UseCases\Payment\PaymentServiceInterface;
use App\Exceptions\PaymentProcessingException;
use App\Factories\PaymentStrategyFactory;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Http;

class AsaasPaymentService implements PaymentServiceInterface
{
    private $apiUrl;
    private $paymentBusinessRulesService;
    private $customerService;
    private $asaasCustomerService;

    public function __construct(
        PaymentBusinessRulesService $paymentBusinessRulesService,
        CustomerService $customerService,
        AsaasCustomerService $asaasCustomerService
    )
    {
        $this->apiUrl = env('ASAAS_API_URL');
        $this->paymentBusinessRulesService = $paymentBusinessRulesService;
        $this->customerService = $customerService;
        $this->asaasCustomerService = $asaasCustomerService;
    }

    public function processPayment($paymentData, $extraData = null)
    {
        $dueDate = $this->paymentBusinessRulesService->getDueDate();
        $customerId = $this->paymentBusinessRulesService->getCustomerId($paymentData, [$this->customerService, $this->asaasCustomerService]);

        $paymentData['payment']['dueDate'] = $dueDate->format('Y-m-d');
        $paymentData['payment']['customer'] = $customerId;

        // Add the payment method information - strategy pattern
        $paymentStrategy = PaymentStrategyFactory::make($paymentData['payment']['billingType']);
        $paymentData = $paymentStrategy->prepareData($paymentData, $extraData);

        $response = Http::withHeaders([
            'access_token' => env('ASAAS_API_TOKEN'),
            'Accept' => 'application/json'
        ])
        ->post($this->apiUrl . '/api/v3/payments', $paymentData['payment']);
        
        if ($response->successful()) {
            return $response->json();
        }

        throw new PaymentProcessingException("Erro ao tentar processar o pagamento.");
    }
}


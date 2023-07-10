<?php

namespace Tests\Feature;

use App\Domain\UseCases\Payment\PaymentBusinessRulesService;
use App\Services\Asaas\AsaasCustomerService;
use App\Services\Asaas\AsaasPaymentService;
use App\Services\CustomerService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class AsaasPaymentServiceTest extends TestCase
{
    use RefreshDatabase;
    
    private string $apiUrl;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->apiUrl = 'https://sandbox.asaas.com/api';
    }

    public function test_integration_with_payment_provider()
    {
        // Create the customer and payment data
        $customerData = [
            "name" => "Lincoln",
            "email" => "biancardilincoln@gmail.com",
            "phone" => "11992383641",
            "cpfCnpj" => "96054602039"
        ];

        $paymentData = [
            "billingType" => "BOLETO",
            "value" => 5
        ];

        $payload = ['customer' => $customerData, 'payment' => $paymentData];

        // Mock the PaymentBusinessRulesService
        $paymentBusinessRulesService = Mockery::mock(PaymentBusinessRulesService::class);
        $paymentBusinessRulesService->shouldReceive('getDueDate')->andReturn(Carbon::now());
        $paymentBusinessRulesService->shouldReceive('getCustomerId')->andReturn('cust_1234');

        // Mock the CustomerService
        $customerService = Mockery::mock(CustomerService::class);
        $customerService->shouldIgnoreMissing();

        // Mock the AsaasCustomerService
        $asaasCustomerService = Mockery::mock(AsaasCustomerService::class);
        $asaasCustomerService->shouldIgnoreMissing();

        // Create AsaasPaymentService instance
        $asaasPaymentService = new AsaasPaymentService($paymentBusinessRulesService, $customerService, $asaasCustomerService);

        // Mock the HTTP response
        Http::fake([
            $this->apiUrl . '/v3/payments*' => Http::response([
                "status" => "PENDING",
                "value" => 5,
                "dateCreated" => "2023-05-05T14:40:45Z",
                "customer" => "cust_1234"
            ], 200),
        ]);

        // Process the payment
        $response = $asaasPaymentService->processPayment($payload);

        // Check if payment was successful
        $this->assertEquals("PENDING", $response['status']);

        // Check if the amount is correct
        $this->assertEquals(5, $response['value']);

        // Check if customer id is correct
        $this->assertEquals('cust_1234', $response['customer']);
    }

    
    // public function testCustomerValidation(): void
    // {
    //     // This test would depend on how your validation works.
    //     // But you would want to check that an existing customer is found correctly,
    //     // and a new one is created when the customer data does not match an existing customer.
    // }

    // public function testPaymentDataValidation(): void
    // {
    //     // Similar to the customer validation test,
    //     // this would depend on how your validation works.
    //     // You would want to check that valid payment data passes validation,
    //     // and invalid data does not.
    // }

    // public function testErrorHandling(): void
    // {
    //     // You would want to check that when an error occurs (you can mock an error for this),
    //     // the system handles it correctly and returns a useful error message.
    // }
}

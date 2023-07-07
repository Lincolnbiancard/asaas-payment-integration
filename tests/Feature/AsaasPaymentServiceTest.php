<?php

namespace Tests\Feature;

use App\Domain\UseCases\PaymentBusinessRulesService;
use App\Services\Asaas\AsaasCustomerService;
use App\Services\Asaas\AsaasPaymentService;
use App\Services\CustomerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AsaasPaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_integration_with_payment_provider()
    {
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

        // Create the services instances
        $paymentBusinessRulesService = new PaymentBusinessRulesService();
        $customerService = new CustomerService();
        $asaasCustomerService = new AsaasCustomerService();

        // Create AsaasPaymentService instance
        $asaasPaymentService = new AsaasPaymentService($paymentBusinessRulesService, $customerService, $asaasCustomerService);

        // Process the payment
        $response = $asaasPaymentService->processPayment($payload);
        // Check if payment was successful
        $this->assertEquals("PENDING", $response['status']);
        
        // Check if the amount is correct
        $this->assertEquals(5, $response['value']);

        // Check if customer was created and has the expected data
        $this->assertDatabaseHas('customers', $customerData);
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

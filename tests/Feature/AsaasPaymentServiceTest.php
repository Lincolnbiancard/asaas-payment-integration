<?php

namespace Tests\Feature;

use App\Domain\UseCases\Payment\PaymentBusinessRulesService;
use App\Exceptions\PaymentProcessingException;
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
    private $paymentBusinessRulesService;
    private $customerService;
    private $asaasCustomerService;
    private $asaasPaymentService;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->apiUrl = 'https://sandbox.asaas.com/api';

        // Mock the PaymentBusinessRulesService
        $this->paymentBusinessRulesService = Mockery::mock(PaymentBusinessRulesService::class);
        $this->paymentBusinessRulesService->shouldReceive('getDueDate')->andReturn(Carbon::now());
        $this->paymentBusinessRulesService->shouldReceive('getCustomerId')->andReturn('cust_1234');

        // Mock the CustomerService
        $this->customerService = Mockery::mock(CustomerService::class);
        $this->customerService->shouldIgnoreMissing();

        // Mock the AsaasCustomerService
        $this->asaasCustomerService = Mockery::mock(AsaasCustomerService::class);
        $this->asaasCustomerService->shouldIgnoreMissing();

        // Create AsaasPaymentService instance
        $this->asaasPaymentService = new AsaasPaymentService($this->paymentBusinessRulesService, $this->customerService, $this->asaasCustomerService);
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
        $response = $this->asaasPaymentService->processPaymentCreation($payload);

        // Check if payment was successful
        $this->assertEquals("PENDING", $response['status']);

        // Check if the amount is correct
        $this->assertEquals(5, $response['value']);

        // Check if customer id is correct
        $this->assertEquals('cust_1234', $response['customer']);
    }

    public function test_handle_error_response()
    {
        // Fake the HTTP response
        Http::fake([
            '*' => Http::response([
                "errors" => [
                    ["description" => "Test Error"]
                ],
            ], 400),
        ]);

        // Mock the HTTP request
        $httpRequestMock = Http::post('fakeUrl');

        // Set the expected exception type and message
        $this->expectException(PaymentProcessingException::class);
        $this->expectExceptionMessage("Test Error");

        // Call the handleErrorResponse method
        $this->asaasPaymentService->handleErrorResponse($httpRequestMock);
    }
}

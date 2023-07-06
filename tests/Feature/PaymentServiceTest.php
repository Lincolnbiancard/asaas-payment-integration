<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Services\AsaasSimulatedPaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testPaymentCreationPix()
    {
        $paymentData = [
            "customer" => 'cus_000005354246', //todo mudar isso
            "billingType" => "PIX",
            "dueDate" => "2023-07-10",
            "value" => 100,
            "description" => "Pedido 056984",
            "externalReference" => "056984",
            "discount" => array(
                "value" => 10,
                "dueDateLimitDays" => 0
            ),
            "fine" => array(
                "value" => 1
            ),
            "interest" => array(
                "value" => 2
            ),
            "postalService" => false
        ];

        $response = $this->json('POST', '/api/payments', $paymentData);
       
        $response->assertStatus(200)
                ->assertJson($paymentData);
                
        // habilitar caso use db
        // $this->assertDatabaseHas('payments', $paymentData);
    }

    public function testPaymentCreationTicket()
    {
        $paymentData = [
            "customer" => 'cus_000005354246', //todo mudar isso
            "billingType" => "BOLETO",
            "dueDate" => "2023-07-10",
            "value" => 100,
            "description" => "Pedido 056984",
            "externalReference" => "056984",
            "discount" => array(
                "value" => 10,
                "dueDateLimitDays" => 0
            ),
            "fine" => array(
                "value" => 1
            ),
            "interest" => array(
                "value" => 2
            ),
            "postalService" => false
        ];

        $response = $this->json('POST', '/api/payments', $paymentData);
       
        $response->assertStatus(200)
                ->assertJson($paymentData);
                
        // habilitar caso use db
        // $this->assertDatabaseHas('payments', $paymentData);
    }

    public function testPaymentCreationCreditCard()
    {
        $paymentData = [
            "customer" => 'cus_000005354246', //todo mudar isso
            "billingType" => "CREDIT_CARD",
            "dueDate" => "2023-07-10",
            "value" => 100,
            "description" => "Pedido 056984",
            "externalReference" => "056984",
            "discount" => array(
                "value" => 10,
                "dueDateLimitDays" => 0
            ),
            "fine" => array(
                "value" => 1
            ),
            "interest" => array(
                "value" => 2
            ),
            "postalService" => false
        ];

        $response = $this->json('POST', '/api/payments', $paymentData);
       
        $response->assertStatus(200)
                ->assertJson($paymentData);
                
        // habilitar caso use db
        // $this->assertDatabaseHas('payments', $paymentData);
    }
}

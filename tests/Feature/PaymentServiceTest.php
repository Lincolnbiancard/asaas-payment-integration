<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    // private array $paymentData;

    // public function setup(): void
    // {
    //     parent::setUp();
    //     $this->paymentData = [
    //         "customer" => "",
    //         "name" => "Lincoln",
    //         "email" => "biancardilincoln@gmail.com",
    //         "phone" => "4799376637",
    //         "cpfCnpj" => "38921331824",
    //         "dueDate" => "2023-07-10",
    //         "value" => 5
    //     ];
    // }

    // public function testPaymentCreationPix()
    // {
    //     $this->paymentData['billingType'] = 'PIX';

    //     $response = $this->json('POST', '/api/payments', $this->paymentData);
       
    //     $response->assertStatus(201)
    //             ->assertJson($this->paymentData);
                
    //     // habilitar caso use db
    //     // $this->assertDatabaseHas('payments', $paymentData);
    // }

    // public function testPaymentCreationTicket()
    // {
    //     $this->paymentData['billingType'] = 'BOLETO';

    //     $response = $this->json('POST', '/api/payments', $this->paymentData);
       
    //     $response->assertStatus(201)
    //             ->assertJson($this->paymentData);
                
    //     // habilitar caso use db
    //     // $this->assertDatabaseHas('payments', $paymentData);
    // }

    // public function testPaymentCreationCreditCard()
    // {
    //     $this->paymentData['billingType'] = 'CREDIT_CARD';

    //     $response = $this->json('POST', '/api/payments', $this->paymentData);
       
    //     $response->assertStatus(201)
    //             ->assertJson($this->paymentData);
                
    //     // habilitar caso use db
    //     // $this->assertDatabaseHas('payments', $paymentData);
    // }
}

<?php

namespace Tests\Unit;

use App\Http\Resources\PaymentResource;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;

class PaymentTest extends TestCase
{
    private function inputPaymentResource(): array
    {
        return [
            "object" => "payment",
            "id" => "pay_2618176851712911",
            "dateCreated" => "2023-07-10",
            "customer" => "cus_000005356863",
            "paymentLink" => null,
            "value" => 5,
            "netValue" => 4.01,
            "originalValue" => null,
            "interestValue" => null,
            "description" => "Pedido 056984",
            "billingType" => "BOLETO",
            "canBePaidAfterDueDate" => true,
            "pixTransaction" => null,
            "status" => "PENDING",
            "dueDate" => "2023-07-15",
            "originalDueDate" => "2023-07-15",
            "paymentDate" => null,
            "clientPaymentDate" => null,
            "installmentNumber" => null,
            "invoiceUrl" => "https://sandbox.asaas.com/i/2618176851712911",
            "invoiceNumber" => "03693098",
            "externalReference" => "056984",
            "deleted" => false,
            "anticipated" => false,
            "anticipable" => false,
            "creditDate" => null,
            "estimatedCreditDate" => null,
            "transactionReceiptUrl" => null,
            "nossoNumero" => "1084678",
            "bankSlipUrl" => "https://sandbox.asaas.com/b/pdf/2618176851712911",
            "lastInvoiceViewedDate" => null,
            "lastBankSlipViewedDate" => null,
            "discount" => [
                "value" => 0.0,
                "limitDate" => null,
                "dueDateLimitDays" => 0,
                "type" => "FIXED",
            ],
            "fine" => [
                "value" => 0.0,
                "type" => "FIXED",
            ],
            "interest" => [
                "value" => 0.0,
                "type" => "PERCENTAGE",
            ],
            "postalService" => false,
            "custody" => null,
            "refunds" => null,
        ];
    }

    private function outputPaymentResource(): array
    {
        return [
            'id' => 'pay_2618176851712911',
            'dateCreated' => '2023-07-10',
            'customer' => 'cus_000005356863',
            'value' => 5,
            'description' => 'Pedido 056984',
            'billingType' => 'BOLETO',
            'status' => 'PENDING',
            'dueDate' => '2023-07-15',
            'invoiceUrl' => 'https://sandbox.asaas.com/i/2618176851712911',
            'externalReference' => '056984',
            'invoiceNumber' => '03693098',
            'bankSlipUrl' => 'https://sandbox.asaas.com/b/pdf/2618176851712911'
        ];
    }

    public function test_payment_resource()
    {
        $input = $this->inputPaymentResource();
        $output = $this->outputPaymentResource();

        $resource = new PaymentResource($input);

        $this->assertEquals($output, $resource->toArray(new Request()));
    }
}

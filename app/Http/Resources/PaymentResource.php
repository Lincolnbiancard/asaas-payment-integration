<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'dateCreated' => $this['dateCreated'],
            'customer' => $this['customer'],
            'value' => $this['value'],
            'description' => $this['description'],
            'billingType' => $this['billingType'],
            'status' => $this['status'],
            'dueDate' => $this['dueDate'],
            'invoiceUrl' => $this['invoiceUrl'],
            'externalReference' => $this['externalReference'],
            'invoiceNumber' => $this['invoiceNumber'],
            'bankSlipUrl' => $this['bankSlipUrl'],
        ];
    }
}

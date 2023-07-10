<?php

namespace App\Exceptions;

use Exception;

class PaymentProcessingException extends Exception
{
    protected $message = 'Houve um problema ao gerar sua cobrança. Por favor, tente novamente mais tarde.';
}

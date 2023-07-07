<?php

namespace App\Exceptions;

use Exception;

class PaymentProcessingException extends Exception
{
    protected $message = 'Houve um problema ao processar seu pagamento. Por favor, tente novamente mais tarde.';
}

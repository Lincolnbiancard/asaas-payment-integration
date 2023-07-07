<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CpfOrCnpj implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validatorCpf = Validator::make([$attribute => $value], [$attribute => 'cpf']);
        $validatorCnpj = Validator::make([$attribute => $value], [$attribute => 'cnpj']);

        return ($validatorCpf->passes() || $validatorCnpj->passes());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo :attribute deve ser um CPF ou CNPJ válido.';
    }
}

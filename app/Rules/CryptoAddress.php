<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CryptoAddress implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail(__('The :attribute must be a valid crypto address.'));

            return;
        }

        $normalized = trim($value);
        $pattern = '/^[1-9A-HJ-NP-Za-km-z]{32,44}$/';

        if (!preg_match($pattern, $normalized)) {
            $fail(__('The :attribute must be a valid Solana wallet address.'));
        }
    }
}

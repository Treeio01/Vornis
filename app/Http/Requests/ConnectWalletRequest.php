<?php

namespace App\Http\Requests;

use App\Rules\CryptoAddress;
use Illuminate\Foundation\Http\FormRequest;

class ConnectWalletRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'walletAddress' => ['required', 'string', new CryptoAddress()],
        ];
    }
}

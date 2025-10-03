<?php

namespace App\Http\Requests;

use App\Rules\CryptoAddress;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'address' => ['required', 'string', new CryptoAddress()],
            'token' => ['required', 'string', 'max:10'],
            'comment' => ['nullable', 'string', 'max:300'],
        ];
    }
}

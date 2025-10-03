<?php

namespace App\Http\Controllers;

use App\Data\AddressData;
use App\Http\Requests\StoreAddressRequest;
use App\Services\AddressService;
use Illuminate\Http\RedirectResponse;

class AddressController extends Controller
{
    public function __construct(private readonly AddressService $addressService)
    {
    }

    public function store(StoreAddressRequest $request): RedirectResponse
    {
        $this->addressService->storeForUser($request->user(), $request->validated());

        return back()->with([
            'addresses' => AddressData::collection(
                $this->addressService->getAll()
            ),
        ]);
    }
}

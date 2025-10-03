<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectWalletRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function connect(ConnectWalletRequest $request): RedirectResponse
    {
        $this->userService->connectWallet($request->user(), $request->validated('walletAddress'));

        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class UserController extends Controller
{
    public function connect(Request $request)
    {
        $request->validate([
            "walletAddress" => ["required"]
        ]);

        $user = $request->user();
        $user->address = $request->walletAddress;
        $user->save();

        return redirect()->route("dashboard");
    }
}

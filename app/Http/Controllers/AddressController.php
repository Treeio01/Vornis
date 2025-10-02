<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "token" => ["required"],
            "comment" => ["required"],
            "address" => ["nullable"]
        ]);

        $address = new Address();
        $address->user_id = $request->user()->id;
        $address->address = $request->address;
        $address->token = $request->token;
        $address->comment = $request->comment;
        $address->status = "pending";
        $address->save();



        return back()->with([
            'addresses' => Address::all(),
        ]);
    }
}

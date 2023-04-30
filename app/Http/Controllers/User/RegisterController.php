<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => ['required', 'max:60'],
            'email' => ['required', 'unique:customers,email', 'email:dns'],
            'password' => ['required', 'max:60']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        Customer::create($validatedData);

        return redirect()->back()->with('success','Register successfully! you can log in now');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate (Request $request){
        if ($request->isMethod('post')) {
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required|max:30'
            ];
            $credentials = $request->validate($rules);

            if (Auth::guard('customer')->attempt($credentials)) {
                $request->session()->regenerate();

               

                return redirect()->intended('/');
            }

            return redirect()->back()->with([
                'error' => 'Invalid Email or Password!',
            ]);
        }

        return view('customer.home');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate (Request $request){
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        // $credentials = $request->validate($rules, $customMessages);

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();

            $carts = session('cart.items', []);

            return redirect()->back()->with('sweet_alert', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Successfully login. Happy Shopping!',
            ]);
        }else{

            return redirect()->back()->with('sweet_alert',[
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Invalid email or password!',
            ]);
        }

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->back()->with('sweet_alert',[
            'icon' => 'success',
            'title' => 'Success',
            'text' => 'Log out successfully!',
        ]);
    }
}

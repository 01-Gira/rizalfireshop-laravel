<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// use Illuminate\Support\Facades\Event;



class LoginController extends Controller
{
    public function authenticate (Request $request){
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        // $credentials = $request->validate($rules, $customMessages);
        if (Auth::attempt($credentials)) {
            $user = Auth::user()->id;
            // dd($user);
            if ($user) {
                $customer = User::find($user);
                $customer->status = 1;
                $customer->last_online = Carbon::now();
                $customer->save();
            }

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

        // if (Auth::guard('customer')->attempt($credentials)) {
        //     $request->session()->regenerate();
        //     $user = Auth::guard('customer')->user()->id;
        //     // dd($user);
        //     if ($user) {
        //         $customer = Customer::find($user);
        //         $customer->status = 1;
        //         $customer->last_online = Carbon::now();
        //         $customer->save();
        //     }
        //     $carts = session('cart.items', []);

        //     return redirect()->back()->with('sweet_alert', [
        //         'icon' => 'success',
        //         'title' => 'Success',
        //         'text' => 'Successfully login. Happy Shopping!',
        //     ]);
        // }else{

        //     return redirect()->back()->with('sweet_alert',[
        //         'icon' => 'error',
        //         'title' => 'Error',
        //         'text' => 'Invalid email or password!',
        //     ]);
        // }

        return redirect()->back();
    }

    public function logout(Request $request)
    {

        $user = Auth::user()->id;
        // dd($user);
        if ($user) {
            $customer = User::find($user);
            $customer->status = 0;
            $customer->save();
        }

        // Auth::guard('customer')->logout();
        auth()->logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->back()->with('sweet_alert',[
            'icon' => 'success',
            'title' => 'Success',
            'text' => 'Log out successfully!',
        ]);
    }
}

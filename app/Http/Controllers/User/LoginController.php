<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate (Request $request){
        // $credentials = $request->validate([
        //     'email' => ['required', 'email:dns'],
        //     'password' => ['required']
        // ]);

        // if (Auth::guard('customer')->attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return redirect()->back()->with('success','Log in successfully!');
        // }else{
        //     return redirect()->back()->with([
        //         'error' => 'Invalid Email or Password!',
        //     ]);
        // }

        // return redirect()->back();

        
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|max:30'
        ];

        $customMessages = [
            'email.required' => 'Email is required',
            'email.email' => 'Valid email is required',
            'password.required' => 'Password is required'
        ];

        $credentials = $request->validate($rules, $customMessages);
        
        // // dd($credentials);

        if (Auth::guard('customer')->attempt($credentials)) {
            $user = Auth::guard('customer')->user();


            // / Generate a new access token for the user
            $token = $user->createToken('authToken', ['customer'])->plainTextToken;
            return response()->json(['token' => $token]);
        }else{
      
            return response()->json(['message' => 'Email or Password is Invalid!'], 401);
    
        }

        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        // Auth::guard('admin')->logout();

        $request->user()->currentAccessToken()->delete();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return redirect()->back()->with('success','Log out successfull!');
    }
}

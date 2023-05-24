<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dotenv\Validator;

class LoginController extends Controller
{
    public function authenticate(Request $request){
        if ($request->isMethod('post')) {
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
            
            // dd($credentials);

            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                


                return redirect()->intended('/admin/dashboard');
                // return response()->json(['message' => 'Success Login']);
            }

            // return response()->json(['message' => 'Invalid Email or Password!']);

            return redirect()->back()->with([
                'error_message' => 'Invalid Email or Password!',
            ]);
        }

        return view('admin.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
 
        return redirect('admin/login');
    }
}

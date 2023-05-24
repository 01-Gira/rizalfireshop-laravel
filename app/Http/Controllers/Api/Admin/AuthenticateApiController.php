<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dotenv\Validator;

class AuthenticateApiController extends Controller
{
    public function authenticate(Request $request){
        try {
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
        
    
            if (Auth::guard('admin')->attempt($credentials)) {
                $user = Auth::guard('admin')->user();
    
    
                // / Generate a new access token for the user
                $token = $user->createToken('authToken', ['admin'])->plainTextToken;
                return response()->json(['token' => $token]);
            }else{
          
                return response()->json(['inc'=>'1','msg' => 'Invalid credentials'], 401);
        
            }
    
            return response()->json(['user' => $user, 'token' => $token], 200);
        } catch (Exception $e) {
            return response()->json(['inc'=>'0', 'msg' => 'Error : '.$e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['inc' => '0','msg' => 'Logout Successfully']);
        } catch (Exception $e) {
            return response()->json(['inc' => '0','msg' => 'Error : '.$e->getMessage()]);
        }

    }
}

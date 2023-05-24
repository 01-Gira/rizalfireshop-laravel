<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dotenv\Validator;
use Illuminate\Support\Facades\Hash;

class AuthenticateApiController extends Controller
{
    public function register(Request $request){
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'max:60'],
                'email' => ['required', 'unique:customers,email', 'email:dns'],
                'password' => ['required', 'min:6',]
            ]);
    
            $validatedData['password'] = Hash::make($validatedData['password']);
    
            Customer::create($validatedData);
    
            return response()->json([
                'error'=>false,
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error : '.$e->getMessage()
            ]);
        } 
    }

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
        
    
            if (Auth::guard('customer')->attempt($credentials)) {
                $user = Auth::guard('customer')->user();
    
    
                // / Generate a new access token for the user
                $token = $user->createToken('authToken', ['customer'])->plainTextToken;
                return response()->json([
                    'error' => false,
                    'message' => 'success',
                    'token' => $token
                ]);
            }else{
          
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid credentials'
                ]);
        
            }
        } catch (Exception $e) {
            return response()->json(['error'=>true, 'message' => 'Error : '.$e->getMessage()]);
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
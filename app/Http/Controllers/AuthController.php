<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'mobile' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'address' => $request->address,
        ]);

        $token = $user->createToken('token_name')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user,'status'=>201]);
    }


    public function clientLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422); 
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if ($user->user_type === 'client') {
                $token = $user->createToken('ClientToken')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $user], 200);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'The provided credentials do not match our records.',
        ], 401); 
    }
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->user_type === 'admin') {
                if (Auth::attempt($request->only('email', 'password'))) {
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome to the Admin Dashboard! You are now logged in.');
                }
                return redirect()->back()->withErrors(['password' => 'Invalid password'])->withInput();
            } else {
                return redirect()->back()->withErrors(['email' => 'You do not have admin access kindly login on mobile app'])->withInput();
            }
        }
        return redirect()->back()->withErrors(['email' => 'No account found with that email.'])->withInput();
    }
    
    
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            Auth::logout();
            if ($user->user_type === 'client') {
                $user->tokens()->delete();
                return response()->json([
                    'message' => 'Logged out successfully'
                ], 200);
            }
            return redirect()->route('login')->with('message', 'Logged out successfully');
        }
        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }
    

}

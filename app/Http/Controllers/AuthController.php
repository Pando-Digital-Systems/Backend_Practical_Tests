<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // Registration Method
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Login Method

    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            // If it's an API request
            if ($request->expectsJson()) {
                return response()->json($validator->errors(), 422); // Return JSON for validation errors
            } else {
                return redirect()->back()->withErrors($validator)->withInput(); // Return to view for validation errors
            }
        }

        // Check user credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed...
            $user = Auth::user(); // Get the authenticated user

            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;

            // If it's an API request
            if ($request->expectsJson()) {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ], 200); // 200 OK
            } else {
                // Redirect to the user profile view for web requests
                return redirect()->route('user-profile')->with('access_token', $token);
            }
        }

        // Invalid credentials
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Invalid credentials'], 401); // Return JSON for invalid credentials
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput(); // Return to view
        }
    }





    // User Profile Method
    public function userProfile(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Return the view and pass the user data
        return view('user-profile', compact('user'));
    }

    // Logout Method
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

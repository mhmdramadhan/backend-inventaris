<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User registered',
            'token' => $token
        ]);
    }

    // LOGIN
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token
        ]);
    }
}

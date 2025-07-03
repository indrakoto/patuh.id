<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Handle user login
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Find user with selected fields
        $user = User::where('email', $validated['email'])
            ->select(['id', 'name', 'email', 'password', 'is_active', 'photo', 'role'])
            ->first();

        // Check credentials
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication failed',
                'errors' => [
                    'email' => [__('auth.failed')]
                ]
            ], 401);
        }

        // Check if user is active
        if (!$user->is_active) {
            Log::warning("Login attempt for inactive user: {$validated['email']}");
            return response()->json([
                'success' => false,
                'message' => __('auth.inactive')
            ], 403);
        }

        // Create token with expiration
        $token = $user->createToken(
            name: 'auth_token',
            abilities: ['*'],
            expiresAt: now()->addWeek()
        )->plainTextToken;

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 60 * 24 * 7, // 7 days in minutes
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'photo' => $user->photo,
                    'role' => $user->role,
                ]
            ]
        ]);
    }

    /**
     * Handle user logout
     */
    public function destroy(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Logout error for user {$request->user()->id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Logout failed'
            ], 500);
        }
    }
}
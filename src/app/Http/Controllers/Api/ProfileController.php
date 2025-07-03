<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // Menampilkan profile user saat ini
    public function show(Request $request)
    {
        try {
            // User must be authenticated via Sanctum token
            if (!$request->user()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: No active token found',
                    'data' => null
                ], 401);
            }

            $user = $request->user();

            return response()->json([
                'success' => true,
                'message' => 'Profile retrieved successfully',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'photo' => $user->photo,
                    'role' => $user->role,
                    'email_verified_at' => $user->email_verified_at,
                    'is_active' => $user->is_active,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ProfileController Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve profile',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}

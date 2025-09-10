<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw new ValidationException("The login credentials are incorrect");
        }

        if (!Hash::check($request->password, $user->password)) {
            throw new ValidationException("The login credentials are incorrect");
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request): JsonResponse {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged out seccessfully!'
        ]);
    }
}

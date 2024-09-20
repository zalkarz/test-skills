<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CredentialsIncorrectException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @throws CredentialsIncorrectException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new CredentialsIncorrectException('Invalid credentials');
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }
}

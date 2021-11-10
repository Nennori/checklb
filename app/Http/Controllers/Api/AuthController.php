<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Token;


class AuthController extends Controller
{
    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function register(RegistrationRequest $request)
    {
        $user = User::createUser($request);
        $tokens = $this->tokenService->generateTokens($user);
        return response()->json(['data' => [
            'name' => $user->name,
            'access_token' => $tokens['access'],
            'refresh_token' => $tokens['refresh']
        ]], 201);
    }

    public function login(Request $request): JsonResponse
    {
        User::validate($request);
        return $this->respondWithTokens($this->tokenService->generateTokens(auth()->user()));
    }

    public function logout(Request $request)
    {
        auth()->setToken($request->input('access_token'))->invalidate(true);
        auth()->parseToken()->invalidate(true);
        return response()->json([], 204);
    }

    public function refresh()
    {
        return $this->respondWithTokens($this->tokenService->generateTokens(auth()->user()));
    }

    private function respondWithTokens(array $tokens): JsonResponse
    {
        return response()->json([
            'data' => [
                'access_token' => $tokens['access'],
                'refresh_token' => $tokens['refresh'],
            ]
        ]);
    }

}

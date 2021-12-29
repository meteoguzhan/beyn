<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Requests\V1\Auth\LoginAuthRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends \App\Http\Controllers\V1\ApiController
{
    public function login(LoginAuthRequest $request): JsonResponse
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->error(__('Email or password is incorrect!'));
        }

        if (!$token = Auth::user()->createToken($request->email)->plainTextToken) {
            return $this->error(__('Failed to create token!'));
        }

        Auth::user()->access_token = $token;

        return $this->success(__('Success'), UserResource::make(Auth::user()));
    }
}

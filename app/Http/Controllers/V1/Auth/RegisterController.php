<?php

    namespace App\Http\Controllers\V1\Auth;

    use App\Http\Requests\V1\Auth\RegisterAuthRequest;
    use App\Http\Resources\V1\UserResource;
    use App\Repositories\V1\Eloquent\UserRepository;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class RegisterController extends \App\Http\Controllers\V1\ApiController
    {
        protected UserRepository $userRepository;

        public function __construct(UserRepository $userRepository)
        {
            $this->userRepository = $userRepository;
        }

        public function register(RegisterAuthRequest $request): JsonResponse
        {
            $user = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            if (!$user) {
                return $this->error(__('User failed to register!'));
            }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return $this->error(__('Login failed'));
            }

            if (!$token = Auth::user()->createToken($request->email)->plainTextToken) {
                return $this->error(__('Failed to create token!'));
            }

            $user->access_token = $token;

            return $this->success(__('Success'), UserResource::make($user));
        }
    }

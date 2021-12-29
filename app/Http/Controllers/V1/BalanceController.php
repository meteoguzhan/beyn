<?php

    namespace App\Http\Controllers\V1;

    use App\Http\Requests\V1\Balance\AddBalanceRequest;
    use App\Http\Resources\V1\CarResource;
    use App\Http\Resources\V1\UserResource;
    use App\Repositories\V1\Eloquent\UserRepository;
    use Illuminate\Http\JsonResponse;

    class BalanceController extends ApiController
    {
        protected UserRepository $userRepository;
        protected $user;

        public function __construct(UserRepository $userRepository)
        {
            $this->userRepository = $userRepository;

            $this->middleware(function ($request, $next) {
                $this->user = \Illuminate\Support\Facades\Auth::user();
                return $next($request);
            });
        }

        public function addBalance(AddBalanceRequest $request): JsonResponse|CarResource
        {
            $user = $this->userRepository->updateUserById([
                'balance' => $this->user->balance + $request->amount
            ], $this->user);
            if (!$user) {
                return $this->error(__('Could not add balance'));
            }

            return $this->success(__('Success'), UserResource::make($user));
        }
    }

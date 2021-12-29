<?php

    namespace App\Http\Controllers\V1;

    use App\Http\Resources\V1\CarResource;
    use App\Repositories\V1\Eloquent\CarRepository;
    use Illuminate\Http\JsonResponse;

    class CarController extends ApiController
    {
        protected CarRepository $carRepository;

        public function __construct(CarRepository $carRepository)
        {
            $this->carRepository = $carRepository;
        }

        public function index(): JsonResponse
        {
            $cars = $this->carRepository->getAll();
            if (!$cars || !$cars->count()) {
                return $this->error(__('No cars found!'));
            }

            return $this->success(__('Success'), new CarResource($cars));
        }
    }

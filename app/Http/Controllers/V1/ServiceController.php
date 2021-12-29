<?php

    namespace App\Http\Controllers\V1;

    use App\Http\Resources\V1\ServiceResource;
    use App\Repositories\V1\Eloquent\ServiceRepository;
    use Illuminate\Http\JsonResponse;

    class ServiceController extends ApiController
    {
        protected ServiceRepository $serviceRepository;

        public function __construct(ServiceRepository $serviceRepository)
        {
            $this->serviceRepository = $serviceRepository;
        }

        public function index(): JsonResponse
        {
            $cars = $this->serviceRepository->getAll();
            if (!$cars || !$cars->count()) {
                return $this->error(__('No services found!'));
            }

            return $this->success(__('Success'), new ServiceResource($cars));
        }
    }

<?php

    namespace App\Http\Controllers\V1;

    use App\Http\Requests\V1\Order\StoreOrderRequest;
    use App\Http\Resources\V1\OrderResource;
    use App\Repositories\V1\Eloquent\CarRepository;
    use App\Repositories\V1\Eloquent\OrderRepository;
    use App\Repositories\V1\Eloquent\ServiceRepository;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;

    class OrderController extends ApiController
    {
        protected $user;
        protected OrderRepository $orderRepository;
        protected ServiceRepository $serviceRepository;
        protected CarRepository $carRepository;

        public function __construct(
            OrderRepository   $orderRepository,
            ServiceRepository $serviceRepository,
            CarRepository     $carRepository,
        )
        {
            $this->orderRepository = $orderRepository;
            $this->serviceRepository = $serviceRepository;
            $this->carRepository = $carRepository;

            $this->middleware(function ($request, $next) {
                $this->user = \Illuminate\Support\Facades\Auth::user();
                return $next($request);
            });
        }

        public function index(Request $request): JsonResponse
        {
            $orders = $this->orderRepository->getOrdersByFilter($request, $this->user);
            if (!$orders || !$orders->count()) {
                return $this->error(__('No orders found!'));
            }

            return $this->success(__('Success'), new OrderResource($orders));
        }

        public function store(StoreOrderRequest $request): JsonResponse|OrderResource
        {
            $service = $this->serviceRepository->getServiceById($request->service_id);
            if (!$service) {
                return $this->error(__('No service found!'));
            }

            $car = $this->carRepository->getCarById($request->car_id);
            if (!$car) {
                return $this->error(__('No car found!'));
            }

            if ($this->user->balance < $service->price) {
                return $this->error(__('You have insufficient balance!'));
            }

            $order = $this->orderRepository->create([
                'user_id' => $this->user->id,
                'service_id' => $request->service_id,
                'car_id' => $request->car_id,
                'status' => false,
                'price' => $service->price,
            ], $this->user);
            if (!$order) {
                return $this->error(__('Failed to create order!'));
            }

            return $this->success(__('Success'), OrderResource::make($order));
        }
    }

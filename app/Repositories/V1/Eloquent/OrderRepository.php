<?php

    namespace App\Repositories\V1\Eloquent;

    use App\Models\V1\Order;
    use App\Models\V1\User;
    use Illuminate\Support\Facades\DB;

    class OrderRepository implements \App\Repositories\V1\Interfaces\OrderRepositoryInterface
    {
        public function getAll()
        {
            try {
                return DB::transaction(function () {
                    return Order::paginate();
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function getOrdersByFilter($filter, User $user)
        {
            try {
                return DB::transaction(function () use ($filter, $user){
                    $orders = Order::query();
                    $orders = $orders->where('user_id', $user->id);
                    if (isset($filter->service_id) && $filter->service_id) {
                        $orders = $orders->where('service_id', $filter->service_id);
                    }

                    if (isset($filter->car_id) && $filter->car_id) {
                        $orders = $orders->where('car_id', $filter->car_id);
                    }

                    if (isset($filter->status) && $filter->status) {
                        $orders = $orders->where('status', $filter->status);
                    }

                    if (isset($filter->price) && $filter->price) {
                        $orders = $orders->where('price', $filter->price);
                    }
                    return $orders->with(['user', 'car', 'service'])->paginate();
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function create($data, User $user)
        {
            try {
                return DB::transaction(function () use ($data, $user) {
                    $order = Order::create($data);
                    $user->update(['balance' => $user->balance - $order->price]);
                    return $order;
                });
            } catch (\Exception $e) {
                return false;
            }
        }
    }
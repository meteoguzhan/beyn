<?php

    namespace Tests\Feature\V1;

    use App\Models\V1\Car;
    use App\Models\V1\Order;
    use App\Models\V1\Service;
    use App\Models\V1\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Hash;
    use Laravel\Sanctum\Sanctum;
    use Tests\TestCase;

    class OrderTest extends TestCase
    {
        use RefreshDatabase;

        /**
         * @test
         */
        public function getOrders()
        {
            $user = $this->create_user(123456);
            $service = $this->create_service();
            $car = $this->create_car();
            $this->create_order(10, $user, $car[0], $service[0]);

            Sanctum::actingAs($user, ['*']);

            $response = $this->getJson('api/v1/orders');
            $response->assertStatus(200);
            $response->assertJsonPath('message', 'Success');
            $response->assertJsonCount(10, 'data.data');
        }

        /**
         * @test
         */
        public function getOrdersWrongAuth()
        {
            $response = $this->getJson('api/v1/orders');

            $response->assertStatus(401);
            $response->assertJsonPath('message', 'Unauthenticated.');
        }

        /**
         * @test
         */
        public function storeOrder()
        {
            $user = $this->create_user(123456);
            $this->update_balance_user($user);
            Sanctum::actingAs($user, ['*']);

            $service = $this->create_service();
            $car = $this->create_car();

            $data = [
                'service_id' => $service[0]->id,
                'car_id' => $car[0]->id
            ];
            $response = $this->postJson('api/v1/orders', $data);
            $response->assertStatus(200);
            $response->assertJsonPath('message', 'Success');
            $response->assertJsonPath('data.user_id', $user->id);
            $response->assertJsonPath('data.service_id', $service[0]->id);
            $response->assertJsonPath('data.car_id', $car[0]->id);
            $this->assertDatabaseHas('orders', [
                'user_id' => $user->id,
                'service_id' => $service[0]->id,
                'car_id' => $car[0]->id
            ]);
            $this->assertDatabaseCount('orders', 1);
        }

        /**
         * @test
         */
        public function storeOrderWrongService()
        {
            $user = $this->create_user(123456);
            $this->update_balance_user($user);
            Sanctum::actingAs($user, ['*']);

            $this->create_service();
            $car = $this->create_car();

            $data = [
                'service_id' => 22222,
                'car_id' => $car[0]->id
            ];
            $response = $this->postJson('api/v1/orders', $data);
            $response->assertStatus(403);
            $response->assertJsonPath('message', 'No service found!');
            $this->assertDatabaseCount('orders', 0);
        }

        /**
         * @test
         */
        public function storeOrderWrongCar()
        {
            $user = $this->create_user(123456);
            $this->update_balance_user($user);
            Sanctum::actingAs($user, ['*']);

            $service = $this->create_service();
            $this->create_car();

            $data = [
                'service_id' => $service[0]->id,
                'car_id' => 2222
            ];
            $response = $this->postJson('api/v1/orders', $data);
            $response->assertStatus(403);
            $response->assertJsonPath('message', 'No car found!');
            $this->assertDatabaseCount('orders', 0);
        }

        /**
         * @test
         */
        public function storeOrderWrongBalance()
        {
            $user = $this->create_user(123456);
            Sanctum::actingAs($user, ['*']);

            $service = $this->create_service();
            $car = $this->create_car();

            $data = [
                'service_id' => $service[0]->id,
                'car_id' => $car[0]->id
            ];
            $response = $this->postJson('api/v1/orders', $data);
            $response->assertStatus(403);
            $response->assertJsonPath('message', 'You have insufficient balance!');
            $this->assertDatabaseCount('orders', 0);
        }

        private function create_user($password)
        {
            return User::factory()->create(['password' => Hash::make($password)]);
        }

        private function create_order($count = 1, $user = null, $car = null, $service = null)
        {
            $data = [];
            if (isset($user)) {
                $data['user_id'] = $user->id;
            }
            if (isset($car)) {
                $data['car_id'] = $car->id;
            }
            if (isset($service)) {
                $data['service_id'] = $service->id;
            }

            return Order::factory()->count($count)->create($data);
        }

        private function create_car($count = 1)
        {
            return Car::factory()->count($count)->create();
        }

        private function create_service($count = 1)
        {
            return Service::factory()->count($count)->create(['price' => 50]);
        }

        private function update_balance_user($user, $balance = 100)
        {
            return $user->update(['balance' => $balance]);
        }
    }

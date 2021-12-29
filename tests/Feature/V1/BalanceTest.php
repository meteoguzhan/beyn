<?php

    namespace Tests\Feature\V1;

    use App\Models\V1\User;
    use Illuminate\Support\Facades\Hash;
    use Laravel\Sanctum\Sanctum;
    use Tests\TestCase;

    class BalanceTest extends TestCase
    {
        /**
         * @test
         */
        public function addBalance()
        {
            $user = $this->create_user(123456);
            Sanctum::actingAs($user, ['*']);
            $data = [
                'amount' => 120
            ];

            $response = $this->putJson('api/v1/balance', $data);

            $response->assertStatus(200);
            $response->assertJsonPath('message', 'Success');
            $response->assertJsonPath('data.balance', '120.00');
            $this->assertDatabaseHas('users', ['balance' => '120.00']);
        }

        /**
         * @test
         */
        public function addBalanceWrongAuth()
        {
            $response = $this->putJson('api/v1/balance');

            $response->assertStatus(401);
            $response->assertJsonPath('message', 'Unauthenticated.');
        }

        /**
         * @test
         */
        public function addBalanceWrongAmount()
        {
            $user = $this->create_user(123456);
            Sanctum::actingAs($user, ['*']);
            $response = $this->putJson('api/v1/balance');

            $response->assertStatus(422);
            $response->assertJsonPath('message', 'The given data was invalid.');
            $response->assertJsonPath('errors.amount.0', 'The amount field is required.');
        }

        private function create_user($password)
        {
            return User::factory()->create(['password' => Hash::make($password)]);
        }
    }

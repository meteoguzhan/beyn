<?php

    namespace Tests\Feature\V1;

    use App\Models\V1\Car;
    use App\Models\V1\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Hash;
    use Laravel\Sanctum\Sanctum;
    use Tests\TestCase;

    class CarTest extends TestCase
    {
        use RefreshDatabase;
        /**
         * @test
         */
        public function getCars()
        {
            $user = $this->create_user(123456);
            $this->create_car(10);
            Sanctum::actingAs($user, ['*']);

            $response = $this->getJson('api/v1/cars');
            $response->assertStatus(200);
            $response->assertJsonPath('message', 'Success');
            $response->assertJsonCount(10, 'data.data');
        }

        /**
         * @test
         */
        public function getCarsWrongAuth()
        {
            $response = $this->getJson('api/v1/cars');

            $response->assertStatus(401);
            $response->assertJsonPath('message', 'Unauthenticated.');
        }

        /**
         * @test
         */
        public function updateOrCreateCar()
        {
            $this->artisan('v1:car:updateOrCreate')
                ->expectsOutput('All cars added or updated')
                ->assertExitCode(1);
        }

        private function create_user($password)
        {
            return User::factory()->create(['password' => Hash::make($password)]);
        }

        private function create_car($count = 1)
        {
            return Car::factory()->count($count)->create();
        }
    }

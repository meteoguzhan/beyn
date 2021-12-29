<?php

    namespace Tests\Feature\V1;

    use App\Models\V1\Service;
    use App\Models\V1\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Hash;
    use Laravel\Sanctum\Sanctum;
    use Tests\TestCase;

    class ServiceTest extends TestCase
    {
        use RefreshDatabase;
        /**
         * @test
         */
        public function getServices()
        {
            $user = $this->create_user(123456);
            $this->create_service(10);
            Sanctum::actingAs($user, ['*']);

            $response = $this->getJson('api/v1/services');
            $response->assertStatus(200);
            $response->assertJsonPath('message', 'Success');
            $response->assertJsonCount(10, 'data.data');
        }

        /**
         * @test
         */
        public function getServicesWrongAuth()
        {
            $response = $this->getJson('api/v1/services');

            $response->assertStatus(401);
            $response->assertJsonPath('message', 'Unauthenticated.');
        }

        private function create_user($password)
        {
            return User::factory()->create(['password' => Hash::make($password)]);
        }

        private function create_service($count = 1)
        {
            return Service::factory()->count($count)->create();
        }
    }

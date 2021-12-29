<?php

    namespace Tests\Feature\V1\Auth;

    use App\Models\V1\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Hash;
    use Tests\TestCase;

    class RegisterTest extends TestCase
    {
        use RefreshDatabase;

        /**
         * @test
         */
        public function register()
        {
            $data = $this->get_register_data();

            $response = $this->postJson('api/v1/auth/register', $data);

            $response->assertStatus(200);
            $response->assertJsonPath('message', 'Success');
            $response->assertJsonPath('data.name', $data['name']);
            $response->assertJsonPath('data.email', $data['email']);
            $this->assertDatabaseHas('users', ['email' => $data['email'], 'name' => $data['name']]);
            $this->assertDatabaseCount('users', 1);
        }

        /**
         * @test
         */
        public function registerMissingParameter()
        {
            $data = $this->get_register_data();
            unset($data['email']);

            $response = $this->postJson('api/v1/auth/register', $data);

            $response->assertStatus(422);
            $response->assertJsonPath('message', 'The given data was invalid.');
            $response->assertJsonPath('errors.email.0', 'The email field is required.');
            $this->assertDatabaseMissing('users', ['name' => $data['name'],]);
            $this->assertDatabaseCount('users', 0);
        }

        /**
         * @test
         */
        public function registerWrongEmail()
        {
            $this->create_user(123456);
            $data = $this->get_register_data();

            $response = $this->postJson('api/v1/auth/register', $data);

            $response->assertStatus(422);
            $response->assertJsonPath('message', 'The given data was invalid.');
            $response->assertJsonPath('errors.email.0', 'The email has already been taken.');
            $this->assertDatabaseMissing('users', ['name' => $data['name'],]);
            $this->assertDatabaseCount('users', 1);
        }

        private function create_user($password)
        {
            return User::factory()->create(['email' => 'test@test.com', 'password' => Hash::make($password)]);
        }

        private function get_register_data()
        {
            return [
                'name' => 'Name',
                'email' => 'test@test.com',
                'password' => 'password'
            ];
        }
    }

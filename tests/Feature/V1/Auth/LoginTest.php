<?php

    namespace Tests\Feature\V1\Auth;

    use App\Models\V1\User;
    use Illuminate\Support\Facades\Hash;
    use Tests\TestCase;

    class LoginTest extends TestCase
    {
        /**
         * @test
         */
        public function login()
        {
            $user = $this->create_user(123456);
            $data = [
                'email' => $user->email,
                'password' => 123456
            ];

            $response = $this->postJson('api/v1/auth/login', $data);

            $response->assertStatus(200);
            $response->assertJsonPath('message', 'Success');
            $response->assertJsonPath('data.id', $user->id);
            $this->assertNotNull('data.access_token');
        }

        /**
         * @test
         */
        public function loginMissingParameter()
        {
            $response = $this->postJson('api/v1/auth/login');

            $response->assertStatus(422);
            $response->assertJsonPath('message', 'The given data was invalid.');
            $response->assertJsonPath('errors.email.0', 'The email field is required.');
            $response->assertJsonPath('errors.password.0', 'The password field is required.');
        }

        /**
         * @test
         */
        public function loginWrongEmail()
        {
            $password = 123456;
            $this->create_user($password);
            $data = [
                'email' => 'email@notfound.com',
                'password' => $password
            ];

            $response = $this->postJson('api/v1/auth/login', $data);

            $response->assertStatus(403);
            $response->assertJsonPath('message', 'Email or password is incorrect!');
            $this->assertDatabaseMissing('users', [
                'email' => $data['email']
            ]);
        }

        /**
         * @test
         */
        public function loginWrongPassword()
        {
            $user = $this->create_user(123456);
            $data = [
                'email' => $user->email,
                'password' => '123456721389'
            ];

            $response = $this->postJson('api/v1/auth/login', $data);

            $response->assertStatus(403);
            $response->assertJsonPath('message', 'Email or password is incorrect!');
        }

        private function create_user($password)
        {
            return User::factory()->create(['password' => Hash::make($password)]);
        }
    }

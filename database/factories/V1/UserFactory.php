<?php

    namespace Database\Factories\V1;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use App\Models\V1\User;

    class UserFactory extends Factory
    {
        /**
         * The name of the factory's corresponding model.
         *
         * @var string
         */
        protected $model = User::class;

        /**
         * Define the model's default state.
         *
         * @return array
         */
        public function definition()
        {
            return [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail,
                'password' => $this->faker->password,
                'balance' => 0
            ];
        }
    }
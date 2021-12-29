<?php

    namespace Database\Factories\V1;

    use App\Models\V1\Order;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class OrderFactory extends Factory
    {
        /**
         * The name of the factory's corresponding model.
         *
         * @var string
         */
        protected $model = Order::class;

        /**
         * Define the model's default state.
         *
         * @return array
         */
        public function definition()
        {
            return [
                'user_id' => $this->faker->numberBetween(1, 10000),
                'service_id' => $this->faker->numberBetween(1, 10000),
                'car_id' => $this->faker->numberBetween(1, 10000),
                'status' => 0,
                'price' => $this->faker->numberBetween(1, 10000)
            ];
        }
    }
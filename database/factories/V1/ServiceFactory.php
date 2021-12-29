<?php

    namespace Database\Factories\V1;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use App\Models\V1\Service;

    class ServiceFactory extends Factory
    {
        /**
         * The name of the factory's corresponding model.
         *
         * @var string
         */
        protected $model = Service::class;

        /**
         * Define the model's default state.
         *
         * @return array
         */
        public function definition()
        {
            return [
                'name' => $this->faker->name,
                'price' => $this->faker->numberBetween(1, 10000)
            ];
        }
    }
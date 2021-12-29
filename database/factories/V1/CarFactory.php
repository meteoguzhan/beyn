<?php

    namespace Database\Factories\V1;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use App\Models\V1\Car;

    class CarFactory extends Factory
    {
        /**
         * The name of the factory's corresponding model.
         *
         * @var string
         */
        protected $model = Car::class;

        /**
         * Define the model's default state.
         *
         * @return array
         */
        public function definition()
        {
            return [
                'url' => $this->faker->name,
                'brand' => $this->faker->name,
                'model' => $this->faker->name,
                'year' => $this->faker->name,
                'option' => $this->faker->name,
                'engine_cylinders' => $this->faker->name,
                'engine_displacement' => $this->faker->name,
                'engine_power' => $this->faker->name,
                'engine_torque' => $this->faker->name,
                'engine_fuel_system' => $this->faker->name,
                'engine_fuel' => $this->faker->name,
                'engine_c2o' => $this->faker->name,
                'performance_top_speed' => $this->faker->name,
                'performance_acceleration' => $this->faker->name,
                'fuel_economy_city' => $this->faker->name,
                'fuel_economy_highway' => $this->faker->name,
                'fuel_economy_combined' => $this->faker->name,
                'transmission_drive_type' => $this->faker->name,
                'transmission_gearbox' => $this->faker->name,
                'brakes_front' => $this->faker->name,
                'brakes_rear' => $this->faker->name,
                'tires_size' => $this->faker->name,
                'dimensions_length' => $this->faker->name,
                'dimensions_width' => $this->faker->name,
                'dimensions_height' => $this->faker->name,
                'dimensions_front_rear_track' => $this->faker->name,
                'dimensions_wheelbase' => $this->faker->name,
                'dimensions_ground_clearance' => $this->faker->name,
                'dimensions_cargo_volume' => $this->faker->name,
                'dimensions_cd' => $this->faker->name,
                'weight_unladen' => $this->faker->name,
                'weight_limit' => $this->faker->name
            ];
        }
    }
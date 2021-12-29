<?php

    namespace App\Console\Commands\V1\Car;

    use App\Libraries\V1\NovassetsApi\NovassetsApi;
    use App\Repositories\V1\Eloquent\CarRepository;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Cache;

    class UpdateOrCreate extends Command
    {
        protected $signature = 'v1:car:updateOrCreate';
        protected $description = 'Updates or adds cars list';

        protected CarRepository $carRepository;

        public function __construct(CarRepository $carRepository)
        {
            parent::__construct();
            $this->carRepository = $carRepository;
        }

        public function handle(): int
        {
            $cars = new NovassetsApi();
            $cars = $cars->getAutomobiles();

            if (json_encode($cars) === Cache::get('cars')) {
                $this->warn('Couldn\'t find a tool to update or created!');
                return 0;
            }

            if (!$cars || !isset($cars['RECORDS']) || !count($cars['RECORDS'])) {
                $this->error('Could not fetch cars from api!');
                return 0;
            }

            foreach ($cars['RECORDS'] as $car) {
                $updateOrCreate = $this->carRepository->updateOrCreate($car);
                if (!$updateOrCreate) {
                    $this->error('Failed to create or update car!');
                }
            }

            $redis = Cache::put('cars', json_encode($cars));
            if (!$redis) {
                $this->error('Failed to register to redis!');
            }

            $this->info('All cars added or updated');
            return 1;
        }
    }

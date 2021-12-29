<?php

    namespace App\Repositories\V1\Eloquent;

    use App\Models\V1\Car;
    use Illuminate\Support\Facades\DB;

    class CarRepository implements \App\Repositories\V1\Interfaces\CarRepositoryInterface
    {
        public function getAll()
        {
            try {
                return DB::transaction(function () {
                    return Car::paginate();
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function getCarById($id)
        {
            try {
                return DB::transaction(function () use ($id) {
                    return Car::findOrFail($id);
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function updateOrCreate($data)
        {
            try {
                return DB::transaction(function () use ($data)  {
                    return Car::updateOrCreate($data);
                });
            } catch (\Exception $e) {
                return false;
            }
        }
    }
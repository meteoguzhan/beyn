<?php

    namespace App\Repositories\V1\Eloquent;

    use App\Models\V1\Service;
    use Illuminate\Support\Facades\DB;

    class ServiceRepository implements \App\Repositories\V1\Interfaces\ServiceRepositoryInterface
    {
        public function getAll()
        {
            try {
                return DB::transaction(function () {
                    return Service::paginate();
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function getServiceById($id)
        {
            try {
                return DB::transaction(function () use ($id){
                    return Service::findOrFail($id);
                });
            } catch (\Exception $e) {
                return false;
            }
        }
    }
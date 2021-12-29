<?php

    namespace App\Repositories\V1\Eloquent;

    use App\Models\V1\User;
    use Illuminate\Support\Facades\DB;

    class UserRepository implements \App\Repositories\V1\Interfaces\UserRepositoryInterface
    {
        public function getAll()
        {
            try {
                return DB::transaction(function () {
                    return User::paginate();
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function getUserById($id)
        {
            try {
                return DB::transaction(function () use ($id){
                    return User::findOrFail($id);
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function create($data)
        {
            try {
                return DB::transaction(function () use ($data){
                    return User::create($data);
                });
            } catch (\Exception $e) {
                return false;
            }
        }

        public function updateUserById($data, User $user)
        {
            try {
                return DB::transaction(function () use ($data, $user){
                    $this->getUserById($user->id)->update($data);
                    return $this->getUserById($user->id);
                });
            } catch (\Exception $e) {
                return false;
            }
        }
    }
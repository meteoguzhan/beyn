<?php

    namespace App\Repositories\V1\Interfaces;

    use App\Models\V1\User;

    interface UserRepositoryInterface
    {
        public function getAll();

        public function getUserById($id);

        public function create($data);

        public function updateUserById($data, User $user);
    }
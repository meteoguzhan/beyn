<?php

    namespace App\Repositories\V1\Interfaces;

    use App\Models\V1\User;

    interface OrderRepositoryInterface
    {
        public function getAll();

        public function getOrdersByFilter($filter, User $user);

        public function create($data, User $user);
    }
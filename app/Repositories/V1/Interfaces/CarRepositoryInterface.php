<?php

    namespace App\Repositories\V1\Interfaces;

    interface CarRepositoryInterface
    {
        public function getAll();

        public function getCarById($id);

        public function updateOrCreate($data);
    }
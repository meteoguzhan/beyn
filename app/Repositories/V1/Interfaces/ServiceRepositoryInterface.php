<?php

    namespace App\Repositories\V1\Interfaces;

    interface ServiceRepositoryInterface
    {
        public function getAll();

        public function getServiceById($id);
    }
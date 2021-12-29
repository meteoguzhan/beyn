<?php

    namespace App\Libraries\V1\NovassetsApi;

    class NovassetsApi
    {
        protected string $apiUrl;

        public function __construct()
        {
            $this->apiUrl = 'https://static.novassets.com/';
        }

        public function getAutomobiles(): array|bool
        {
            try {
                return json_decode(file_get_contents($this->apiUrl . 'automobile.json'), true);
            } catch (\Exception $e) {
                return false;
            }
        }
    }
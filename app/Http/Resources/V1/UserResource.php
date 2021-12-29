<?php

    namespace App\Http\Resources\V1;

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use JsonSerializable;

    class UserResource extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param Request $request
         * @return array|JsonSerializable|Arrayable
         */
        public function toArray($request): array|JsonSerializable|Arrayable
        {
            return parent::toArray($request);
        }
    }
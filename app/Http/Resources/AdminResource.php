<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'  =>  $this->id,
            'type'=>  'admin',
            'attributes' =>  [
                'name'  =>  $this->name,
                'email' =>  $this->email,
                'image' =>  $this->image,
            ],
        ];
    }
}

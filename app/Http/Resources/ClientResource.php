<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'  =>  $this->id,
            'type'=>  'client',
            'attributes' =>  [
                'name'  =>  $this->name,
                'email' =>  $this->email,
                'phone' =>  $this->phone,
                'address'=>  $this->address,
                'image' =>  $this->image,
            ],
        ];
    }
}

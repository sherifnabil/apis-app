<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientProducts extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    =>  $this->id,
            'type'  =>  'user-bought-products',
            'attributes' =>  [
                'name'  =>  $this->name,
                'image' =>  'storage/' . $this->image,
                'email'=>  $this->email,
            ],
            'relationships' =>  [
                'products'  =>  ProductResource::collection(
                    resource: $this->whenLoaded(
                        relationship: 'products'
                    )
                )
            ]
        ];
    }
}

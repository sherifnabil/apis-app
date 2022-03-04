<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    =>  $this->id,
            'type'  =>  'product',
            'attributes' =>  [
                'price'=>  $this->price,
                'name'  =>  $this->name,
                'image' =>  'storage/' . $this->image,
                'active' =>  $this->active,
                'description'=>  $this->description,
            ],
            'relationships' =>  [
                'category'  =>  new CategoryResource(
                    resource: $this->whenLoaded(
                        relationship: 'category'
                    )
                )
            ]
        ];
    }
}

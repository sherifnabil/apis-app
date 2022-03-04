<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    =>  $this->id,
            'type'  =>  'category',
            'attributes' =>  [
                'name'  =>  $this->name,
                'image' =>  'storage/' . $this->image,
                'active'=>  $this->active,
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

<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'  =>  $this->faker->words(2, true),
            'image'  =>  storage_path('jm-category.png'),
            'active'  =>  $this->faker->boolean()
        ];
    }
}

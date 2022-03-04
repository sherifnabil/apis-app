<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'  =>  $this->faker->words(2, true),
            'image'  =>  storage_path('jm-category.png'),
            'active'  =>  $this->faker->boolean(),
            'description'   =>  $this->faker->paragraphs(3, true),
            'price' =>  $this->faker->numberBetween(50, 750),
            'category_id'   =>  Category::all()->random()->id
        ];
    }
}

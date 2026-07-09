<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'category_id'   => Category::factory(),
            'name'          => ucfirst($name),
            'slug'          => Str::slug($name),
            'short_desc'    => fake()->sentence(),
            'description'   => fake()->paragraph(),
            'images'        => [],
            'badge'         => null,
            'badge_color'   => null,
            'featured'      => false,
            'active'        => true,
            'views_count'   => 0,
            'contact_count' => 0,
            'sort_order'    => 0,
        ];
    }
}

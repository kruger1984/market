<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'sku' => $this->faker->uuid(),
            'price' => $this->faker->numberBetween(1, 100),
            'old_price' => $this->faker->numberBetween(1, 100),
            'qty' => $this->faker->numberBetween(1, 100),
            'product_group_id' => ProductGroup::factory(),
            'category_id' => Category::factory(),
            'parent_id' => null,
        ];
    }

    public function nested(Product $parent): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => $parent->id,
        ]);
    }
}

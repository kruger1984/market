<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Param;
use App\Models\ParamProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ParamProduct>
 */
class ParamProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'param_id' => Param::factory(),
            'value' => $this->faker->numberBetween(1, 100),
        ];
    }
}

<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Models\Param;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Param>
 */
class ParamFactory extends Factory
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
            'label' => $this->faker->slug(),
            'filter_type' => $this->faker->randomElement(ParamFilterTypeEnum::values()),
        ];
    }
}

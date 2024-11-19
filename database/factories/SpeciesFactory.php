<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Species>
 */
class SpeciesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'common_name'   => $this->faker->randomElement(['Shark', 'Dog', 'Fish', 'Cat']),
            'class_name'    => 'CHONDRICHTHYES',
            'order_name'    => 'CARCHARHINIFORMES',
            'category'      =>  $this->faker->randomElement(["DD", "LC", "NT", "VU", "EN", "CR", "EW", "EX", "LR/lc", "LR/nt", "LR/cd"]),
            'measures'      => 'Site/area protection,Site/area management'
        ];
    }
}

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
            'taxonid'       => $this->faker->unique()->randomNumber(),
            'common_name'   => $this->faker->randomElement(['Shark', 'Dog', 'Fish', 'Cat']),
            'class_name'    => $this->faker->randomElement(['ACTINOPTERYGII', 'ARTHROPODA', 'MAMMALIA', 'CHONDRICHTHYES']),
            'category'      =>  $this->faker->randomElement(["DD", "LC", "NT", "VU", "EN", "CR", "EW", "EX", "LR/lc", "LR/nt", "LR/cd"]),
            'measures'      => 'Site/area protection,Site/area management'
        ];
    }
    public function mammal(): array
    {
        return [
            'taxonid'       => $this->faker->unique()->randomNumber(),
            'common_name'   => $this->faker->randomElement(['Shark', 'Dog', 'Fish', 'Cat']),
            'class_name'    =>  'MAMMALIA',
            'category'      =>  $this->faker->randomElement(["DD", "LC", "NT", "VU", "EN", "CR", "EW", "EX", "LR/lc", "LR/nt", "LR/cd"]),
        ];
    }

    public function notMammal(): array
    {
        return [
            'taxonid'       => $this->faker->unique()->randomNumber(),
            'common_name'   => $this->faker->randomElement(['Shark', 'Dog', 'Fish', 'Cat']),
            'class_name'    =>  $this->faker->randomElement(['ACTINOPTERYGII', 'ARTHROPODA', 'CHONDRICHTHYES']),
            'category'      =>  $this->faker->randomElement(["DD", "LC", "NT", "VU", "EN", "CR", "EW", "EX", "LR/lc", "LR/nt", "LR/cd"]),
        ];
    }

    public function endangered(): array
    {
        return [
            'taxonid'       => $this->faker->unique()->randomNumber(),
            'common_name'   => $this->faker->randomElement(['Shark', 'Dog', 'Fish', 'Cat']),
            'class_name'    =>  $this->faker->randomElement(['ACTINOPTERYGII', 'ARTHROPODA', 'CHONDRICHTHYES']),
            'category'      =>  "CR",
        ];
    }

    public function notEndangered(): array
    {
        return [
            'taxonid'       => $this->faker->unique()->randomNumber(),
            'common_name'   => $this->faker->randomElement(['Shark', 'Dog', 'Fish', 'Cat']),
            'class_name'    =>  $this->faker->randomElement(['ACTINOPTERYGII', 'ARTHROPODA', 'CHONDRICHTHYES']),
            'category'      =>  "NT",
        ];
    }

}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name'=>fake()->name(),
//            'status'=>rand(0,1),
            'slug'=>$this->faker->unique()->slug(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{

    public function definition(): array
    {
        $subCategory = SubCategory::inRandomOrder()->first();
//        $category = Category::inRandomOrder()->first();
        $brand = Brand::inRandomOrder()->first();

        return [
            'title'=>fake()->name(),
            'description'=>fake()->paragraph(30),
            'short_description'=>fake()->paragraph(3),
            'slug'=>$this->faker->unique()->slug(),
            'price'=>fake()->randomFloat(2, 100, 100000),
//            'compare_price'=>fake()->randomFloat(2, 0, 1000),
            'category_id'=>$subCategory->category->id,
            'sub_category_id'=>$subCategory->id,
            'brand_id'=>$brand->id,
            'is_featured'=>['Yes', 'No'][array_rand(['Yes', 'No'])],
            'sku'=>$this->faker->unique()->word,
            'max_order'=>fake()->numberBetween(0,10),
            'weight'=>fake()->numberBetween(0,50),
            'qty'=>fake()->numberBetween(0,300),
//            'status'=>rand(0,1),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = auth()->user()->id;

        $category = Category::all();
        return [
            //
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(10,100),
            'category_id'  => $category->random()->id,
            'user_id' => auth()->user()->id,
        ];
    }
}

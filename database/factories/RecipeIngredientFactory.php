<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RecipeIngredient;
use App\Models\Recipe;

class RecipeIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'recipe_id' => function() {
                return Recipe::inRandomOrder()
                    ->first();
            },
            'quantity' => function() {
                if (rand(0, 1) === 0) {
                    return null;
                }

                return rand (1, 5);
            },
            'description' => ucfirst(implode(' ', $this->faker->words(rand(2, 8)))),
        ];
    }
}

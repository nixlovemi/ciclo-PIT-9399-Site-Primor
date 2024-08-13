<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RecipeStep;
use App\Models\Recipe;

class RecipeStepFactory extends Factory
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
            'title' => function() {
                if (rand(0, 1) === 0) {
                    return null;
                }

                return ucfirst(implode(' ', $this->faker->words(rand(2, 6))));
            },
            'description' => ucfirst(implode(' ', $this->faker->words(rand(5, 15)))),
        ];
    }
}

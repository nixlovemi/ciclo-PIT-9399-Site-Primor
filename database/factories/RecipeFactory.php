<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recipe;

class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(Recipe::TYPES),
            'difficulty' => $this->faker->randomElement(Recipe::DIFFICULTIES),
            'title' => ucfirst(implode(' ', $this->faker->words(rand(2, 4)))),
            'slug' => function(array $attributes) {
                return strtolower(str_replace(' ', '-', $attributes['title']));
            },
            'thumb_url' => $this->faker->randomElement([
                '/templates/primor-v1/images/receitas-arroz-de-cuxa-single.jpg'
            ]),
            'banner_url' => $this->faker->randomElement([
                '/templates/primor-v1/images/receitas-arroz-de-cuxa-banner.jpg'
            ]),
            'time_str' => $this->faker->randomElement([
                '15 min',
                '30 min',
                '45 min',
                '60 min',
                '90 min',
                '120 min',
            ]),
            'portions_str' => function() {
                return rand(2, 10) . ' porções';
            },
            'active' => $this->faker->randomElement([true, false]),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->UserSeed();
        $this->RecipeSeed();
        $this->RecipeIngredientsSeed();
        $this->RecipeStepsSeed();
    }

    private function UserSeed(): void
    {
        User::factory(1)->create([
            'email' => 'nixlovemi@gmail.com',
            'active' => 1,
        ]);
    }

    private function RecipeSeed(): void
    {
        Recipe::factory(5)->create([
            'active' => 1
        ]);

        Recipe::factory(2)->create([
            'active' => 0
        ]);
    }

    private function RecipeIngredientsSeed(): void
    {
        $Recipes = Recipe::get();
        foreach ($Recipes as $Recipe) {
            RecipeIngredient::factory(rand(2, 6))->create([
                'recipe_id' => $Recipe->id
            ]);
        }
    }

    private function RecipeStepsSeed(): void
    {
        $Recipes = Recipe::get();
        foreach ($Recipes as $Recipe) {
            RecipeStep::factory(rand(2, 6))->create([
                'recipe_id' => $Recipe->id
            ]);
        }
    }
}

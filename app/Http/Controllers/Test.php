<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class Test extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addNewRecipe()
    {
        /*
        $arrRecipes = [
            [
                'type' => Recipe::TYPE_LANCHE,
                'difficulty' => Recipe::DIFFICULTY_FACIL,
                'title' => 'Farofa de Paçoquinha',
                'slug' => 'lanche-farofa-de-pacoquinha',
                'thumb_url' => '/templates/primor-v1/images/receitas-farofa-de-pacoquinha-single.jpg',
                'banner_url' => '/templates/primor-v1/images/receitas-farofa-de-pacoquinha-banner.jpg',
                'time_str' => '40 min',
                'portions_str' => '12 porções',
                'ingredients' => [
                    [
                        'quantity' => '1kg',
                        'description' => 'de carne-de-sol magra'
                    ],
                    [
                        'quantity' => '1',
                        'description' => 'unidade de cebola branca ou roxa, picada'
                    ],
                    [
                        'quantity' => '1',
                        'description' => 'xícara (chá) de farinha de Mandioca torrada'
                    ],
                    [
                        'quantity' => '4',
                        'description' => 'colheres de sopa de margarina Primor'
                    ],
                    [
                        'quantity' => '1',
                        'description' => 'Moi de Coentro e cebolinha para servir a gosto'
                    ],
                ],
                'steps' => [
                    [
                        'title' => null,
                        'description' => 'Colocar a carne de molho em água, trocando-a de vez em quando para tirar o sal.'
                    ],
                    [
                        'title' => null,
                        'description' => 'Assar na brasa ou então fritar na margarina Primor'
                    ],
                    [
                        'title' => null,
                        'description' => 'Deixar esfriar a carne.'
                    ],
                    [
                        'title' => null,
                        'description' => 'Colocar a carne, em pequenas porções, no processador com a farinha.'
                    ],
                    [
                        'title' => null,
                        'description' => 'Após processar toda a carne, levar ao fogo novamente com cebola e Margarina Primor.'
                    ],
                    [
                        'title' => null,
                        'description' => 'Na hora de servir, colocar em uma travessa grande e decorar com coentro e cebolinha a gosto.'
                    ],
                ]
            ]
        ];

        foreach ($arrRecipes as $recipe) {
            $Recipe = new Recipe();
            $Recipe->fill($recipe);
            $Recipe->save();

            foreach ($recipe['ingredients'] as $ingredient) {
                $RecipeIngredient = new \App\Models\RecipeIngredient();
                $RecipeIngredient->fill($ingredient);
                $RecipeIngredient->recipe_id = $Recipe->id;
                $RecipeIngredient->save();
            }

            foreach ($recipe['steps'] as $step) {
                $RecipeStep = new \App\Models\RecipeStep();
                $RecipeStep->fill($step);
                $RecipeStep->recipe_id = $Recipe->id;
                $RecipeStep->save();
            }
        }
        */
    }

    public function fix()
    { }
}
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CarouselRecipe extends Component
{
    public array $_recipes = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_recipes = $this->getRecipes();
    }

    private function getRecipes()
    {
        return [
            [
                'type' => 'Lanche',
                'title' => 'Salgadinho de Queijo',
                'image' => 'templates/primor-v1/images/receitas-item-01.jpg',
                'details' => null,
                'timeStr' => '90 min',
                'portionsStr' => '10 porções',
            ],
            [
                'type' => 'Sobremesa',
                'title' => 'Bolo de Mandioca',
                'image' => 'templates/primor-v1/images/receitas-item-02.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '8 porções',
            ],
            [
                'type' => 'Jantar',
                'title' => 'Arrumadinho de Carne Seca',
                'image' => 'templates/primor-v1/images/receitas-item-03.jpg',
                'details' => 'Deixe qualquer dia<br />com cara de domingo!',
                'timeStr' => '45 min',
                'portionsStr' => '3 porções',
            ],
            [
                'type' => 'Almoço',
                'title' => 'Arroz Maria Isabel',
                'image' => 'templates/primor-v1/images/receitas-item-04.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '10 porções',
            ],
            [
                'type' => 'Lanche',
                'title' => 'Bolo Pé de Moloque',
                'image' => 'templates/primor-v1/images/receitas-item-05.jpg',
                'details' => null,
                'timeStr' => '60 min',
                'portionsStr' => '12 porções',
            ],
            [
                'type' => 'Sobremesa',
                'title' => 'Sorvete Caseiro',
                'image' => 'templates/primor-v1/images/receitas-item-06.jpg',
                'details' => null,
                'timeStr' => '45 min',
                'portionsStr' => '10 porções',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.carousel-recipe');
    }
}

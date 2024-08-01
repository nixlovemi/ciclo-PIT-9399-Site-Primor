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
        return \App\Helpers\SysUtils::getRecipes();
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

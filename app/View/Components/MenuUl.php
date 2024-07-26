<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuUl extends Component
{
    public array $_items = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->initMenuItems();
    }

    private function initMenuItems(): void
    {
        $this->_items = [
            [
                'url' => '/',
                'title' => 'Home',
            ],
            [
                'url' => '/produtos',
                'title' => 'Produtos',
            ],
            [
                'url' => '/receitas',
                'title' => 'Receitas',
            ],
            [
                'url' => '/campanha',
                'title' => 'Campanha',
            ],
            [
                'url' => '/nossa-historia',
                'title' => 'Nossa História',
            ],
            [
                'url' => '/fale-conosco',
                'title' => 'Fale Conosco',
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
        return view('components.menu-ul');
    }
}

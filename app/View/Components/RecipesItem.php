<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RecipesItem extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $type,
        public string $title,
        public string $image,
        public string $timeStr,
        public string $portionsStr,
        public ?string $url=null,
        public ?string $details=null,
    ) {
        if (null === $this->url || empty($this->url)) {
            $this->url = 'javascript:;';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.recipes-item');
    }
}

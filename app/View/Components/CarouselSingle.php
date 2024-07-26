<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CarouselSingle extends Component
{
    /**
     * Create a new component instance.
     * @var array $slides [title, description, descriptionShort (fill if want it to display for size lg), image, link]
     *
     * @return void
     */
    public function __construct(
        public array $slides = []
    ) { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.carousel-single');
    }
}

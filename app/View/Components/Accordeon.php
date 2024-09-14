<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Accordeon extends Component
{
    public $idCode = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $title,
        public string $id,
        public string $content = ''
    ) {
        $this->idCode = $id . '-' . substr(md5($id), 0, 5);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.accordeon');
    }
}

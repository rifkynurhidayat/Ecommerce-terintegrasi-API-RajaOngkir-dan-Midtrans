<?php

namespace App\View\Components;

use App\Support\ProductCollection;
use Illuminate\View\Component;

class ProductSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ProductCollection $products
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product-section');
    }
}

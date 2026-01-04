<?php

namespace App\View\Components\Home\LocationSection\Maps;

use Illuminate\View\Component;

class Script extends Component
{
    public $umkms;
    public $regionList;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mapShops, $regionsMap)
    {
        $this->umkms = $mapShops;
        $this->regionList = $regionsMap;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home.location-section.maps.script');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $active;

    public function __construct($active)
    {
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $data = $this->list(); 

        return view('components.menu',['list' => $data,
                                        'active' => $this->active]);
    }

    public function list(){
        return [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'fas fa-tachometer-alt'
            ],
            [
                'label' => 'Movies',
                'route' => 'dashboard.movies',
                'icon' => 'fas fa-video'
            ],
            [
                'label' => 'Theaters',
                'route' => 'dashboard.theaters',
                'icon' => 'fas fa-university'
            ],
            [
                'label' => 'Tickets',
                'route' => 'dashboard.tickets',
                'icon' => 'fas fa-ticket-alt'
            ],
            [
                'label' => 'Users',
                'route' => 'dashboard.users',
                'icon' => 'fas fa-users'
            ]
        ];
    }

    public function isActive($label){
        return $label === $this->active;
    }
}

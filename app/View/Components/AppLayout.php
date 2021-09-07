<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        if (\Route::current()->getName() == 'profile.show') {
            $titulo = 'Editar Perfil';
        }

        return view('layouts.app', compact('titulo'));
    }
}

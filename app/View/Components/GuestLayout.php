<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */

    public function render()
    {
        if (\Route::current()->getName() == 'login') {
            $titulo = 'Login';
        }

        if (\Route::current()->getName() == 'register') {
            $titulo = 'Cadastrar';
        }

        return view('layouts.guest', compact('titulo'));
    }
}

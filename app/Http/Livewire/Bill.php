<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Bill extends Component
{
    protected $listeners = ['render'];

    public function render()
    {
        return view('livewire.bill')->layout('pages.bills');
    }
}

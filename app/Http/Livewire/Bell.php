<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Livewire\Component;

class Bell extends Component
{

    protected $listeners = ['render']; 

    public function render()
    {

        $notificacoes = Notification::where('user_id', auth()->user()->id)->where('is_read', 0)->limit(4)->latest('id')->get();
        $notificacoes_not_read = Notification::where('user_id', auth()->user()->id)->where('is_read', 0)->count();

        return view('livewire.bell', compact('notificacoes', 'notificacoes_not_read'));
    }
}

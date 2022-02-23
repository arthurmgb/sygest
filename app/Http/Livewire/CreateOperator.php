<?php

namespace App\Http\Livewire;

use App\Models\Operator;
use Livewire\Component;

class CreateOperator extends Component
{

    public $state = [];

    public $rules = [

        'state.nome' => 'required|max:100',    
    ];

    protected $messages = [
        
        'state.nome.required' => 'O nome do operador é obrigatório.',
        
    ];

    public function confirmation(){

        $this->validate();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('confirmation-modal');

    }

    public function resetNewOperation(){

        $this->dispatchBrowserEvent('close-modal');
        $this->reset('state');

    }

    public function resetOperation(){

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');

    }

    public function alternate(){

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->dispatchBrowserEvent('show-modal');

    }

    public function save(){

        Operator::create([

            'nome' => $this->state['nome'],
            'user_id' => auth()->user()->id

        ]);

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');        
        $this->emit('alert', 'Operador cadastrado com sucesso!');
        $this->emitTo('configuracao', 'render');
    }

    public function render()
    {
        return view('livewire.create-operator');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CreateCat extends Component
{

    public $state = [];

    public $rules = [

        'state.tipo' => 'required',
        'state.status' => 'required',
        'state.descricao' => 'required|max:100',    
    ];

    protected $messages = [
        
        'state.tipo.required' => 'O tipo de categoria é obrigatório.',
        'state.status.required' => 'O status da categoria é obrigatório.',
        'state.descricao.required' => 'A descrição da categoria é obrigatória.',
        
    ];

    public function mount(){

        $this->state['tipo'] = '1';
        $this->state['status'] = '1';

    }

    public function confirmation(){

        $this->validate();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('confirmation-modal');

    }

    public function resetNewOperation(){

        $this->dispatchBrowserEvent('close-modal');
        $this->reset('state');
        $this->state['tipo'] = '1';
        $this->state['status'] = '1';

    }

    public function resetOperation(){

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '1';
        $this->state['status'] = '1';

    }

    public function alternate(){

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->dispatchBrowserEvent('show-modal');

    }

    public function save(){

        Category::create([

            'tipo' => $this->state['tipo'],
            'descricao' => $this->state['descricao'],
            'status' => $this->state['status'],
            'user_id' => auth()->user()->id

        ]);

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '1';
        $this->state['status'] = '1';
        
        $this->emit('alert', 'Categoria cadastrada com sucesso!');
        $this->emitTo('categoria', 'render');
    }

    public function render()
    {
        return view('livewire.create-cat');
    }
}

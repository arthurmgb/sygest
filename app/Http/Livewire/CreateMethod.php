<?php

namespace App\Http\Livewire;

use App\Models\Method;
use Livewire\Component;

class CreateMethod extends Component
{

    public $state = [];

    public $rules = [

        'state.status' => 'required',
        'state.descricao' => 'required|max:100',    
    ];

    protected $messages = [
        
        'state.status.required' => 'O status da forma de pagamento é obrigatório.',
        'state.descricao.required' => 'A descrição da forma de pagamento é obrigatória.',
        
    ];

    public function mount(){

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
        $this->state['status'] = '1';

    }

    public function resetOperation(){

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['status'] = '1';

    }

    public function alternate(){

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->dispatchBrowserEvent('show-modal');

    }

    public function save(){

        $fp = new Method;
        $fp->user_id = auth()->user()->id;
        $fp->descricao = $this->state['descricao'];
        $fp->status = $this->state['status'];
        $fp->save();

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['status'] = '1';
        
        $this->emit('alert', 'Forma de pagamento cadastrada com sucesso!');
        $this->emitTo('forma-pagamento', 'render');
    }

    public function render()
    {
        return view('livewire.create-method');
    }
}

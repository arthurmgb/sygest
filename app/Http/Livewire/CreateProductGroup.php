<?php

namespace App\Http\Livewire;

use App\Models\Product_Group;
use Livewire\Component;

class CreateProductGroup extends Component
{

    public $state = [];

    public $rules = [

        'state.descricao' => 'required|max:100',

    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição do grupo é obrigatória.',
    ];

    public function confirmation()
    {

        $this->validate();
        $this->dispatchBrowserEvent('close-item-modal');
        $this->dispatchBrowserEvent('show-item-confirmation-modal');
    }

    public function resetData()
    {

        $this->dispatchBrowserEvent('close-item-modal');
        $this->reset('state');
    }

    public function resetDataOnConfirm()
    {

        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->reset('state');
    }

    public function alternate()
    {

        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->dispatchBrowserEvent('show-item-modal');
    }

    public function save()
    {

        Product_Group::create([
            'descricao' => $this->state['descricao'],
            'user_id' => auth()->user()->id

        ]);

        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->reset('state');

        $this->emit('alert', 'Grupo cadastrado com sucesso!');
        $this->emitTo('product-group', 'render');
    }

    public function render()
    {
        return view('livewire.create-product-group');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;

class CreateClient extends Component
{

    public $state = [];

    public $rules = [

        'state.nome' => 'required|max:100',
        'state.documento' => 'max:18|min:14',
        'state.rg' => 'max:18',
        'state.endereco' => 'max:100',
        'state.celular' => 'max:15|min:14',
        'state.email' => 'max:100',
        'state.obs' => 'max:500',
    ];

    protected $messages = [

        'state.nome.required' => 'O nome do cliente é obrigatório.',

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
        foreach ($this->state as $key => $value) {
            $this->state[$key] = empty($value) ? null : $value;
        }

        Client::create([
            'nome' => $this->state['nome'],
            'documento' => $this->state['documento'] ?? null,
            'rg' => $this->state['rg'] ?? null,
            'endereco' => $this->state['endereco'] ?? null,
            'celular' => $this->state['celular'] ?? null,
            'email' => $this->state['email'] ?? null,
            'obs' => $this->state['obs'] ?? null,
            'user_id' => auth()->user()->id
        ]);

        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->reset('state');

        $this->emit('alert', 'Cliente cadastrado com sucesso!');
        $this->emitTo('client', 'render');
    }

    public function render()
    {
        return view('livewire.create-client');
    }
}

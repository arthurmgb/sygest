<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Shortcut as ModelsShortcut;

class CreateShortcut extends Component
{

    public $state = [];

    public $rules = [
        'state.descricao' => 'required|max:100',
        'state.url' => 'required',
    ];

    protected $messages = [

        'state.url.required' => 'A URL do link é obrigatória.',
        'state.descricao.required' => 'A descrição do link é obrigatória.',

    ];

    public function mount(){
        $this->state['cor'] = '#555555';
    }

    public function resetNewOperation()
    {

        $this->dispatchBrowserEvent('close-modal');
        $this->reset('state');
        $this->state['cor'] = '#555555';

    }

    public function save()
    {

        $this->validate();
        $this->dispatchBrowserEvent('close-modal');

        ModelsShortcut::create([

            'descricao' => $this->state['descricao'],
            'url' => $this->state['url'],
            'cor' => $this->state['cor'],
            'user_id' => auth()->user()->id

        ]);

        $this->reset('state');
        $this->state['cor'] = '#555555';
        $this->emit('alert', 'Link cadastrado com sucesso!');
        $this->emitTo('shortcut', 'render');
    }

    public function render()
    {
        return view('livewire.create-shortcut');
    }
}


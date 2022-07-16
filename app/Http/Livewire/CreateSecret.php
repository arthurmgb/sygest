<?php

namespace App\Http\Livewire;

use App\Models\Secret;
use Livewire\Component;

class CreateSecret extends Component
{

    public $state = [];
    public $blur;

    public $rules = [
        'state.descricao' => 'required|max:100',
        'state.login' => 'max:100',
        'state.senha' => 'required|max:100',
    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição da senha é obrigatória.',
        'state.senha.required' => 'É obrigatório definir uma senha.',

    ];

    public function mount(){
        $this->blur = 'yes';
    }

    public function toggleBlur(){

        if($this->blur == 'yes'){
            $this->blur = 'no';
        }elseif($this->blur == 'no'){
            $this->blur = 'yes';
        } 

    }

    public function confirmation(){

        $this->validate();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('confirmation-modal');

    }

    public function resetOperation(){

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->blur = 'yes';

    }

    public function resetNewOperation()
    {

        $this->dispatchBrowserEvent('close-modal');
        $this->reset('state');
        $this->blur = 'yes';

    }

    public function save()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');

        $this->state['descricao'] = trim($this->state['descricao']);
        $this->state['senha'] = trim($this->state['senha']);

        if(!isset($this->state['login']) or empty($this->state['login'])){

            $this->state['login'] = null;

        }else{

            $this->state['login'] = trim($this->state['login']);

            if(empty($this->state['login'])){
                $this->state['login'] = null;
            }

        }

        $pass = new Secret;
        $pass->user_id = auth()->user()->id;
        $pass->descricao = $this->state['descricao'];
        $pass->login = $this->state['login'];
        $pass->senha = $this->state['senha'];

        $pass->save();

        $this->reset('state');
        $this->blur = 'yes';
        $this->emit('alert', 'Senha cadastrada com sucesso!');
        $this->emitTo('senha', 'render');
    }

    public function render()
    {
        return view('livewire.create-secret');
    }
}

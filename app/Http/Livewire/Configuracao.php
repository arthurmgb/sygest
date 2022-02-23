<?php

namespace App\Http\Livewire;

use App\Models\Operator;
use Livewire\Component;
use Livewire\WithPagination;

class Configuracao extends Component
{

    use WithPagination;
    public $operador;
    protected $paginationTheme = 'bootstrap';
    public $qtd = 10;
    protected $listeners = ['render'];

    public $rules = [

        'operador.nome' => 'required|max:100',

    ];

    protected $messages = [

        'operador.nome.required' => 'O nome do operador é obrigatório.',

    ];

    public function confirmation()
    {
        $this->validate();
        $this->dispatchBrowserEvent('close-edit-modal');
        $this->dispatchBrowserEvent('show-edit-confirmation-modal');
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
    }

    public function alternate()
    {

        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function edit(Operator $operador)
    {

        $this->operador = $operador;
    }

    public function update()
    {

        $this->operador->save();
        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
        $this->emit('alert', 'Operador editado com sucesso!');
    }

    public function prepare(Operator $operador)
    {

        $this->operador = $operador;
        
    }

    public function delete()
    {       
        $this->operador->delete();
        $this->dispatchBrowserEvent('close-delete-cat-confirmation-modal');
        $this->emit('alert', 'Operador apagado com sucesso!');
    }
    
    public function render()
    {

        $operators = Operator::where('user_id', auth()->user()->id)
            ->latest('id')
            ->paginate($this->qtd);

        $operators_count = $operators->count();

        return view('livewire.configuracao', compact('operators', 'operators_count'))
        ->layout('pages.configuracoes');
    }
}

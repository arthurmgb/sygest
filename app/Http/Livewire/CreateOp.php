<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Operation;
use Livewire\Component;

class CreateOp extends Component
{

    public $state = [];

    public $rules = [

        'state.tipo' => 'required',
        'state.descricao' => 'required|max:100',
        'state.categoria' => 'required',
        'state.total' => 'required',

    ];

    protected $messages = [

        'state.tipo.required' => 'O tipo de operação é obrigatório.',
        'state.descricao.required' => 'A descrição da operação é obrigatória.',
        'state.categoria.required' => 'A categoria da operação é obrigatória.',
        'state.total.required' => 'O total da operação é obrigatório.',

    ];

    public function changeOperation()
    {
        
        $this->state['categoria'] = "";
    }

    public function mount()
    {

        $this->state['tipo'] = '1';
    }

    public function confirmation()
    {

        $this->validate();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('confirmation-modal');
    }

    public function resetNewOperation()
    {

        $this->dispatchBrowserEvent('close-modal');
        $this->reset('state');
        $this->state['tipo'] = '1';
        $this->state['categoria'] = "";
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '1';
        $this->state['categoria'] = "";
    }

    public function alternate()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {

        $total_formatado = str_replace(',', '.', $this->state['total']);

        Operation::create([

            'tipo' => $this->state['tipo'],
            'descricao' => $this->state['descricao'],
            'category_id' => $this->state['categoria'],
            'total' => $total_formatado,
            'user_id' => auth()->user()->id

        ]);

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '1';
        $this->state['categoria'] = "";

        $this->emit('alert', 'Operação realizada com sucesso!');
        $this->emitTo('fluxo-caixa', 'render');
        $this->emitTo('visao-geral', 'render');
    }

    public function render()
    {

        $categorias = Category::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->where('tipo', $this->state['tipo'])
            ->orderBy('descricao', 'asc')
            ->get();

        return view('livewire.create-op', compact('categorias'));
    }
}

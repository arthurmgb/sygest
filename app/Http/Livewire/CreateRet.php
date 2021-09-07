<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Livewire\Component;

class CreateRet extends Component
{

    public $state = [];

    public $rules = [

        'state.descricao' => 'required|max:100',
        'state.total' => 'required',

    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição da retirada é obrigatória.',
        'state.total.required' => 'O total da retirada é obrigatório.',

    ];

    public function mount()
    {

        $this->state['tipo'] = '3';
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
        $this->state['tipo'] = '3';
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '3';
    }

    public function alternate()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {

        //Verifica se há receita disponível para retirada
        $receita_entrada = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [1])
            ->sum('total');

        $receita_saida = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [0, 3])
            ->sum('total');

        $receita_valor = $receita_entrada - $receita_saida;

        $total_formatado = str_replace(',', '.', $this->state['total']);

        if ($total_formatado <= $receita_valor) {

            Operation::create([

                'tipo' => $this->state['tipo'],
                'descricao' => $this->state['descricao'],
                'category_id' => null,
                'total' => $total_formatado,
                'user_id' => auth()->user()->id

            ]);

            $this->dispatchBrowserEvent('close-confirm-modal');
            $this->reset('state');
            $this->state['tipo'] = '3';

            $this->emit('alert', 'Retirada realizada com sucesso!');
            $this->emitTo('retirada', 'render');

        } else {

            $this->dispatchBrowserEvent('close-confirm-modal');
            $this->reset('state');
            $this->state['tipo'] = '3';

            $this->emit('alert-error', 'Você não possui saldo suficiente para realizar uma retirada de caixa.');
            $this->emitTo('retirada', 'render');

        }

        //Fim verificação

    }

    public function render()
    {
        return view('livewire.create-ret');
    }
}

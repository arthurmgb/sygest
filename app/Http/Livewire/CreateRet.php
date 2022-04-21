<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use App\Models\Operator;
use Livewire\Component;

class CreateRet extends Component
{

    public $state = [];

    public $rules = [

        'state.descricao' => 'required|max:100',
        'state.total' => 'required',
        'state.operador' => 'required',
        'state.especie' => 'required',

    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição da retirada é obrigatória.',
        'state.total.required' => 'O total da retirada é obrigatório.',
        'state.operador.required' => 'O operador de caixa é obrigatório.',
        'state.especie.required' => 'A espécie da operação é obrigatória.',

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
        $this->state['operador'] = "";
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '3';
        $this->state['operador'] = "";
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

        if($total_formatado == 0){
            $this->emit('alert-error', 'O total da operação deve ser maior do que zero.');
        }else{

            if ($total_formatado <= $receita_valor) {

                Operation::create([

                    'tipo' => $this->state['tipo'],
                    'descricao' => $this->state['descricao'],
                    'category_id' => null,
                    'operator_id' => $this->state['operador'],
                    'especie' => $this->state['especie'],
                    'total' => $total_formatado,
                    'user_id' => auth()->user()->id

                ]);

                $this->dispatchBrowserEvent('close-confirm-modal');
                $this->reset('state');
                $this->state['tipo'] = '3';
                $this->state['operador'] = "";

                $this->emit('alert', 'Retirada realizada com sucesso!');
                $this->emitTo('retirada', 'render');

            } else {

                $this->dispatchBrowserEvent('close-confirm-modal');
                $this->reset('state');
                $this->state['tipo'] = '3';
                $this->state['operador'] = "";

                $this->emit('alert-error', 'Você não possui saldo suficiente para realizar uma retirada de caixa.');
                $this->emitTo('retirada', 'render');

            }

        }

        //Fim verificação

    }

    public function render()
    {

        $operadores = Operator::where('user_id', auth()->user()->id)
        ->orderBy('nome', 'asc')
        ->get();

        return view('livewire.create-ret', compact('operadores'));
    }
}

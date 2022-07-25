<?php

namespace App\Http\Livewire;

use App\Models\Method;
use App\Models\Operation;
use App\Models\Operator;
use Livewire\Component;

class CreateRet extends Component
{

    protected $listeners = ['refreshComponent' => '$refresh'];
    public $state = [];
    public $is_operator_default;

    public $rules = [

        'state.descricao' => 'required|max:100',
        'state.total' => 'required|max:10',
        'state.operador' => 'required',
        'state.especie' => 'required',

    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição da retirada é obrigatória.',
        'state.total.required' => 'O total da retirada é obrigatório.',
        'state.operador.required' => 'O operador de caixa é obrigatório.',
        'state.especie.required' => 'A espécie da operação é obrigatória.',

    ];

    public function refreshOp(){
        $this->emit('refreshComponent');
    }

    public function mount()
    {

        $this->state['tipo'] = '3';
        $this->state['fp'] = "";

        $get_default_operator = Operator::where('user_id', auth()->user()->id)->where('is_default', 1)->first();
        
        if(!is_null($get_default_operator)){
            $this->state['operador'] = $get_default_operator->id;
            $this->is_operator_default = 'disabled';
        }else{
            $this->is_operator_default = 'active';
        }

    }

    public function dehydrate(){

        $get_default_operator = Operator::where('user_id', auth()->user()->id)->where('is_default', 1)->first();
        
        if(!is_null($get_default_operator)){
            $this->state['operador'] = $get_default_operator->id;
            $this->is_operator_default = 'disabled';
        }else{
            $this->is_operator_default = 'active';
        }
        
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
        $this->state['especie'] = "";
        $this->state['fp'] = "";
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '3';
        $this->state['operador'] = "";
        $this->state['especie'] = "";
        $this->state['fp'] = "";
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

        $total_formatado = str_replace(".", "", $this->state['total']);
        $total_formatado = str_replace(',', '.', $total_formatado);

        if($total_formatado == 0){
            $this->emit('alert-error', 'O total da operação deve ser maior do que zero.');
        }else{

            if ($total_formatado <= $receita_valor) {

                if(empty($this->state['fp'])){
                    $this->state['fp'] = null;
                }

                Operation::create([

                    'tipo' => $this->state['tipo'],
                    'descricao' => $this->state['descricao'],
                    'category_id' => null,
                    'operator_id' => $this->state['operador'],
                    'especie' => $this->state['especie'],
                    'method_id' => $this->state['fp'],
                    'total' => $total_formatado,
                    'user_id' => auth()->user()->id

                ]);

                $this->dispatchBrowserEvent('close-confirm-modal');
                $this->reset('state');
                $this->state['tipo'] = '3';
                $this->state['operador'] = "";
                $this->state['especie'] = "";
                $this->state['fp'] = "";

                $this->emit('alert', 'Retirada de caixa realizada com sucesso!');
                $this->emitTo('retirada', 'render');

            } else {

                $this->dispatchBrowserEvent('close-confirm-modal');
                $this->reset('state');
                $this->state['tipo'] = '3';
                $this->state['operador'] = "";
                $this->state['especie'] = "";
                $this->state['fp'] = "";

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

        $formas_de_pag = Method::where('user_id', auth()->user()->id)
        ->where('status', 1)
        ->orderBy('descricao', 'asc')
        ->get();

        if(isset($this->state['especie']) and $this->state['especie'] != 4){
            $this->state['fp'] = "";
        }

        return view('livewire.create-ret', compact('operadores', 'formas_de_pag'));
    }
}

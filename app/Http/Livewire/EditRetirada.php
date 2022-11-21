<?php

namespace App\Http\Livewire;

use App\Models\Method;
use App\Models\Operation;
use App\Models\Operator;
use Livewire\Component;

class EditRetirada extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $search_operacao;
    public $state;
    public $operadores;
    public $formas_de_pag;

    public $rules = [

        'state.descricao' => 'required|max:100',
        'state.total' => 'required|max:10',
        'state.operator_id' => 'required',
        'state.especie' => 'required',
        'state.method_id' => 'numeric',

    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição da retirada é obrigatória.',
        'state.total.required' => 'O total da retirada é obrigatório.',
        'state.operator_id.required' => 'O operador de caixa é obrigatório.',
        'state.especie.required' => 'A espécie da operação é obrigatória.',

    ];

    public function updateOperation(){

        $this->validate();

        $total_formatado = str_replace(".", "", $this->state['total']);
        $total_formatado = str_replace(',', '.', $total_formatado);

        $this->state['total'] = $total_formatado;

        //Verifica se há receita disponível para retirada
        $receita_entrada = Operation::where('user_id', $this->state['user_id'])
            ->whereIn('tipo', [1])
            ->sum('total');

        $receita_saida = Operation::where('user_id', $this->state['user_id'])
            ->whereIn('tipo', [0, 3])
            ->sum('total');

        $receita_valor = $receita_entrada - $receita_saida;

        if($total_formatado == 0){
            $this->emit('alert-error', 'O total da operação deve ser maior do que zero.');
        }else{

            if ($total_formatado <= $receita_valor) {

                if(empty($this->state['method_id'])){
                    $this->state['method_id'] = null;
                }

                $this->state->save();

                $this->dispatchBrowserEvent('close-adm-edit-retirada');
                
                $this->reset('state');
        
                $this->emit('alert', 'Retirada editada com sucesso!');

            } else {

                $this->dispatchBrowserEvent('close-adm-edit-retirada');

                $this->reset('state');

                $this->emit('alert-error', 'O usuário não possui saldo suficiente para editar esta retirada de caixa.');

            }

        }

    }

    public function resetNewOperation()
    {

        $this->dispatchBrowserEvent('close-adm-edit-retirada');
        $this->reset('state');

    }

    public function callOperationEdit(Operation $id){

        $this->dispatchBrowserEvent('open-adm-edit-retirada');
        
        $this->state = $id;

        $this->state['total'] = str_replace('.', ',', $this->state['total']);
        
        $this->operadores = Operator::where('user_id', $this->state['user_id'])
        ->where('status', 0)
        ->orderBy('nome', 'asc')
        ->get();

        $this->formas_de_pag = Method::where('user_id', $this->state['user_id'])
        ->where('status', 1)
        ->orderBy('descricao', 'asc')
        ->get();

        if(isset($this->state['especie']) and $this->state['especie'] != 4){
            $this->state['fp'] = "";
        }

    }

    public function deleteRetirada(){

        $this->state->delete();
        $this->dispatchBrowserEvent('close-adm-edit-retirada');
        $this->emit('alert', 'Retirada excluída com sucesso!');
        
    }

    public function render()
    {

        $user_operation_to_edit = Operation::where('id', $this->search_operacao)
                                ->where('tipo', '=', 3)
                                ->first();

        return view('livewire.edit-retirada', compact('user_operation_to_edit'));
    }
}

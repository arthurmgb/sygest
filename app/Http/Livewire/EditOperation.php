<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Method;
use App\Models\Operation;
use App\Models\Operator;
use Livewire\Component;

class EditOperation extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $search_operacao;
    public $state;
    public $categorias;
    public $operadores;
    public $formas_de_pag;

    public $rules = [

        'state.tipo' => 'required',
        'state.descricao' => 'required|max:100',
        'state.category_id' => 'required',
        'state.operator_id' => 'required',
        'state.total' => 'required|max:10',
        'state.especie' => 'required',
        'state.method_id' => 'numeric',

    ];

    protected $messages = [

        'state.tipo.required' => 'O tipo de operação é obrigatório.',
        'state.descricao.required' => 'A descrição da operação é obrigatória.',
        'state.category_id.required' => 'A categoria da operação é obrigatória.',
        'state.operator_id.required' => 'O operador de caixa é obrigatório.',
        'state.total.required' => 'O total da operação é obrigatório.',
        'state.especie.required' => 'A espécie da operação é obrigatória.',

    ];

    public function changeOperation()
    {
    
        $this->state['category_id'] = "";
        $this->state['operator_id'] = "";
        $this->state['especie'] = "";
        $this->state['method_id'] = "";

        $this->categorias = Category::where('user_id', $this->state['user_id'])
        ->where('status', 1)
        ->where('tipo', $this->state['tipo'])
        ->orderBy('descricao', 'asc')
        ->get();

    }

    public function updateOperation()
    {

        $this->validate();

        $total_formatado = str_replace(".", "", $this->state['total']);
        $total_formatado = str_replace(',', '.', $total_formatado);

        $this->state['total'] = $total_formatado;

        if(empty($this->state['method_id'])){
            $this->state['method_id'] = null;
        }

        if($total_formatado > 0){

            $this->state->save();

            $this->dispatchBrowserEvent('close-adm-edit-operation');
            
            $this->reset('state');
    
            $this->emit('alert', 'Operação editada com sucesso!');
            

        }else{

            $this->emit('alert-error', 'O total da operação deve ser maior do que zero.');

        }
        
    }

    public function transformIntoRet($id){

        Operation::where('id', $id)
        ->update(
            [
                'tipo' => 3,
                'category_id' => NULL
            ]
        );

        $this->dispatchBrowserEvent('close-adm-edit-operation');
        $this->reset('state');
        $this->emit('alert', 'Operação convertida em retirada com sucesso!');

    }

    public function resetNewOperation()
    {

        $this->dispatchBrowserEvent('close-adm-edit-operation');
        $this->reset('state');

    }

    public function callOperationEdit(Operation $id){

        $this->dispatchBrowserEvent('open-adm-edit-operation');
        
        $this->state = $id;

        $this->state['total'] = str_replace('.', ',', $this->state['total']);
        
        $this->categorias = Category::where('user_id', $this->state['user_id'])
        ->where('status', 1)
        ->where('tipo', $this->state['tipo'])
        ->orderBy('descricao', 'asc')
        ->get();
        
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

    public function deleteOperation(){

        $this->state->delete();
        $this->dispatchBrowserEvent('close-adm-edit-operation');
        $this->emit('alert', 'Operação excluída com sucesso!');
        
    }

    public function render()
    {

        $user_operation_to_edit = Operation::where('id', $this->search_operacao)
                                ->where('tipo', '!=', 3)
                                ->first();

        return view('livewire.edit-operation', compact('user_operation_to_edit'));
    }
}

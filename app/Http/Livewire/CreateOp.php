<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Method;
use App\Models\Operation;
use App\Models\Operator;
use Livewire\Component;

class CreateOp extends Component
{

    protected $listeners = ['refreshComponent' => '$refresh'];
    public $state = [];
    public $is_operator_default;

    public $rules = [

        'state.tipo' => 'required',
        'state.descricao' => 'required|max:100',
        'state.categoria' => 'required',
        'state.operador' => 'required',
        'state.total' => 'required|max:10',
        'state.especie' => 'required',

    ];

    protected $messages = [

        'state.tipo.required' => 'O tipo de operação é obrigatório.',
        'state.descricao.required' => 'A descrição da operação é obrigatória.',
        'state.categoria.required' => 'A categoria da operação é obrigatória.',
        'state.operador.required' => 'O operador de caixa é obrigatório.',
        'state.total.required' => 'O total da operação é obrigatório.',
        'state.especie.required' => 'A espécie da operação é obrigatória.',

    ];

    public function refreshOp(){
        $this->emit('refreshComponent');
    }

    public function changeOperation()
    {
        $this->state['categoria'] = "";
        $this->state['operador'] = "";
        $this->state['especie'] = "";
        $this->state['fp'] = "";
    }

    public function mount()
    {
        $this->state['tipo'] = '1';
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
        $this->state['tipo'] = '1';
        $this->state['categoria'] = "";
        $this->state['operador'] = "";
        $this->state['especie'] = "";
        $this->state['fp'] = "";
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '1';
        $this->state['categoria'] = "";
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

        $total_formatado = str_replace(".", "", $this->state['total']);
        $total_formatado = str_replace(',', '.', $total_formatado);

        if(empty($this->state['fp'])){
            $this->state['fp'] = null;
        }

        if($total_formatado > 0){

            Operation::create([

                'tipo' => $this->state['tipo'],
                'descricao' => $this->state['descricao'],
                'category_id' => $this->state['categoria'],
                'operator_id' => $this->state['operador'],
                'especie'=> $this->state['especie'],
                'method_id' => $this->state['fp'],
                'total' => $total_formatado,
                'user_id' => auth()->user()->id
    
            ]);
    
            $this->dispatchBrowserEvent('close-confirm-modal');
            $this->reset('state');
            $this->state['tipo'] = '1';
            $this->state['categoria'] = "";
            $this->state['operador'] = "";
            $this->state['especie'] = "";
            $this->state['fp'] = "";
    
            $this->emit('alert', 'Operação realizada com sucesso!');
            $this->emitTo('fluxo-caixa', 'render');
            $this->emitTo('visao-geral', 'render');

        }else{
            $this->emit('alert-error', 'O total da operação deve ser maior do que zero.');
        }

        
    }

    public function render()
    {

        $categorias = Category::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->where('tipo', $this->state['tipo'])
            ->orderBy('descricao', 'asc')
            ->get();
        
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

        return view('livewire.create-op', compact('categorias', 'operadores', 'formas_de_pag'));
    }
}

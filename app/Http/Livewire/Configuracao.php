<?php

namespace App\Http\Livewire;

use App\Models\Operator;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Configuracao extends Component
{

    use WithPagination;
    public $operador;
    protected $paginationTheme = 'bootstrap';
    public $qtd = 10;
    protected $listeners = ['render'];
    public $modal_start;
    public $table_scroll;

    public $rules = [

        'operador.nome' => 'required|max:100',

    ];

    protected $messages = [

        'operador.nome.required' => 'O nome do operador é obrigatório.',

    ];

    public function mount(){
        $this->modal_start = auth()->user()->modal_start;
        $this->table_scroll = auth()->user()->table_scroll;
    }

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
        if($operador->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->operador = $operador;
    }

    public function update()
    {

        $this->operador->save();
        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
        $this->emit('alert', 'Operador editado com sucesso!');
    }

    public function notifications($id){

        $find_user = User::find(auth()->user()->id);
        $find_user->modal_start = $id;
        $find_user->save();

        $this->modal_start = $find_user->modal_start;

    }

    public function toggleDefault($id){

        $default_operator = Operator::find($id);

        if($default_operator->user_id != auth()->user()->id){
            return redirect('404');
        }

        $defined_default = Operator::where('user_id', auth()->user()->id)
            ->where('is_default', 1)
            ->get();

        if($default_operator->is_default == 0){

            if($defined_default->isEmpty()){

                $default_operator->is_default = 1;
                $default_operator->save();

            }else{

                Operator::where('user_id', auth()->user()->id)
                ->where('is_default', 1)
                ->update(['is_default' => 0]);
                
                $default_operator->is_default = 1;
                $default_operator->save();
            }

            $this->emit('alert', 'Operador padrão alterado com sucesso!');

        }elseif($default_operator->is_default == 1){

            $default_operator->is_default = 0;
            $default_operator->save();

            $this->emit('alert', 'Operador padrão removido com sucesso!');

        }

    }

    public function toggleStatus($id){

        $operator_to_modify = Operator::find($id);

        if($operator_to_modify->user_id != auth()->user()->id){
            return redirect('404');
        }

        if($operator_to_modify->status == 0){

            $operator_to_modify->status = 1;
           
            if($operator_to_modify->is_default == 1){

                $operator_to_modify->is_default = 0;

                $operator_to_modify->save();

                $this->emit('alert', 'Operador desativado e removido como padrão com sucesso! Este operador não poderá mais ser utilizado para criar novas operações até ser reativado novamente.');

            }else{

                $operator_to_modify->save();

                $this->emit('alert', 'Operador desativado com sucesso! Este operador não poderá mais ser utilizado para criar novas operações até ser reativado novamente.');
            }

          

        }elseif($operator_to_modify->status == 1){

            $operator_to_modify->status = 0;
            $operator_to_modify->save();

            $this->emit('alert', 'Operador reativado com sucesso!');

        }

        

    }

    public function toggleTableScroll(){

        $get_table_scroll = User::find(auth()->user()->id);
        
        if($get_table_scroll->table_scroll == 0){

            $get_table_scroll->table_scroll = 1;

        }elseif($get_table_scroll->table_scroll == 1){

            $get_table_scroll->table_scroll = 0;

        }

        $get_table_scroll->save();
        $this->table_scroll = $get_table_scroll->table_scroll;

    }
    
    public function render()
    {

        $operators = Operator::where('user_id', auth()->user()->id)
            ->latest('id')
            ->paginate($this->qtd);

        $operators_count = $operators->count();

        $default_operator_name = Operator::where('user_id', auth()->user()->id)
        ->where('is_default', 1)
        ->first();

        return view('livewire.configuracao', compact('operators', 'operators_count', 'default_operator_name'))
        ->layout('pages.configuracoes');
    }
}

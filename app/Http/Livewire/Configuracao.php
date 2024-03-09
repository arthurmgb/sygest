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
    public $sort_operator_status;
    public $selectedRoutes = [];

    public $rules = [

        'operador.nome' => 'required|max:100',
        'operador.senha' => 'required|max:100',

    ];

    protected $messages = [

        'operador.nome.required' => 'O nome do operador é obrigatório.',
        'operador.senha.required' => 'A senha do operador é obrigatória.',

    ];

    public function mount()
    {
        $this->modal_start = auth()->user()->modal_start;
        $this->table_scroll = auth()->user()->table_scroll;
        $this->sort_operator_status = 0;
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
        if ($operador->user_id != auth()->user()->id) {
            return redirect('404');
        }

        $this->operador = $operador;

        $this->selectedRoutes = json_decode($this->operador->permitted_routes) ?? [];
    }

    public function update()
    {
        $this->selectedRoutes = json_encode($this->selectedRoutes);
        $this->operador->permitted_routes = $this->selectedRoutes;

        $this->operador->save();
        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
        $this->emit('alert', 'Operador editado com sucesso!');
    }

    public function notifications($id)
    {

        $find_user = User::find(auth()->user()->id);
        $find_user->modal_start = $id;
        $find_user->save();

        $this->modal_start = $find_user->modal_start;
    }

    public function toggleStatus($id)
    {

        $operator_to_modify = Operator::find($id);

        if ($operator_to_modify->user_id != auth()->user()->id) {
            return redirect('404');
        }

        if ($operator_to_modify->status == 0) {

            $operator_to_modify->status = 1;

            $operator_to_modify->save();

            $this->emit('alert', 'Operador desativado com sucesso! Este operador não poderá mais ser utilizado para criar novas operações até ser reativado novamente.');
        } elseif ($operator_to_modify->status == 1) {

            $operator_to_modify->status = 0;
            $operator_to_modify->save();

            $this->emit('alert', 'Operador reativado com sucesso!');
        }
    }

    public function toggleTableScroll()
    {

        $get_table_scroll = User::find(auth()->user()->id);

        if ($get_table_scroll->table_scroll == 0) {

            $get_table_scroll->table_scroll = 1;
        } elseif ($get_table_scroll->table_scroll == 1) {

            $get_table_scroll->table_scroll = 0;
        }

        $get_table_scroll->save();
        $this->table_scroll = $get_table_scroll->table_scroll;
    }

    public function toggleOperatorTableStatus()
    {

        if ($this->sort_operator_status == 0) {
            $this->sort_operator_status = 1;
        } elseif ($this->sort_operator_status == 1) {
            $this->sort_operator_status = 0;
        }
    }

    public function render()
    {

        $operators = Operator::where('user_id', auth()->user()->id)
            ->where('status', $this->sort_operator_status)
            ->orderBy('nome')
            ->paginate($this->qtd);

        $operators_count = Operator::where('user_id', auth()->user()->id)
            ->count();

        $operators_active_count = Operator::where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->count();

        $operators_inactive_count = Operator::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->count();

        return view('livewire.configuracao', compact('operators', 'operators_count', 'operators_active_count', 'operators_inactive_count'))
            ->layout('pages.configuracoes');
    }
}

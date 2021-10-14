<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Livewire\Component;
use Livewire\WithPagination;

class FluxoCaixa extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $option;

    public $receita = null;

    public $qtd = 10;

    protected $listeners = ['render'];

    public function changeOption($id)
    {
        $this->option = $id;
    }

    public function mount()
    {
        $this->option = [1, 0];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function geraReceita()
    {
        if ($this->receita == null) {
            $this->receita = true;
        } else {
            $this->receita = null;
        }
    }

    public function render()
    {

        $operations = Operation::where('user_id', auth()->user()->id)
            ->where('descricao', 'like', '%' . $this->search . '%')
            ->whereIn('tipo', $this->option)
            ->latest('id')
            ->paginate($this->qtd);

        $operations_count = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', '!=', 3)
            ->count();
        
        $operations_find = Operation::where('user_id', auth()->user()->id)
        ->whereIn('tipo', $this->option)
        ->count();

        if ($this->receita == true) {

            if($this->option == [1,0]){

                $receita_entrada = Operation::where('user_id', auth()->user()->id)
                    ->whereIn('tipo', [1])
                    ->sum('total');

                $receita_saida = Operation::where('user_id', auth()->user()->id)
                    ->whereIn('tipo', [0])
                    ->sum('total');

                $receita_valor = $receita_entrada - $receita_saida;

            }elseif($this->option == [1]){

                $receita_entrada = Operation::where('user_id', auth()->user()->id)
                ->whereIn('tipo', [1])
                ->sum('total');

                $receita_valor = $receita_entrada;

            }elseif($this->option == [0]){

                $receita_saida = Operation::where('user_id', auth()->user()->id)
                ->whereIn('tipo', [0])
                ->sum('total');

                $receita_valor = $receita_saida;

            }

            $receita_valor = number_format($receita_valor,2,",",".");

            return view('livewire.fluxo-caixa', compact('operations', 'operations_count', 'receita_valor', 'operations_find'))
                ->layout('pages.fluxo-caixa');
        } else {
            return view('livewire.fluxo-caixa', compact('operations', 'operations_count'))
                ->layout('pages.fluxo-caixa');
        }
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class VisaoGeral extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $rendimento;

    public $qtd = 10;

    protected $listeners = ['render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function removeRendimento(){
        $this->reset('rendimento');
    }

    public function fechaRendimento(){
        $this->dispatchBrowserEvent('close-rendimento');
    }

    public function render()
    {

        $data_hoje = Carbon::today()->format('Y-m-d');
        $data_mes = Carbon::now()->format('Y-m');

//======================================================================

        //Operações realizadas hoje

        $operations = Operation::where('user_id', auth()->user()->id)
            ->where('descricao', 'like', '%' . $this->search . '%')
            ->where('created_at', 'like', $data_hoje . '%')
            ->latest('id')
            ->paginate($this->qtd);

        //Fim operações realizadas hoje

//======================================================================

        //Receita hoje

        //Recebendo valores
        $entradas_hoje = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_hoje . '%')
            ->where('tipo', 1)
            ->sum('total');

        $saidas_hoje = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_hoje . '%')
            ->where('tipo', 0)
            ->sum('total');

        $total_hoje = $entradas_hoje - $saidas_hoje;
        //Fim recebendo valores

        //Formatação
        $entradas_hoje = number_format($entradas_hoje, 2, ",", ".");
        $saidas_hoje = number_format($saidas_hoje, 2, ",", ".");
        $total_hoje = number_format($total_hoje, 2, ",", ".");
        //Fim formatação

        //Contagem de operações
        $op_hoje = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_hoje . '%')
            ->whereIn('tipo', [1, 0])
            ->count();
        //Fim contagem de operações

        //Fim receita hoje

//======================================================================
       
        //Receita mês

        //Recebendo valores
        $entradas_mes = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_mes . '%')
            ->where('tipo', 1)
            ->sum('total');

        $saidas_mes = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_mes . '%')
            ->where('tipo', 0)
            ->sum('total');

        $total_mes = $entradas_mes - $saidas_mes;
        //Fim recebendo valores

        //Formatação
        $entradas_mes = number_format($entradas_mes, 2, ",", ".");
        $saidas_mes = number_format($saidas_mes, 2, ",", ".");
        $total_mes = number_format($total_mes, 2, ",", ".");
        //Fim formatação

        //Contagem de operações
        $op_mes = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_mes . '%')
            ->whereIn('tipo', [1, 0])
            ->count();
        //Fim contagem de operações

        //Fim receita mês

//======================================================================

        //Receita total

        //Recebendo valores
        $entradas_total = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 1)
            ->sum('total');

        $saidas_total = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [0,3])
            ->sum('total');

        $total_total = $entradas_total - $saidas_total;
        //Fim recebendo valores

        //Rendimento

        $rendimento = $this->rendimento;
        $rendimento = floatval($rendimento);
        
        if($rendimento){
            $valor_real = $total_total + $rendimento;
        }else{
            $valor_real = $total_total;
        }

        //Fim rendimento

        //Formatação
        $entradas_total = number_format($entradas_total, 2, ",", ".");
        $saidas_total = number_format($saidas_total, 2, ",", ".");
        $total_total = number_format($total_total, 2, ",", ".");
        $valor_real = number_format($valor_real, 2, ",", ".");

        if(is_numeric($rendimento)){

            $rendimento = number_format($rendimento, 2, ",", ".");

            //dd($rendimento);
        }
        //Fim formatação

        //Contagem de operações
        $op_total = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [1, 0, 3])
            ->count();
        //Fim contagem de operações

        //Fim receita total

        return view(
            'livewire.visao-geral',
            compact(
                'operations',
                'entradas_hoje',
                'saidas_hoje',
                'total_hoje',
                'op_hoje',
                'entradas_mes',
                'saidas_mes',
                'total_mes',
                'op_mes',
                'entradas_total',
                'saidas_total',
                'op_total',
                'total_total',
                'valor_real',
                'rendimento',
            )
        )
            ->layout('pages.visao-geral');;
    }
}

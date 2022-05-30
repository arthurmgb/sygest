<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use App\Models\User;
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

    public $rc;

    public $totais;

    protected $listeners = ['render'];

    public function mount(){
        $this->rc = 0;
        $this->totais = auth()->user()->view_totais;
    }

    public function ocultarTotais(){

        $user = User::find(auth()->user()->id);

        $view_tt = $user->view_totais;

        if($view_tt == 0){

            $user->view_totais = 1;

        }elseif($view_tt == 1){

            $user->view_totais = 0;

        }

        $user->save();
        $this->totais = $user->view_totais;

    }

    public function ocultarBox($num){
        
        $user = User::find(auth()->user()->id);

        if($num === 1){

            $user->rc_hoje = 1;     

        }elseif($num === 2){

            $user->rc_mes = 1;

        }elseif($num === 3){

            $user->rc_total = 1;

        }
        
        $user->save();
        $this->rc = 0;

    }

    public function mostrarBoxes(){

        $user = User::find(auth()->user()->id);

        $user->rc_hoje = 0; 
        $user->rc_mes = 0; 
        $user->rc_total = 0; 

        $user->save();
        $this->rc = 0;
        
    }

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

        $retiradas_hoje = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_hoje . '%')
            ->where('tipo', 3)
            ->sum('total');
        
        $total_saidas_retiradas_hoje = $saidas_hoje + $retiradas_hoje;

        $total_hoje = $entradas_hoje - $total_saidas_retiradas_hoje;

        //Fim recebendo valores

        //Coins hoje

        $coin_dinheiro_entrada_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 1)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_dinheiro_saida_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 1)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_dinheiro_hj = $coin_dinheiro_entrada_hj - $coin_dinheiro_saida_hj;

        $coin_cheque_entrada_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 2)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_cheque_saida_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 2)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_cheque_hj = $coin_cheque_entrada_hj - $coin_cheque_saida_hj;

        $coin_moeda_entrada_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 3)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_moeda_saida_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 3)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_moeda_hj = $coin_moeda_entrada_hj - $coin_moeda_saida_hj;

        $coin_outros_entrada_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 4)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_outros_saida_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 4)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        $coin_outros_hj = $coin_outros_entrada_hj - $coin_outros_saida_hj;

        $coin_retiradas_hj = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 3)
        ->where('created_at', 'like', $data_hoje . '%')
        ->sum('total');

        //Fim coins hoje

        //Formatação
        $entradas_hoje = number_format($entradas_hoje, 2, ",", ".");
        $saidas_hoje = number_format($saidas_hoje, 2, ",", ".");
        $retiradas_hoje = number_format($retiradas_hoje, 2, ",", ".");
        $total_hoje = number_format($total_hoje, 2, ",", ".");
        $coin_dinheiro_hj = number_format($coin_dinheiro_hj, 2, ",", ".");
        $coin_dinheiro_entrada_hj = number_format($coin_dinheiro_entrada_hj, 2, ",", ".");
        $coin_dinheiro_saida_hj = number_format($coin_dinheiro_saida_hj, 2, ",", ".");
        $coin_cheque_hj = number_format($coin_cheque_hj, 2, ",", ".");
        $coin_cheque_entrada_hj = number_format($coin_cheque_entrada_hj, 2, ",", ".");
        $coin_cheque_saida_hj = number_format($coin_cheque_saida_hj, 2, ",", ".");
        $coin_moeda_hj = number_format($coin_moeda_hj, 2, ",", ".");
        $coin_moeda_entrada_hj = number_format($coin_moeda_entrada_hj, 2, ",", ".");
        $coin_moeda_saida_hj = number_format($coin_moeda_saida_hj, 2, ",", ".");
        $coin_outros_hj = number_format($coin_outros_hj, 2, ",", ".");
        $coin_outros_entrada_hj = number_format($coin_outros_entrada_hj, 2, ",", ".");
        $coin_outros_saida_hj = number_format($coin_outros_saida_hj, 2, ",", ".");
        $coin_retiradas_hj = number_format($coin_retiradas_hj, 2, ",", ".");
        //Fim formatação

        //Contagem de operações
        $op_hoje = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_hoje . '%')
            ->whereIn('tipo', [1, 0, 3])
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

        $retiradas_mes = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_mes . '%')
            ->where('tipo', 3)
            ->sum('total');

        $total_saidas_retiradas_mes = $saidas_mes + $retiradas_mes;

        $total_mes = $entradas_mes - $total_saidas_retiradas_mes;
        //Fim recebendo valores

        //Coins mes

        $coin_dinheiro_entrada_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 1)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_dinheiro_saida_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 1)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_dinheiro_mes = $coin_dinheiro_entrada_mes - $coin_dinheiro_saida_mes;

        $coin_cheque_entrada_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 2)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_cheque_saida_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 2)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_cheque_mes = $coin_cheque_entrada_mes - $coin_cheque_saida_mes;

        $coin_moeda_entrada_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 3)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_moeda_saida_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 3)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_moeda_mes = $coin_moeda_entrada_mes - $coin_moeda_saida_mes;

        $coin_outros_entrada_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 4)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_outros_saida_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 4)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        $coin_outros_mes = $coin_outros_entrada_mes - $coin_outros_saida_mes;

        $coin_retiradas_mes = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 3)
        ->where('created_at', 'like', $data_mes . '%')
        ->sum('total');

        //Fim coins mes

        //Formatação
        $entradas_mes = number_format($entradas_mes, 2, ",", ".");
        $saidas_mes = number_format($saidas_mes, 2, ",", ".");
        $retiradas_mes = number_format($retiradas_mes, 2, ",", ".");
        $total_mes = number_format($total_mes, 2, ",", ".");
        $coin_dinheiro_mes = number_format($coin_dinheiro_mes, 2, ",", ".");
        $coin_dinheiro_entrada_mes = number_format($coin_dinheiro_entrada_mes, 2, ",", ".");
        $coin_dinheiro_saida_mes = number_format($coin_dinheiro_saida_mes, 2, ",", ".");
        $coin_cheque_mes = number_format($coin_cheque_mes, 2, ",", ".");
        $coin_cheque_entrada_mes = number_format($coin_cheque_entrada_mes, 2, ",", ".");
        $coin_cheque_saida_mes = number_format($coin_cheque_saida_mes, 2, ",", ".");
        $coin_moeda_mes = number_format($coin_moeda_mes, 2, ",", ".");
        $coin_moeda_entrada_mes = number_format($coin_moeda_entrada_mes, 2, ",", ".");
        $coin_moeda_saida_mes = number_format($coin_moeda_saida_mes, 2, ",", ".");
        $coin_outros_mes = number_format($coin_outros_mes, 2, ",", ".");
        $coin_outros_entrada_mes = number_format($coin_outros_entrada_mes, 2, ",", ".");
        $coin_outros_saida_mes = number_format($coin_outros_saida_mes, 2, ",", ".");
        $coin_retiradas_mes = number_format($coin_retiradas_mes, 2, ",", ".");
        //Fim formatação

        //Contagem de operações
        $op_mes = Operation::where('user_id', auth()->user()->id)
            ->where('created_at', 'like', $data_mes . '%')
            ->whereIn('tipo', [1, 0, 3])
            ->count();
        //Fim contagem de operações

        //Fim receita mês

        //======================================================================

        //Receita total

        //Recebendo valores
        $entradas_total = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 1)
            ->sum('total');

        $saidas_ret_total = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [0,3])
            ->sum('total');
        
        $saidas_total = Operation::where('user_id', auth()->user()->id)
        ->whereIn('tipo', [0])
        ->sum('total');

        $retiradas_total = Operation::where('user_id', auth()->user()->id)
        ->whereIn('tipo', [3])
        ->sum('total');

        $total_total = $entradas_total - $saidas_ret_total;
        //Fim recebendo valores

        //Coins

        $coin_dinheiro_entrada = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 1)
        ->sum('total');

        $coin_dinheiro_saida = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 1)
        ->sum('total');

        $coin_dinheiro = $coin_dinheiro_entrada - $coin_dinheiro_saida;

        $coin_cheque_entrada = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 2)
        ->sum('total');

        $coin_cheque_saida = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 2)
        ->sum('total');

        $coin_cheque = $coin_cheque_entrada - $coin_cheque_saida;

        $coin_moeda_entrada = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 3)
        ->sum('total');

        $coin_moeda_saida = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 3)
        ->sum('total');

        $coin_moeda = $coin_moeda_entrada - $coin_moeda_saida;

        $coin_outros_entrada = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 4)
        ->sum('total');

        $coin_outros_saida = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 0)
        ->where('especie', 4)
        ->sum('total');

        $coin_outros = $coin_outros_entrada - $coin_outros_saida;

        $coin_retiradas = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 3)
        ->sum('total');

        //Fim coins

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
        $retiradas_total = number_format($retiradas_total, 2, ",", ".");
        $valor_real = number_format($valor_real, 2, ",", ".");
        $coin_dinheiro = number_format($coin_dinheiro, 2, ",", ".");
        $coin_cheque = number_format($coin_cheque, 2, ",", ".");
        $coin_moeda = number_format($coin_moeda, 2, ",", ".");
        $coin_outros = number_format($coin_outros, 2, ",", ".");
        $coin_retiradas = number_format($coin_retiradas, 2, ",", ".");

        if(is_numeric($rendimento)){

            $rendimento = number_format($rendimento, 2, ",", ".");

        }
        //Fim formatação

        //Contagem de operações
        $op_total = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [1, 0, 3])
            ->count();
        //Fim contagem de operações

        //Fim receita total

        $user_rc = User::find(auth()->user()->id);
        $rc_hoje = $user_rc->rc_hoje;
        $rc_mes = $user_rc->rc_mes;
        $rc_total =  $user_rc->rc_total;
        $rc_soma = $rc_hoje + $rc_mes + $rc_total;

        return view(
            'livewire.visao-geral',
            compact(
                'operations',
                'entradas_hoje',
                'saidas_hoje',
                'retiradas_hoje',
                'total_hoje',
                'op_hoje',
                'entradas_mes',
                'saidas_mes',
                'retiradas_mes',
                'total_mes',
                'op_mes',
                'entradas_total',
                'saidas_ret_total',
                'saidas_total',
                'retiradas_total',
                'op_total',
                'total_total',
                'valor_real',
                'rendimento',
                'coin_dinheiro',
                'coin_cheque',
                'coin_moeda',
                'coin_outros',
                'coin_retiradas',
                'coin_dinheiro_hj',
                'coin_dinheiro_entrada_hj',
                'coin_dinheiro_saida_hj',
                'coin_cheque_hj',
                'coin_cheque_entrada_hj',
                'coin_cheque_saida_hj',
                'coin_moeda_hj',
                'coin_moeda_entrada_hj',
                'coin_moeda_saida_hj',
                'coin_outros_hj',
                'coin_outros_entrada_hj', 
                'coin_outros_saida_hj',
                'coin_retiradas_hj', 
                'coin_dinheiro_mes',
                'coin_dinheiro_entrada_mes',
                'coin_dinheiro_saida_mes',
                'coin_cheque_mes',
                'coin_cheque_entrada_mes',
                'coin_cheque_saida_mes',
                'coin_moeda_mes',
                'coin_moeda_entrada_mes',
                'coin_moeda_saida_mes',
                'coin_outros_mes',
                'coin_outros_entrada_mes', 
                'coin_outros_saida_mes',
                'coin_retiradas_mes', 
                'rc_hoje',
                'rc_mes',
                'rc_total',
                'rc_soma',

            )
        )
            ->layout('pages.visao-geral');;
    }
}

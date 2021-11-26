<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Relatorio extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $qtd = 10;

    public function resetRelatorio()
    {
        $this->reset('data');
    }

    public function render()
    {

        if (!empty($this->data['inicial'])) {

            $di = $this->data['inicial'] . ' 00:00:00';

            if (empty($this->data['final'])) {

                $this->data['final'] = Carbon::today()->format('Y-m-d');

                $df = $this->data['final'] . ' 23:59:00';
            } else {

                $df = $this->data['final'] . ' 23:59:00';
            }

            $operations = Operation::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [$di, $df])
                ->latest('id')
                ->paginate($this->qtd);

            $entradas_total = Operation::where('user_id', auth()->user()->id)
                ->where('tipo', 1)
                ->sum('total');
    
            $saidas_ret_total = Operation::where('user_id', auth()->user()->id)
                ->whereIn('tipo', [0,3])
                ->sum('total');

            $caixa_total = $entradas_total - $saidas_ret_total;

            $receita_entrada = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [1])
            ->sum('total');

            $receita_saida = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [0,3])
            ->sum('total');

            $rec_only_saida = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [0])
            ->sum('total');

            $rec_total = $receita_entrada - $rec_only_saida; 
            $receita_valor = $receita_entrada - $receita_saida;

            $receita_ret = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [3])
            ->sum('total');

            $rec_total = number_format($rec_total,2,",",".");
            $receita_valor = number_format($receita_valor,2,",",".");
            $receita_entrada = number_format($receita_entrada,2,",",".");
            $receita_saida = number_format($receita_saida,2,",",".");
            $rec_only_saida = number_format($rec_only_saida,2,",",".");
            $receita_ret = number_format($receita_ret,2,",",".");
            $caixa_total = number_format($caixa_total,2,",",".");

            $operations_count = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->count();

        //Coins relatório

        $coin_dinheiro_entrada_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 1)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_dinheiro_saida_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', [0,3])
        ->where('especie', 1)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_dinheiro_rel = $coin_dinheiro_entrada_rel - $coin_dinheiro_saida_rel;

        $coin_cheque_entrada_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 2)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_cheque_saida_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', [0,3])
        ->where('especie', 2)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_cheque_rel = $coin_cheque_entrada_rel - $coin_cheque_saida_rel;

        $coin_moeda_entrada_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 3)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_moeda_saida_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', [0,3])
        ->where('especie', 3)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_moeda_rel = $coin_moeda_entrada_rel - $coin_moeda_saida_rel;

        $coin_outros_entrada_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', 1)
        ->where('especie', 4)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_outros_saida_rel = Operation::where('user_id', auth()->user()->id)
        ->where('tipo', [0,3])
        ->where('especie', 4)
        ->whereBetween('created_at', [$di, $df])
        ->sum('total');

        $coin_outros_rel = $coin_outros_entrada_rel - $coin_outros_saida_rel;

        //Fim coins relatório

            //Formatação
            $coin_dinheiro_rel = number_format($coin_dinheiro_rel, 2, ",", ".");
            $coin_dinheiro_entrada_rel = number_format($coin_dinheiro_entrada_rel, 2, ",", ".");
            $coin_dinheiro_saida_rel = number_format($coin_dinheiro_saida_rel, 2, ",", ".");
            $coin_cheque_rel = number_format($coin_cheque_rel, 2, ",", ".");
            $coin_cheque_entrada_rel = number_format($coin_cheque_entrada_rel, 2, ",", ".");
            $coin_cheque_saida_rel = number_format($coin_cheque_saida_rel, 2, ",", ".");
            $coin_moeda_rel = number_format($coin_moeda_rel, 2, ",", ".");
            $coin_moeda_entrada_rel = number_format($coin_moeda_entrada_rel, 2, ",", ".");
            $coin_moeda_saida_rel = number_format($coin_moeda_saida_rel, 2, ",", ".");
            $coin_outros_rel = number_format($coin_outros_rel, 2, ",", ".");
            $coin_outros_entrada_rel = number_format($coin_outros_entrada_rel, 2, ",", ".");
            $coin_outros_saida_rel = number_format($coin_outros_saida_rel, 2, ",", ".");
            //Fim formatação

            return view('livewire.relatorio', 
            compact(
                'operations',
                'caixa_total', 
                'rec_total',
                'receita_entrada',
                'receita_saida',
                'rec_only_saida',
                'receita_ret',
                'receita_valor', 
                'operations_count',
                'coin_dinheiro_rel',
                'coin_dinheiro_entrada_rel',
                'coin_dinheiro_saida_rel',
                'coin_cheque_rel',
                'coin_cheque_entrada_rel',
                'coin_cheque_saida_rel',
                'coin_moeda_rel',
                'coin_moeda_entrada_rel',
                'coin_moeda_saida_rel',
                'coin_outros_rel',
                'coin_outros_entrada_rel', 
                'coin_outros_saida_rel',
                )
            )
                ->layout('pages.relatorios');
        } else {

            return view('livewire.relatorio')
                ->layout('pages.relatorios');
        }
    }
}

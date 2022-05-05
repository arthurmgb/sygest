<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use App\Models\Category;
use App\Models\Method;
use App\Models\Operator;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Relatorio extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $data = [];
    public $categoria;
    public $operador;
    public $operador_filter;
    public $forma_pag;
    public $relDinheiro, $relCheques, $relMoedas, $relGaveta;
    public $qtd = 10;
    public $nome_categoria;
    public $nome_operador;
    public $nome_fp;
    public $especie;

    public function mount(){
        $this->operador = 'select-op';
    }

    public function printPage(){

        $operadores = Operator::where('user_id', auth()->user()->id)
            ->get();

        if(isset($this->operador) and $this->operador != 'select-op' and $operadores->count()){
            $this->qtd = 250;
            $this->dispatchBrowserEvent('call-print');
        }else{
            $this->emit('error-operator', 'É necessário selecionar um operador de caixa autorizado para realizar a impressão de um relatório. "Quem está imprimindo?"');
            $this->operador = 'select-op';
        }
        
    }

    public function resetRelatorio()
    {
        $this->reset('data', 'categoria', 'operador_filter', 'forma_pag', 'relDinheiro', 'relCheques', 'relMoedas', 'relGaveta');
        $this->qtd = 10;
        $this->operador = 'select-op';
    }

    public function caixaHoje(){

        $this->data['inicial'] = Carbon::today()->format('Y-m-d');
        $this->data['final'] = Carbon::today()->format('Y-m-d');

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

            $categories = Category::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'asc')
            ->get();

            $operators = Operator::where('user_id', auth()->user()->id)
            ->get();

            $operators_filter = Operator::where('user_id', auth()->user()->id)
            ->get();

            $methods = Method::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'asc')
            ->get();

            //FIND NOMES CATEGORIAS, OPERADORES, FPS
                if(!is_null($this->categoria) and !empty($this->categoria)){
                    $this->nome_categoria = Category::find($this->categoria);
                    $this->nome_categoria = $this->nome_categoria->descricao;
                }
                if(!is_null($this->operador_filter) and !empty($this->operador_filter)){
                    $this->nome_operador = Operator::find($this->operador_filter);
                    $this->nome_operador = $this->nome_operador->nome;
                }
                if(!is_null($this->forma_pag) and !empty($this->forma_pag)){
                    $this->nome_fp = Method::find($this->forma_pag);
                    $this->nome_fp = $this->nome_fp->descricao;
                }
            //FIM FIND

            //CHANGE ESPECIE

                if(empty($this->forma_pag)){
                    $this->especie = [1, 2, 3, 4];
                }else{
                    $this->especie = [4];
                }

            //FIM CHANGE

            if(!empty($this->forma_pag)){
                $get_fp = $this->forma_pag;
            }else{
                $get_fp = false;
            }

            $operations = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
                })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->latest('id')
            ->paginate($this->qtd);

            //CAIXA TOTAL

            $entradas_total = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 1)
            ->sum('total');

            $saidas_ret_total = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [0,3])
            ->sum('total');

            $caixa_total = $entradas_total - $saidas_ret_total;

            //FIM CAIXA TOTAL

            //FECHAMENTO DO DIA

                if($this->data['inicial'] == $this->data['final']){

                    $fechado_entradas_total = Operation::where('user_id', auth()->user()->id)
                    ->where('created_at', '<=', $df)
                    ->where('tipo', 1)
                    ->sum('total');

                    $fechado_saidas_ret_total = Operation::where('user_id', auth()->user()->id)
                    ->where('created_at', '<=', $df)
                    ->whereIn('tipo', [0,3])
                    ->sum('total');

                    $caixa_fechado_no_dia = $fechado_entradas_total - $fechado_saidas_ret_total;

                    $caixa_fechado_no_dia = number_format($caixa_fechado_no_dia,2,",",".");

                }else{

                    $fechado_entradas_total = Operation::where('user_id', auth()->user()->id)
                    ->whereBetween('created_at', [$di, $df])
                    ->where('tipo', 1)
                    ->sum('total');

                    $anteriores_fechado_entradas_total = Operation::where('user_id', auth()->user()->id)
                    ->where('created_at', '<', $di)
                    ->where('tipo', 1)
                    ->sum('total');

                    $fechado_saidas_ret_total = Operation::where('user_id', auth()->user()->id)
                    ->whereBetween('created_at', [$di, $df])
                    ->whereIn('tipo', [0,3])
                    ->sum('total');

                    $anteriores_fechado_saidas_ret_total = Operation::where('user_id', auth()->user()->id)
                    ->where('created_at', '<', $di)
                    ->whereIn('tipo', [0,3])
                    ->sum('total');

                    $fechado_entradas_total = $fechado_entradas_total + $anteriores_fechado_entradas_total;
                    $fechado_saidas_ret_total = $fechado_saidas_ret_total + $anteriores_fechado_saidas_ret_total;

                    $caixa_fechado_no_dia = $fechado_entradas_total - $fechado_saidas_ret_total;

                    $caixa_fechado_no_dia = number_format($caixa_fechado_no_dia,2,",",".");

                }

            //FIM FECHAMENTO DO DIA

            $receita_entrada = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [1])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $receita_saida = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [0,3])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $rec_only_saida = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [0])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $rec_total = $receita_entrada - $rec_only_saida; 
            $receita_valor = $receita_entrada - $receita_saida;

            $receita_ret = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [3])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $operations_count = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->count();

            //Coins relatório

            $coin_dinheiro_entrada_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 1)
            ->where('especie', 1)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_dinheiro_saida_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 0)
            ->where('especie', 1)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_dinheiro_rel = $coin_dinheiro_entrada_rel - $coin_dinheiro_saida_rel;

            $coin_cheque_entrada_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 1)
            ->where('especie', 2)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_cheque_saida_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 0)
            ->where('especie', 2)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_cheque_rel = $coin_cheque_entrada_rel - $coin_cheque_saida_rel;

            $coin_moeda_entrada_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 1)
            ->where('especie', 3)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_moeda_saida_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 0)
            ->where('especie', 3)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_moeda_rel = $coin_moeda_entrada_rel - $coin_moeda_saida_rel;

            $coin_outros_entrada_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 1)
            ->where('especie', 4)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_outros_saida_rel = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', 0)
            ->where('especie', 4)
            ->whereBetween('created_at', [$di, $df])
            ->where(function ($query) {
                $query->where('category_id', 'like', '%' . $this->categoria . '%')
                ->orWhereNull('category_id');
                })
            ->where(function ($query) {
                $query->where('operator_id', 'like', '%' . $this->operador_filter . '%')
                ->orWhereNull('operator_id');
            })
            ->when($get_fp, function ($query, $get_fp) {
                $query->where('method_id', 'like', '%' . $get_fp . '%');
            })
            ->whereIn('especie', $this->especie)
            ->sum('total');

            $coin_outros_rel = $coin_outros_entrada_rel - $coin_outros_saida_rel;

            //Fim coins relatório
        
            $rec_total = number_format($rec_total,2,",",".");
            $receita_valor = number_format($receita_valor,2,",",".");
            $receita_entrada = number_format($receita_entrada,2,",",".");
            $receita_saida = number_format($receita_saida,2,",",".");
            $rec_only_saida = number_format($rec_only_saida,2,",",".");
            $receita_ret = number_format($receita_ret,2,",",".");
            $caixa_total = number_format($caixa_total,2,",",".");            

            //Formatação coins
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
            //Fim formatação coins

            //Conferência de caixa

            $relDinheiro = str_replace(',', '.', $this->relDinheiro);
            $relCheques = str_replace(',', '.', $this->relCheques);
            $relMoedas = str_replace(',', '.', $this->relMoedas);
            $relGaveta = str_replace(',', '.', $this->relGaveta);

            $relDinheiro = floatval($relDinheiro);
            $relCheques = floatval($relCheques);
            $relMoedas = floatval($relMoedas);
            $relGaveta = floatval($relGaveta);

            $relResultado = $relDinheiro + $relCheques + $relMoedas + $relGaveta;
            $relResultado = number_format($relResultado,2,",",".");

            //Fim Conferência de caixa

            return view('livewire.relatorio', 
            compact(
                'categories',
                'operators',
                'operators_filter',
                'methods',
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
                'relResultado',
                'caixa_fechado_no_dia',
                )
            )
                ->layout('pages.relatorios');
        } else {

            $categories = Category::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'asc')
            ->get();

            $operators_filter = Operator::where('user_id', auth()->user()->id)
            ->get();

            $methods = Method::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'asc')
            ->get();

            return view('livewire.relatorio', compact('categories', 'operators_filter', 'methods'))
                ->layout('pages.relatorios');
        }
    }
}

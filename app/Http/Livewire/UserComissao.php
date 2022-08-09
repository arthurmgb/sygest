<?php

namespace App\Http\Livewire;

use App\Models\Comission;
use App\Models\Comission_Receipt;
use Livewire\Component;
use Livewire\WithPagination;

class UserComissao extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $modalidade_comissao;
    public $qtd_comissao = 10;
    public $recibo;
    public $recibo_info;
    public $data_info;
    public $contract_number;

    public function mount(){
        $this->modalidade_comissao = 1;
    }

    public function alternarModalidadeComissao($id){
        $this->modalidade_comissao = $id;
    }

    public function openReceipt($id){

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        //CHECK IF USER IS AUTHORIZED

            $check_auth_comission_receipt = Comission::find($id);

            if($check_auth_comission_receipt->comissionado_id != auth()->user()->id){
                return redirect('404');
            }

        //ENDCHECK

        $this->recibo = $id;
        $recibo_data = Comission_Receipt::where('comission_id', $this->recibo)->get()->toArray();
        
        $this->recibo_info = $recibo_data;

        $get_contract_from_comission = Comission::where('id', $this->recibo)->pluck('contract_id')->toArray();

        $this->contract_number = $get_contract_from_comission['0'];
    
        $comission_data = Comission::where('id', $this->recibo)->pluck('pagamento')->toArray();
        $get_comission_dia = date('d', strtotime($comission_data['0']));
        $get_comission_mes = $comission_data['0'];
        $get_comission_mes = strftime('%B', strtotime($get_comission_mes));
        $get_comission_ano = date('Y', strtotime($comission_data['0']));

        $this->data_info = [$get_comission_dia, $get_comission_mes, $get_comission_ano];
        
    }

    public function printPage(){
        $this->dispatchBrowserEvent('call-print');
    }

    public function render()
    {

        if($this->modalidade_comissao === 1){
            $get_comissoes = Comission::where('status', 0)
            ->where('status_contrato', '!=', 3)
            ->where('comissionado_id', auth()->user()->id)
            ->orderBy('id', 'ASC')
            ->paginate($this->qtd_comissao);
        }
        elseif($this->modalidade_comissao === 0){
            $get_comissoes = Comission::where('status', 1)
            ->where('comissionado_id', auth()->user()->id)
            ->orderBy('id', 'ASC')
            ->paginate($this->qtd_comissao);
        }

        //COUNT E SUM

            $get_count_geral_comissoes_a_receber = Comission::where('status', 0)->where('comissionado_id', auth()->user()->id)->where('status_contrato', '!=', 3)->count();
            $get_total_geral_comissoes_a_receber = Comission::where('status', 0)->where('comissionado_id', auth()->user()->id)->where('status_contrato', '!=', 3)->sum('valor');
            
            $get_count_geral_comissoes_recebidas = Comission::where('status', 1)->where('comissionado_id', auth()->user()->id)->count();
            $get_total_geral_comissoes_recebidas = Comission::where('status', 1)->where('comissionado_id', auth()->user()->id)->sum('valor');

        //FIM COUNT E SUM

        //FORMATAÇÕES

            $get_total_geral_comissoes_a_receber = number_format($get_total_geral_comissoes_a_receber,2,",",".");
            $get_total_geral_comissoes_recebidas = number_format($get_total_geral_comissoes_recebidas,2,",",".");

        //FIM FORMATAÇÕES

        return view('livewire.user-comissao', compact(
            'get_comissoes',
            'get_count_geral_comissoes_a_receber',
            'get_total_geral_comissoes_a_receber',
            'get_count_geral_comissoes_recebidas',
            'get_total_geral_comissoes_recebidas',
            ))
        ->layout('pages.user-comissoes');
    }
}

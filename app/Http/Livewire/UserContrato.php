<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\Payment;
use App\Models\Receipt;
use Carbon\Carbon;
use Livewire\Component;

class UserContrato extends Component
{
    public $modalidade_mensalidade;
    public $recibo;
    public $recibo_info;
    public $data_info;

    public function mount(){
        $this->modalidade_mensalidade = 1;
    }

    public function alternarModalidade($id){
        $this->modalidade_mensalidade = $id;
    }

    public function openReceipt($id){

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        //CHECK IF USER IS AUTHORIZED

            $check_auth_receipt = Payment::find($id);

            if($check_auth_receipt->user_id != auth()->user()->id){
                return redirect('404');
            }

        //ENDCHECK

        $this->recibo = $id;
        $recibo_data = Receipt::where('payment_id', $this->recibo)->get()->toArray();    
        
        if($recibo_data != null){
        
            $this->recibo_info = $recibo_data;
        
            $payment_data = Payment::where('id', $this->recibo)->pluck('pagamento')->toArray();
            $get_payment_dia = date('d', strtotime($payment_data['0']));
            $get_payment_mes = $payment_data['0'];
            $get_payment_mes = strftime('%B', strtotime($get_payment_mes));
            $get_payment_ano = date('Y', strtotime($payment_data['0']));

            $this->data_info = [$get_payment_dia, $get_payment_mes, $get_payment_ano];  

        }else{
            $this->emit('error-operator', 'O pagamento foi estornado e este recibo foi excluído.');
        }
        
    }

    public function printPage(){
        $this->dispatchBrowserEvent('call-print');
    }

    public function render()
    {

        //LISTAR PLANOS DO USUÁRIO

        $contracts = Contract::where('user_id', auth()->user()->id)->latest('id')->get();

        $all_contratos_user = Contract::where('user_id', auth()->user()->id)->count();
        $ativos_contratos_user = Contract::where('status', 1)->where('user_id', auth()->user()->id)->count();
        $inativos_contratos_user = Contract::where('status', 0)->where('user_id', auth()->user()->id)->count();
        $cancelados_contratos_user = Contract::where('status', 3)->where('user_id', auth()->user()->id)->count();

        //LISTAR MENSALIDADE À VENCER E VENCIDAS

        $data_atual = Carbon::now()->format('Y-m-d');
        $mes_atual = Carbon::now()->format('Y-m');

        if($this->modalidade_mensalidade === 1){

            $get_mensalidades = Payment::where('vencimento', '>=', $data_atual)
            ->where('vencimento', 'like', $mes_atual . '%')
            ->where('status_contrato', '!=', 3)
            ->where('user_id', auth()->user()->id)
            ->orderBy('vencimento', 'ASC')
            ->get();

        }
        elseif($this->modalidade_mensalidade === 0){

            $get_mensalidades = Payment::where('vencimento', '<', $data_atual)
            ->where('status_contrato', '!=', 3)
            ->where('status', '!=', 1)
            ->where('user_id', auth()->user()->id)
            ->orderBy('vencimento', 'DESC')
            ->get();

        }

        $pack_mensalidades_a_vencer = Payment::where('vencimento', '>=', $data_atual)
        ->where('vencimento', 'like', $mes_atual . '%')
        ->where('status_contrato', '!=', 3)
        ->where('status', '!=', 1)
        ->where('user_id', auth()->user()->id)
        ->get();

        $pack_mensalidades_vencidas = Payment::where('vencimento', '<', $data_atual)
        ->where('status_contrato', '!=', 3)
        ->where('status', '!=', 1)
        ->where('user_id', auth()->user()->id)
        ->get();

        //COUNT E SUM MENSALIDADES

            $get_mensalidades_a_vencer = $pack_mensalidades_a_vencer->count();
            $get_total_mensalidades_a_vencer = $pack_mensalidades_a_vencer->sum('valor');

            $get_mensalidades_vencidas = $pack_mensalidades_vencidas->count();
            $get_total_mensalidades_vencidas = $pack_mensalidades_vencidas->sum('valor');

            $get_total_geral_a_pagar = $get_total_mensalidades_a_vencer + $get_total_mensalidades_vencidas; 

        //FIM COUNT E SUM MENSALIDADES

        //FORMATAÇÃO

            $get_total_mensalidades_a_vencer = number_format($get_total_mensalidades_a_vencer,2,",",".");
            $get_total_mensalidades_vencidas = number_format($get_total_mensalidades_vencidas,2,",",".");
            $get_total_geral_a_pagar = number_format($get_total_geral_a_pagar,2,",",".");

        //FIM FORMATAÇÃO


        return view('livewire.user-contrato', compact(
            'contracts',
            'all_contratos_user',
            'ativos_contratos_user',
            'inativos_contratos_user',
            'cancelados_contratos_user',
            'get_mensalidades',
            'get_mensalidades_a_vencer',
            'get_mensalidades_vencidas',
            'get_total_mensalidades_a_vencer',
            'get_total_mensalidades_vencidas',
            'get_total_geral_a_pagar',
            ))
        ->layout('pages.user-contratos');
    }
}

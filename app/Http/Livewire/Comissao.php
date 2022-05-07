<?php

namespace App\Http\Livewire;

use App\Models\Comission;
use App\Models\Comission_Receipt;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Comissao extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['render'];
    public $modalidade_comissao;
    public $comissao_target;
    public $search_comissao;
    public $qtd_comissao = 10;

    public function mount(){
        $this->modalidade_comissao = 1;
    }

    public function confirmationComissao($id)
    {
        $this->comissao_target = $id;

        $get_comission_to_check_data = Comission::where('id', $this->comissao_target)->get()->toArray();
        $id_to_check = $get_comission_to_check_data['0']['comissionado_id'];
        
        $get_usr_to_check_data = User::where('id', $id_to_check)->get()->toArray();
        
        $chave_pix = $get_usr_to_check_data['0']['chave_pix'];
        $banco = $get_usr_to_check_data['0']['banco'];

        if(empty($chave_pix) or empty($banco)){
            $this->emit('error-pagamento', 'Estão faltando dados para gerar o recibo!');
        }else{
            $this->dispatchBrowserEvent('show-comissao-confirmation');
        }
    }

    public function resetComissao()
    {
        $this->reset('comissao_target');
        $this->dispatchBrowserEvent('close-comissao-confirmation');
    }

    public function payComissao($id){

        $dia_atual = Carbon::now()->format('Y-m-d');
        
        $comissao = Comission::find($id);
        $comissao->status = 1;
        $comissao->pagamento = $dia_atual;
        $comissao->save();

        $user_from_comission = User::find($comissao->comissionado_id);

        $recibo_comissao = new Comission_Receipt;
        $recibo_comissao->comission_id = $id;
        $recibo_comissao->nome = $user_from_comission->name;
        $recibo_comissao->chave_pix = $user_from_comission->chave_pix;
        $recibo_comissao->banco = $user_from_comission->banco;
        $recibo_comissao->save();

        //NOTIFICAÇÃO DE COMISSÃO PAGA

        $valor_comissao_ntf = number_format($comissao->valor,2,",",".");
        $data_comissao_ntf = date('d/m/Y', strtotime($comissao->previsao));

        $msg_notification_comissao_paga = 'Olá! Enviamos seu pagamento de <b style="color: green;">R$ ' . $valor_comissao_ntf . '</b> referente à comissão que estava prevista para ser paga no dia <b>' . $data_comissao_ntf . '</b>. Para visualizar os detalhes da comissão e imprimir o seu recibo, vá até o menu <b>Minha conta</b> e em seguida <b>></b> <b>Minhas comissões</b>. Continue compartilhando seu código de convite com seus amigos para receber cada vez mais! Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

        $notification_comissao_paga = new Notification;
        $notification_comissao_paga->user_id = $comissao->comissionado_id;
        $notification_comissao_paga->content = $msg_notification_comissao_paga;
        $notification_comissao_paga->is_read = 0;
        $notification_comissao_paga->save();

        $this->dispatchBrowserEvent('close-comissao-confirmation');
        $this->reset('comissao_target');

    }

    public function alternarModalidadeComissao($id){
        $this->modalidade_comissao = $id;
        $this->reset('search_comissao');
    }

    public function render()
    {

        if($this->modalidade_comissao === 1){
            $get_comissoes = Comission::where('status', 0)
            ->where('contract_id', 'like', '%' . $this->search_comissao . '%')
            ->where('status_contrato', '!=', 3)
            ->orderBy('id', 'ASC')
            ->paginate($this->qtd_comissao);
        }
        elseif($this->modalidade_comissao === 0){
            $get_comissoes = Comission::where('status', 1)
            ->where('contract_id', 'like', '%' . $this->search_comissao . '%')
            ->orderBy('id', 'ASC')
            ->paginate($this->qtd_comissao);
        }

        //COUNT E SUM

            $get_count_geral_comissoes_a_pagar = Comission::where('status', 0)->where('status_contrato', '!=', 3)->count();
            $get_total_geral_comissoes_a_pagar = Comission::where('status', 0)->where('status_contrato', '!=', 3)->sum('valor');
            
            $get_count_geral_comissoes_pagas = Comission::where('status', 1)->count();
            $get_total_geral_comissoes_pagas = Comission::where('status', 1)->sum('valor');

        //FIM COUNT E SUM

        //FORMATAÇÕES

            $get_total_geral_comissoes_a_pagar = number_format($get_total_geral_comissoes_a_pagar,2,",",".");
            $get_total_geral_comissoes_pagas = number_format($get_total_geral_comissoes_pagas,2,",",".");

        //FIM FORMATAÇÕES

        return view('livewire.comissao', compact(
            'get_comissoes',
            'get_count_geral_comissoes_a_pagar',
            'get_total_geral_comissoes_a_pagar',
            'get_count_geral_comissoes_pagas',
            'get_total_geral_comissoes_pagas',
        ));
    }
}

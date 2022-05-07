<?php

namespace App\Http\Livewire;

use App\Models\Comission;
use App\Models\Contract;
use App\Models\User;
use App\Models\Maintence;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Receipt;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Admin extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['render'];
    public $estado_manutencao;
    public $qtd = 10;
    public $user_id;
    public $username;
    public $search;
    public $mensalidade_target;
    public $vencimento_mensalidade;
    public $contrato_target;
    public $modalidade_mensalidade;
    public $search_mensalidade;
    public $user_to_delete;
    public $username_to_delete;

    public $rules = [

        'vencimento_mensalidade' => 'required',        
    ];

    protected $messages = [
        
        'vencimento_mensalidade.required' => 'A data de vencimento é obrigatória.',
        
    ];

    public function mount(){
        $manutencao = Maintence::find(1);
        $this->estado_manutencao = $manutencao->estado;
        $this->modalidade_mensalidade = 1;
    }

    public function deletarUser($id){

        $this->user_to_delete = $id;
        $usuario_to_delete = User::find($this->user_to_delete);
        $this->username_to_delete = $usuario_to_delete->name;
        $this->dispatchBrowserEvent('show-delete-user');

    }

    public function confirmDeletarUser(){

        $proceed_deletion = User::find($this->user_to_delete);
        $proceed_deletion->delete();

        $this->reset('user_to_delete', 'username_to_delete');
        $this->emit('alert', 'Usuário deletado com sucesso!');

    }

    public function resetUserToDeleteInfo(){
        $this->reset('user_to_delete', 'username_to_delete');
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function manutencao(){
        
        $manutencao = Maintence::find(1);

        if($manutencao->estado === 0){
            $manutencao->estado = 1;
        }elseif($manutencao->estado === 1){
            $manutencao->estado = 0;
        }

        $manutencao->save();
        
        $this->estado_manutencao = $manutencao->estado;

    }

    public function acesso($id){

        $this->user_id = $id;

        $usuario = User::find($this->user_id);
        
        if($usuario->is_blocked == 0){         
            $usuario->is_blocked = 1;
        }elseif($usuario->is_blocked == 1){
            $usuario->is_blocked = 0;
        }

        $usuario->save();
        
    }

    public function openContracts($id){
        
        $this->user_id = $id;
        $usuario = User::find($this->user_id);
        $this->username = $usuario->name;
        $this->emit('getUser', $this->user_id);

    }

    public function payConfirmation($id)
    {
        $this->mensalidade_target = $id;

        $get_mensal_to_check_data = Payment::where('id', $this->mensalidade_target)->get()->toArray();
        $id_to_check = $get_mensal_to_check_data['0']['user_id'];
        
        $get_usr_to_check_data = User::where('id', $id_to_check)->get()->toArray();
        
        $documento = $get_usr_to_check_data['0']['documento'];
        $cidade = $get_usr_to_check_data['0']['cidade'];
        $estado = $get_usr_to_check_data['0']['estado'];

        if(empty($documento) or empty($cidade) or empty($estado)){
            $this->emit('error-pagamento', 'Estão faltando dados para gerar o recibo!');
        }else{
            $this->dispatchBrowserEvent('show-pay-confirmation');
        }

    }

    public function resetOperation()
    {
        $this->reset('mensalidade_target');
        $this->dispatchBrowserEvent('close-pay-confirmation');
    }

    public function payMensalidade($id){

        $dia_atual = Carbon::now()->format('Y-m-d');
        
        $mensalidade = Payment::find($id);
        $mensalidade->status = 1;
        $mensalidade->pagamento = $dia_atual;
        $mensalidade->valor_pago = $mensalidade->valor;
        $mensalidade->save();

        $get_contract = Contract::find($mensalidade->contract_id);
        $get_contract->pagas = $get_contract->pagas + 1;
        $get_contract->save();

        if($get_contract->pagas == $get_contract->periodo){

            $get_contract->status = 0;
            $get_contract->save();

            //NOTIFICAÇÃO DE CONTRATO INATIVO

            $msg_notification_contrato_inativo = 'Olá! Viemos te avisar que seu contrato com a Plataforma Cashiers acaba de ser inativado, todas as mensalidades foram quitadas e você não possui mais nenhum débito conosco. Para continuar a usar os serviços da nossa plataforma, entre em contato conosco para realizarmos a renovação do seu contrato. <a target="_blank" class="verify-font" href="https://api.whatsapp.com/send?phone=5534998395367&text=Ol%C3%A1!%20Gostaria%20de%20estar%20realizando%20a%20renova%C3%A7%C3%A3o%20do%20meu%20contrato%20com%20a%20Plataforma%20Cashiers!">Clique aqui</a> para falar com o suporte. Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

            $notification_contrato_inativo = new Notification;
            $notification_contrato_inativo->user_id = $mensalidade->user_id;
            $notification_contrato_inativo->content = $msg_notification_contrato_inativo;
            $notification_contrato_inativo->is_read = 0;
            $notification_contrato_inativo->save();

        }

        $user_from_payment = User::find($mensalidade->user_id);

        $recibo = new Receipt;
        $recibo->payment_id = $id;
        $recibo->nome = $user_from_payment->name;
        $recibo->documento = $user_from_payment->documento;
        $recibo->cidade = $user_from_payment->cidade;
        $recibo->estado = $user_from_payment->estado;
        $recibo->save();

        //NOTIFICAÇÃO DE MENSALIDADE PAGA

        if($get_contract->is_test == 0){

        $dia_mensalidade_msg = date('d/m/Y', strtotime($mensalidade->vencimento));

        $msg_notification_mensalidade_paga = 'Olá! Recebemos seu pagamento referente à mensalidade do dia <b style="color: green;">' . $dia_mensalidade_msg . '</b>. Para visualizar os detalhes da mensalidade e imprimir o seu recibo, vá até o menu <b>Minha conta</b> e em seguida <b>></b> <b>Meus contratos</b>. Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

        $notification_mensalidade_paga = new Notification;
        $notification_mensalidade_paga->user_id = $mensalidade->user_id;
        $notification_mensalidade_paga->content = $msg_notification_mensalidade_paga;
        $notification_mensalidade_paga->is_read = 0;
        $notification_mensalidade_paga->save();

        }

        if($get_contract->is_test == 1){

            $usr_to_block = User::find($mensalidade->user_id);
            $usr_to_block->is_blocked = 1;
            $usr_to_block->save(); 

        }

        $this->dispatchBrowserEvent('close-pay-confirmation');
        $this->reset('mensalidade_target');
        
    }

    public function estornoConfirmation($id)
    {
        $this->mensalidade_target = $id;
        $this->dispatchBrowserEvent('show-estorno-confirmation');
    }

    public function resetEstorno()
    {
        $this->reset('mensalidade_target');
        $this->dispatchBrowserEvent('close-estorno-confirmation');
    }

    public function estornarPagamento($id){

        $mensalidade = Payment::find($id);
        $mensalidade->status = 0;
        $mensalidade->pagamento = null;
        $mensalidade->valor_pago = null;
        $mensalidade->save();

        $get_contract = Contract::find($mensalidade->contract_id);
        $get_contract->pagas = $get_contract->pagas - 1;
        $get_contract->save();

        if($get_contract->pagas < $get_contract->periodo){

            if($get_contract->status != 1){

            $get_contract->status = 1;
            $get_contract->save();

            //NOTIFICAÇÃO DE CONTRATO REATIVO

            $venc_mensalidade_ntf = date('d/m/Y', strtotime($mensalidade->vencimento));

            $msg_notification_contrato_reativo = 'Olá! Sua mensalidade com vencimento no dia <b>' . $venc_mensalidade_ntf . '</b> foi estornada, sendo assim, seu contrato que anteriormente estava inativo, voltou a estar ativo até que todas as mensalidades estejam quitadas. Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

            $notification_contrato_reativo = new Notification;
            $notification_contrato_reativo->user_id = $mensalidade->user_id;
            $notification_contrato_reativo->content = $msg_notification_contrato_reativo;
            $notification_contrato_reativo->is_read = 0;
            $notification_contrato_reativo->save();

            }

        }

        $recibo = Receipt::where('payment_id', $mensalidade->id)->delete();

        if($get_contract->is_test == 0){

        $venc_mensalidade_estornada = date('d/m/Y', strtotime($mensalidade->vencimento));

        $msg_notification_mensalidade_estornada = 'Olá! Sua mensalidade com vencimento no dia <b>'. $venc_mensalidade_estornada .'</b> foi estornada. Para realizar o pagamento novamente, vá até o menu <b>Minha conta</b> e em seguida <b>></b> <b>Meus contratos</b>, clique no botão pagar e conclua o passo a passo. Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

        $notification_mensalidade_estornada = new Notification;
        $notification_mensalidade_estornada->user_id = $mensalidade->user_id;
        $notification_mensalidade_estornada->content = $msg_notification_mensalidade_estornada;
        $notification_mensalidade_estornada->is_read = 0;
        $notification_mensalidade_estornada->save();

        }

        $this->dispatchBrowserEvent('close-estorno-confirmation');
        $this->reset('mensalidade_target');
        
    }

    public function vencimentoConfirmation($id)
    {
        $this->mensalidade_target = $id;
        $this->dispatchBrowserEvent('show-vencimento-confirmation');
    }

    public function resetVencimento()
    {
        $this->reset('mensalidade_target');
        $this->reset('vencimento_mensalidade');
        $this->dispatchBrowserEvent('close-vencimento-confirmation');
    }

    public function alterarVencimento($id){

        $this->validate();
        $this->mensalidade_target = $id; 

        $alt_mensalidade = Payment::find($this->mensalidade_target);
        $antigo_vencimento = $alt_mensalidade->vencimento;
        $alt_mensalidade->vencimento = $this->vencimento_mensalidade;
        $alt_mensalidade->save();

        $get_last_mensalidade = Payment::where('contract_id', $alt_mensalidade->contract_id)->orderBy('id', 'DESC')->first();
        
        if($get_last_mensalidade->id == $alt_mensalidade->id){

            $alt_contract = Contract::find($alt_mensalidade->contract_id);
            $alt_contract->vencimento = $alt_mensalidade->vencimento;
            $alt_contract->save();
            
        }

        $novo_vencimento = date('d/m/Y', strtotime($this->vencimento_mensalidade));
        $antigo_vencimento = date('d/m/Y', strtotime($antigo_vencimento));

        $msg_notification_vencimento_alterado = 'Olá! Alteramos o vencimento da sua mensalidade referente ao dia <b>'. $antigo_vencimento .'</b>, a nova data de vencimento foi estabelecida para o dia <b style="color: green;">'. $novo_vencimento .'</b>. Para realizar o pagamento, vá até o menu <b>Minha conta</b> e em seguida <b>></b> <b>Meus contratos</b>, clique no botão pagar e conclua o passo a passo. Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

        $notification_vencimento_alterado = new Notification;
        $notification_vencimento_alterado->user_id = $alt_mensalidade->user_id;
        $notification_vencimento_alterado->content = $msg_notification_vencimento_alterado;
        $notification_vencimento_alterado->is_read = 0;
        $notification_vencimento_alterado->save();

        $this->dispatchBrowserEvent('close-vencimento-confirmation');
        $this->reset('mensalidade_target');
        $this->reset('vencimento_mensalidade');

    }

    public function cancelamentoConfirmation($id)
    {
        $this->contrato_target = $id;
        $this->dispatchBrowserEvent('show-cancelamento-contrato-confirmation');
    }

    public function resetCancelamento()
    {
        $this->reset('contrato_target');
        $this->dispatchBrowserEvent('close-cancelamento-contrato-confirmation');
    }

    public function cancelContract($id){
        
        $this->contrato_target = $id;
        $contract_cancel = Contract::find($this->contrato_target);
        $contract_cancel->status = 3;
        $contract_cancel->save();

        $get_payments_to_cancel = Payment::where('contract_id', $this->contrato_target)->get();

        foreach($get_payments_to_cancel as $payment_to_cancel){
            $payment_to_cancel->status_contrato = 3;
            $payment_to_cancel->save();
        }

        $get_comissions_to_cancel = Comission::where('contract_id', $this->contrato_target)->get();

        foreach($get_comissions_to_cancel as $comission_to_cancel){
            $comission_to_cancel->status_contrato = 3;
            $comission_to_cancel->save();
        }

        $msg_notification_contrato_cancelado = 'Olá! Seu <b>contrato [' . $contract_cancel->id . ']</b> foi cancelado, caso não tenha nenhum contrato ativo com a plataforma, seu acesso irá expirar em até 2 dias úteis. Para continuar a usar os serviços da nossa plataforma, entre em contato conosco para realizarmos a renovação/efetivação do seu contrato. <a target="_blank" class="verify-font" href="https://api.whatsapp.com/send?phone=5534998395367&text=Ol%C3%A1!%20Gostaria%20de%20estar%20realizando%20a%20renova%C3%A7%C3%A3o%20do%20meu%20contrato%20com%20a%20Plataforma%20Cashiers!">Clique aqui</a> para falar com o suporte. Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

        $notification_contrato_cancelado = new Notification;
        $notification_contrato_cancelado->user_id = $contract_cancel->user_id;
        $notification_contrato_cancelado->content = $msg_notification_contrato_cancelado;
        $notification_contrato_cancelado->is_read = 0;
        $notification_contrato_cancelado->save();

        $this->reset('contrato_target');
        $this->emit('alert', 'Contrato cancelado com sucesso!');
        $this->emitTo('comissao', 'render');

    }

    public function exclusaoConfirmation($id)
    {
        $this->contrato_target = $id;
        $this->dispatchBrowserEvent('show-exclusao-contrato-confirmation');
    }

    public function resetExclusao()
    {
        $this->reset('contrato_target');
        $this->dispatchBrowserEvent('close-exclusao-contrato-confirmation');
    }

    public function deleteContract($id){
        
        $this->contrato_target = $id;
        $contract_delete = Contract::find($this->contrato_target);
        $contract_delete->delete();
        $this->reset('contrato_target');
        $this->emit('alert', 'Contrato excluído com sucesso!');
        $this->emitTo('comissao', 'render');

    }

    public function alternarModalidade($id){
        $this->modalidade_mensalidade = $id;
        $this->reset('search_mensalidade');
    }

    public function render()
    {

        $users = User::latest('last_login')
        ->where('is_admin', '!=', 1)
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate($this->qtd);

        $users_count = $users->count();

        //LISTAR CONTRATOS

        $contracts = Contract::where('user_id', $this->user_id)->get();

        $all_contratos = Contract::all()->count();
        $ativos_contratos = Contract::where('status', 1)->count();
        $inativos_contratos = Contract::where('status', 0)->count();
        $cancelados_contratos = Contract::where('status', 3)->count();

        //LISTAR MENSALIDADE À VENCER E VENCIDAS

        $data_atual = Carbon::now()->format('Y-m-d');
        $mes_atual = Carbon::now()->format('Y-m');

        if($this->modalidade_mensalidade === 1){

            $get_mensalidades = Payment::where('vencimento', '>=', $data_atual)
            ->where('vencimento', 'like', $mes_atual . '%')
            ->where('status_contrato', '!=', 3)
            ->where('user_id', 'like', '%' . $this->search_mensalidade . '%')
            ->orderBy('vencimento', 'ASC')
            ->get();

        }
        elseif($this->modalidade_mensalidade === 0){

            $get_mensalidades = Payment::where('vencimento', '<', $data_atual)
            ->where('status_contrato', '!=', 3)
            ->where('status', '!=', 1)
            ->where('user_id', 'like', '%' . $this->search_mensalidade . '%')
            ->orderBy('vencimento', 'DESC')
            ->get();

        }

        $pack_mensalidades_a_vencer = Payment::where('vencimento', '>=', $data_atual)
        ->where('vencimento', 'like', $mes_atual . '%')
        ->where('status_contrato', '!=', 3)
        ->where('status', '!=', 1)
        ->get();

        $pack_mensalidades_vencidas = Payment::where('vencimento', '<', $data_atual)
        ->where('status_contrato', '!=', 3)
        ->where('status', '!=', 1)
        ->get();

        //COUNT E SUM MENSALIDADES

            $get_mensalidades_a_vencer = $pack_mensalidades_a_vencer->count();
            $get_total_mensalidades_a_vencer = $pack_mensalidades_a_vencer->sum('valor');

            $get_mensalidades_vencidas = $pack_mensalidades_vencidas->count();
            $get_total_mensalidades_vencidas = $pack_mensalidades_vencidas->sum('valor');

            $get_total_geral_a_receber = $get_total_mensalidades_a_vencer + $get_total_mensalidades_vencidas; 

        //FIM COUNT E SUM MENSALIDADES

        //FORMATAÇÃO

            $get_total_mensalidades_a_vencer = number_format($get_total_mensalidades_a_vencer,2,",",".");
            $get_total_mensalidades_vencidas = number_format($get_total_mensalidades_vencidas,2,",",".");
            $get_total_geral_a_receber = number_format($get_total_geral_a_receber,2,",",".");

        //FIM FORMATAÇÃO

        return view('livewire.admin', compact(
            'users', 
            'users_count', 
            'contracts', 
            'all_contratos', 
            'ativos_contratos', 
            'inativos_contratos',
            'cancelados_contratos',
            'get_mensalidades',
            'get_mensalidades_a_vencer',
            'get_total_mensalidades_a_vencer',
            'get_mensalidades_vencidas',
            'get_total_mensalidades_vencidas',
            'get_total_geral_a_receber',
            ))
        ->layout('pages.administrador');
    }
}

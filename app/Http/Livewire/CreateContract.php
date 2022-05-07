<?php

namespace App\Http\Livewire;

use App\Models\Comission;
use App\Models\Contract;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\User;
use Livewire\Component;

class CreateContract extends Component
{
    protected $listeners = ['getUser'];

    public $state = [];
    public $id_user;
    public $is_test;
    public $disable_inputs;

    public $rules = [

        'state.pagamento' => 'required',    
        'state.valor' => 'required',    
        'state.meses' => 'required|numeric|max:120',    
    ];

    protected $messages = [
        
        'state.pagamento.required' => 'A data de pagamento é obrigatória.',
        'state.valor.required' => 'O valor do contrato é obrigatório.',
        'state.meses.required' => 'A vigência do contrato é obrigatória.',
        'state.meses.max' => 'A vigência do contrato não pode ser superior à 120 meses.',
        
    ];

    public function mount(){
        $this->state['comissionado'] = 'no-comissionado';
        $this->is_test = false;
    }

    public function avaliacaoContract(){

        if($this->is_test == 'selected'){

            $this->reset('is_test', 'state', 'disable_inputs');
            $this->state['comissionado'] = 'no-comissionado';

        }
        else{

            $this->reset('state');

            $date_one_month = date('Y-m-d', strtotime(' + 1 month'));

            $this->is_test = 'selected';
            $this->disable_inputs = 'selected';
            $this->state['pagamento'] = $date_one_month;
            $this->state['valor'] = '0,00';
            $this->state['meses'] = 1;
            $this->state['comissionado'] = 'no-comissionado';

        }
    }

    public function getUser($id){
        $this->id_user = $id;
    }

    public function confirmation(){

        $this->validate();
        $this->dispatchBrowserEvent('close-modal-contract');
        $this->dispatchBrowserEvent('confirmation-modal-contract');

    }

    public function resetNewOperation(){

        $this->dispatchBrowserEvent('close-modal-contract');
        $this->reset('state', 'is_test', 'disable_inputs');
        $this->state['comissionado'] = 'no-comissionado';

    }

    public function resetOperation(){

        $this->dispatchBrowserEvent('close-confirm-modal-contract');
        $this->reset('state', 'is_test', 'disable_inputs');
        $this->state['comissionado'] = 'no-comissionado';

    }

    public function alternate(){

        $this->dispatchBrowserEvent('close-confirm-modal-contract');
        $this->dispatchBrowserEvent('show-modal-contract');

    }

    public function save(){

        $valor_formatado = str_replace(',', '.', $this->state['valor']);

        if($this->state['comissionado'] == 'no-comissionado'){
            $this->state['comissionado'] = null;
        }

        if($this->is_test == 'selected'){
            $contrato_teste = 1;
        }
        else{
            $contrato_teste = 0;
        }

        $contrato = Contract::create([

            'user_id' => $this->id_user,
            'comissionado_id' => $this->state['comissionado'],
            'periodo' => $this->state['meses'],
            'valor' => $valor_formatado,
            'vencimento' => $this->state['pagamento'],
            'status' => 1,
            'is_test' => $contrato_teste,

        ]); 

        $id_contrato = $contrato->id;
        $venc_mensalidade = $this->state['pagamento'];

        if($this->state['comissionado'] != null){

            $valor_comissao = $valor_formatado / 100 * 10;

            Comission::create([

                'comissionado_id' => $this->state['comissionado'],
                'contract_id' => $id_contrato,
                'valor' => $valor_comissao,
                'previsao' => $this->state['pagamento'],
                'pagamento' => null,
                'status' => 0,
                'status_contrato' => 1,

            ]);

            $valor_comissao_format =  number_format($valor_comissao,2,",",".");
            $previsao_comissao_format = date('d/m/Y', strtotime($this->state['pagamento']));

            $msg_notification_comissao = 'Parabéns! Seu amigo/empresa acaba de entrar para a plataforma utilizando o seu código de convite. Você tem uma comissão pendente a ser recebida no valor de <b style="color: green;">R$ ' . $valor_comissao_format . '</b>, esta comissão está prevista para ser paga no dia <b>' . $previsao_comissao_format . '.</b> Para mais detalhes, acesse o menu <b>Minha conta</b> e em seguida <b>></b> <b>Minhas comissões</b>, para visualizar todos os detalhes da sua comissão e entender como você pode recebê-la! Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

            $notification_comissao = new Notification;
            $notification_comissao->user_id = $this->state['comissionado'];
            $notification_comissao->content = $msg_notification_comissao;
            $notification_comissao->is_read = 0;
            $notification_comissao->save();

        }

        for($i = 0; $i < $this->state['meses']; $i++){
        
            Payment::create([

                'contract_id' => $id_contrato,
                'user_id' => $this->id_user,
                'valor' => $valor_formatado,
                'valor_pago' => null,
                'vencimento' => $venc_mensalidade,
                'pagamento' => null,
                'status' => 0,
                'pagas' => 0,
                'status_contrato' => 1, 

            ]);

            $venc_mensalidade = date('Y-m-d', strtotime($venc_mensalidade. ' + 1 month'));

        }

        $venc_mensalidade = date('Y-m-d', strtotime($venc_mensalidade. ' - 1 month'));

        $contrato_update = Contract::find($id_contrato);
        $contrato_update->vencimento = $venc_mensalidade;
        $contrato_update->save();

        $venc_mensalidade_format = date('d/m/Y', strtotime($venc_mensalidade));

        //NOTIFICAÇÃO DE CONTRATO CRIADO

        $msg_notification_contrato = 'Olá! Seu contrato com a Plataforma Cashiers acaba de ser efetivado e você já pode utilizar todos os nossos serviços. Este contrato tem sua vigência por <b>' . $this->state['meses'] . ' meses</b>, e seu vencimento em <b>' . $venc_mensalidade_format . '.</b> Para mais detalhes, acesse o menu <b>Minha conta</b> e em seguida <b>></b> <b>Meus contratos</b>, para visualizar todos os detalhes do seu contrato e suas respectivas mensalidades. Caso tenha alguma dúvida, não hesite em clicar no botão de <b>Ajuda</b> no canto superior direito da tela e falar conosco! Será sempre um prazer te atender. <b>- Equipe Cashiers</b>.';

        $notification_contrato = new Notification;
        $notification_contrato->user_id = $this->id_user;
        $notification_contrato->content = $msg_notification_contrato;
        $notification_contrato->is_read = 0;
        $notification_contrato->save();
        
        $this->dispatchBrowserEvent('close-confirm-modal-contract');
        $this->reset('state', 'is_test', 'disable_inputs');
        $this->state['comissionado'] = 'no-comissionado';
        $this->dispatchBrowserEvent('fechar-modal-contract');   
        $this->emit('alert', 'Contrato cadastrado com sucesso!');
        $this->emitTo('admin', 'render');
        $this->emitTo('comissao', 'render');

    }

    public function render()
    {

        $comissionados = User::where('is_admin', '!=', 1)
        ->where('id', '!=', $this->id_user)
        ->orderBy('name', 'ASC')
        ->get();

        return view('livewire.create-contract', compact('comissionados'));
    }
}

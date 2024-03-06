<?php

namespace App\Http\Livewire;

use App\Models\Bill;
use App\Models\Bill_Parcel;
use App\Models\Category;
use App\Models\Client;
use App\Models\Method;
use Carbon\Carbon;
use Livewire\Component;

class CreateBill extends Component
{
    public $state = [];

    public $bill_client_param;
    public $bill_category_param;
    public $bill_method_param;

    public $rules = [
        'state.tipo' => 'required',
        'state.descricao' => 'required|max:100',
        'state.data' => 'required',
        'state.categoria' => 'required',
        'state.method' => 'required',
        'state.recurrence' => 'required',
        'state.parcels' => 'required',
        'state.total' => 'required|max:10',
    ];

    protected $messages = [
        'state.tipo.required' => 'O tipo de movimentação é obrigatório.',
        'state.data.required' => 'A data da movimentação é obrigatória.',
        'state.descricao.required' => 'A descrição da movimentação é obrigatória.',
        'state.categoria.required' => 'A categoria da movimentação é obrigatória.',
        'state.method.required' => 'A forma de pagamento da movimentação é obrigatória.',
        'state.recurrence.required' => 'O tipo de recorrência é obrigatório.',
        'state.parcels.required' => 'A quantidade de parcelas é obrigatória.',
        'state.total.required' => 'O total da movimentação é obrigatório.',
    ];

    public function mount()
    {
        $this->state['tipo'] = '1';
        $this->state['recurrence'] = 'unico';
        $this->state['parcels'] = 1;
    }

    public function changeBillType()
    {
        $this->state['categoria'] = "";
        $this->reset('bill_client_param');
        $this->reset('bill_category_param');
        $this->reset('bill_method_param');
    }

    public function updated($field)
    {
        if ($field == 'state.cliente') {
            $this->reset('bill_client_param');
        }

        if ($field == 'state.categoria') {
            $this->reset('bill_category_param');
        }

        if ($field == 'state.method') {
            $this->reset('bill_method_param');
        }

        if ($field == 'state.recurrence') {
            switch ($this->state['recurrence']) {
                case 'unico':
                    $this->state['parcels'] = 1;
                    break;
                case 'mensal':
                    $this->state['parcels'] = "";
                    break;
                default:
                    break;
            }
        }
    }

    public function confirmation()
    {
        $this->reset('bill_client_param');
        $this->reset('bill_category_param');
        $this->reset('bill_method_param');
        $this->validate();
        $this->dispatchBrowserEvent('close-item-modal');
        $this->dispatchBrowserEvent('show-item-confirmation-modal');
    }

    public function resetData()
    {
        $this->dispatchBrowserEvent('close-item-modal');
        $this->reset('state');
        $this->reset('bill_client_param');
        $this->reset('bill_category_param');
        $this->reset('bill_method_param');
        $this->state['tipo'] = '1';
        $this->state['recurrence'] = 'unico';
        $this->state['parcels'] = 1;
    }

    public function resetDataOnConfirm()
    {
        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->reset('state');
        $this->reset('bill_client_param');
        $this->reset('bill_category_param');
        $this->reset('bill_method_param');
        $this->state['tipo'] = '1';
        $this->state['recurrence'] = 'unico';
        $this->state['parcels'] = 1;
    }

    public function alternate()
    {
        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->dispatchBrowserEvent('show-item-modal');
    }

    public function save()
    {
        $total_formatado = str_replace(".", "", $this->state['total']);
        $total_formatado = str_replace(',', '.', $total_formatado);

        if (isset($this->state['cliente'])) {
            $this->state['cliente'] =  $this->state['cliente'] == "" ? null : $this->state['cliente'];
        }

        if ($total_formatado > 0) {

            $created_bill = Bill::create([
                'tipo' => $this->state['tipo'],
                'data' => $this->state['data'],
                'descricao' => $this->state['descricao'],
                'category_id' => $this->state['categoria'],
                'method_id' => $this->state['method'],
                'client_id' => $this->state['cliente'] ?? null,
                'total' => $total_formatado,
                'qtd_parcelas' => $this->state['parcels'],
                'user_id' => auth()->user()->id
            ]);

            // CRIAÇÃO DE PARCELAS

            for ($i = 1; $i <= $this->state['parcels']; $i++) {

                Bill_Parcel::create([
                    'bill_id' => $created_bill->id,
                    'status' => 0,
                    'data_vencimento' => $created_bill->data,
                    'n_parcela' => $i,
                    'total' => $created_bill->total,
                    'user_id' => auth()->user()->id
                ]);

                $created_bill->data = date('Y-m-d', strtotime($created_bill->data . ' + 1 month'));
            }

            // ---

            $this->dispatchBrowserEvent('close-item-confirmation-modal');
            $this->reset('state');
            $this->state['tipo'] = '1';
            $this->state['recurrence'] = 'unico';
            $this->state['parcels'] = 1;

            $this->emit('alert', 'Movimentação cadastrada com sucesso!');
            $this->emitTo('bill', 'render');
        } else {
            $this->emit('alert-error', 'O total da movimentação deve ser maior do que zero.');
        }
    }

    public function render()
    {

        $bill_clients = Client::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->where('nome', 'like', '%' . $this->bill_client_param . '%')
            ->orderBy('nome', 'asc')
            ->get();

        $bill_categories = Category::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->where('tipo', $this->state['tipo'])
            ->where('descricao', 'like', '%' . $this->bill_category_param . '%')
            ->orderBy('descricao', 'asc')
            ->get();

        $bill_methods = Method::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->where('descricao', 'like', '%' . $this->bill_method_param . '%')
            ->orderBy('descricao', 'asc')
            ->get();

        return view('livewire.create-bill', compact('bill_clients', 'bill_categories', 'bill_methods'));
    }
}

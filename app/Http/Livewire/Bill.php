<?php

namespace App\Http\Livewire;

use App\Models\Bill as ModelsBill;
use App\Models\Bill_Parcel;
use App\Models\Operation;
use Livewire\Component;
use Livewire\WithPagination;

class Bill extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $qtd = 20;
    public $logged_operator;
    public $parcel;
    public $processBillConfirmationMsgTitle;
    public $processBillConfirmationMsg;
    public $selectedMonth;
    public $selectedYear;
    protected $listeners = ['render'];

    public function mount()
    {
        $this->logged_operator = session('operador_selecionado')->id ?? '';
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
    }

    public function processBillConfirmation(Bill_Parcel $parcel)
    {
        // Verificando se o dado pertence ao usuário logado
        if ($parcel->user_id != auth()->user()->id) {
            return redirect('404');
        }
        // ---

        if ($parcel->status === 0) {
            $this->processBillConfirmationMsgTitle = 'Deseja realmente dar baixa nesta parcela?';
            $this->processBillConfirmationMsg = 'Ao clicar em <span class="msg-bold">Confirmar</span>, esta parcela será processada e uma
            nova operação será gerada em seu Fluxo de caixa.';
        } elseif ($parcel->status === 1) {
            $this->processBillConfirmationMsgTitle = 'Deseja realmente estornar esta parcela?';
            $this->processBillConfirmationMsg = 'Ao clicar em <span class="msg-bold">Confirmar</span>, esta parcela será estornada e a operação relacionada será apagada do seu Fluxo de caixa.';
        }

        $this->parcel = $parcel;
    }

    public function processBill()
    {
        if ($this->parcel->status === 0) {
            // PAGAMENTO OU RECEBIMENTO

            $this->parcel->status = 1;

            if ($this->parcel->bill->qtd_parcelas > 1) {
                $operation_description = $this->parcel->bill->descricao . ' (parcela ' . $this->parcel->n_parcela . ' de ' . $this->parcel->bill->qtd_parcelas . ')';
            } else {
                $operation_description = $this->parcel->bill->descricao;
            }

            Operation::create([

                'tipo' => $this->parcel->bill->tipo,
                'descricao' => $operation_description,
                'category_id' => $this->parcel->bill->category_id,
                'operator_id' => $this->logged_operator,
                'especie' => 4,
                'method_id' => $this->parcel->bill->method_id,
                'total' => $this->parcel->total,
                'bill_parcel_id' => $this->parcel->id,
                'user_id' => auth()->user()->id

            ]);

            if ($this->parcel->bill->tipo === 1) {
                $msg_bill_status = 'recebida';
                $msg_bill_tipo = 'entrada';
            } elseif ($this->parcel->bill->tipo === 0) {
                $msg_bill_status = 'paga';
                $msg_bill_tipo = 'saída';
            }

            $this->emit('alert', 'Parcela ' . $msg_bill_status . ' com sucesso! Uma operação de ' . $msg_bill_tipo .  ' foi adicionada ao seu Fluxo de caixa.');
        } elseif ($this->parcel->status === 1) {
            // ESTORNO
            $this->parcel->status = 0;

            $get_operation_generated_by_bill = Operation::where('bill_parcel_id', $this->parcel->id)->first();

            $get_operation_generated_by_bill->delete();

            $this->emit('alert', 'A parcela foi estornada com sucesso e a operação relacionada foi apagada do seu Fluxo de caixa.');
        }
        $this->parcel->save();
        $this->dispatchBrowserEvent('close-process-item-conf');
    }

    // DELEÇÃO

    public function prepareToDelete(Bill_Parcel $parcel)
    {

        // Verificando se o dado pertence ao usuário logado
        if ($parcel->user_id != auth()->user()->id) {
            return redirect('404');
        }
        // ---

        $this->parcel = $parcel;
    }

    public function delete()
    {

        $get_bill_id = $this->parcel->bill_id;

        $this->parcel->delete();
        $this->dispatchBrowserEvent('close-delete-item-conf');
        $this->emit('alert', 'Parcela apagada com sucesso!');

        // DELETE BILL IF ZERO PARCELS

        $get_bill_data = ModelsBill::find($get_bill_id);

        if ($get_bill_data->parcel->count() === 0) {
            $get_bill_data->delete();
        }
    }

    // ---

    public function toggleMonth($month)
    {
        $this->selectedMonth = $month;
        $this->resetPage();
    }

    public function updatedSelectedYear()
    {
        $this->resetPage();
    }

    public function render()
    {
        $parcels = Bill_Parcel::where('user_id', auth()->user()->id)
            ->whereMonth('data_vencimento', $this->selectedMonth)
            ->whereYear('data_vencimento', $this->selectedYear)
            ->latest('id')
            ->paginate($this->qtd);

        $parcels_count = Bill_Parcel::where('user_id', auth()->user()->id)
            ->count();

        // SOMATÓRIA DE TOTAIS

        $total_bills_to_receive = Bill_Parcel::join('bills', 'bill_parcels.bill_id', '=', 'bills.id')
            ->where('bill_parcels.user_id', auth()->user()->id)
            ->where('bill_parcels.status', 0)
            ->where('bills.tipo', 1)
            ->sum('bill_parcels.total');

        $total_bills_received = Bill_Parcel::join('bills', 'bill_parcels.bill_id', '=', 'bills.id')
            ->where('bill_parcels.user_id', auth()->user()->id)
            ->where('bill_parcels.status', 1)
            ->where('bills.tipo', 1)
            ->sum('bill_parcels.total');

        $total_bills_to_pay = Bill_Parcel::join('bills', 'bill_parcels.bill_id', '=', 'bills.id')
            ->where('bill_parcels.user_id', auth()->user()->id)
            ->where('bill_parcels.status', 0)
            ->where('bills.tipo', 0)
            ->sum('bill_parcels.total');

        $total_bills_paid = Bill_Parcel::join('bills', 'bill_parcels.bill_id', '=', 'bills.id')
            ->where('bill_parcels.user_id', auth()->user()->id)
            ->where('bill_parcels.status', 1)
            ->where('bills.tipo', 0)
            ->sum('bill_parcels.total');

        // ANOS EM QUE O USUÁRIO REALIZOU MOVIMENTAÇÕES

        $years = Bill_Parcel::selectRaw('YEAR(data_vencimento) as year')
            ->where('user_id', auth()->user()->id)
            ->distinct()
            ->orderBy('year')
            ->get()
            ->pluck('year');

        return view(
            'livewire.bill',
            compact(
                'parcels',
                'parcels_count',
                'years',
                'total_bills_to_receive',
                'total_bills_received',
                'total_bills_to_pay',
                'total_bills_paid'
            )
        )->layout('pages.bills');
    }
}

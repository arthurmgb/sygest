<?php

namespace App\Http\Livewire;

use App\Models\Operator;
use Livewire\Component;

class CheckAuth extends Component
{

    public $account_operators;
    public $selectedOperator;

    public function mount()
    {
        $this->account_operators = Operator::where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->orderBy('nome', 'ASC')
            ->get();
    }

    public function updatedSelectedOperator()
    {

        $operador_encontrado = Operator::find($this->selectedOperator);

        $this->dispatchBrowserEvent('unlock-acc-operator');

        session(['operador_selecionado' => $operador_encontrado]);

        // session()->forget('operador_selecionado');
    }

    public function render()
    {

        return view('livewire.check-auth');
    }
}

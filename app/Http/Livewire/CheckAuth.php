<?php

namespace App\Http\Livewire;

use App\Models\Operator;
use Livewire\Component;

class CheckAuth extends Component
{

    public $account_operators;
    public $selectedOperator;
    public $operatorPass;
    public $showInput =  false;
    public $foundOperator;

    public function mount()
    {
        $this->account_operators = Operator::where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->orderBy('nome', 'ASC')
            ->get();
    }

    public function updatedSelectedOperator()
    {
        $this->reset('operatorPass');

        if (empty($this->selectedOperator)) {
            $this->showInput = false;
            return;
        }

        $this->foundOperator = Operator::find($this->selectedOperator);

        $this->showInput = true;

        // $this->dispatchBrowserEvent('unlock-acc-operator');

        // session(['operador_selecionado' => $operador_encontrado]);

        // session()->forget('operador_selecionado');
    }

    public function verifyCredentials(){
        dd($this->foundOperator);
    }

    public function render()
    {

        return view('livewire.check-auth');
    }
}

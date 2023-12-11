<?php

namespace App\Http\Livewire;

use App\Models\Operator;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class CheckAuth extends Component
{

    public $account_operators;
    public $selectedOperator;
    public $operatorPass;
    public $showInput =  false;
    public $foundOperator;

    public $rules = [

        'operatorPass' => 'required',
    ];

    protected $messages = [

        'operatorPass.required' => 'Campo obrigatório.',
    ];

    public function mount()
    {
        $this->account_operators = Operator::where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->orderBy('nome', 'ASC')
            ->get();
    }

    public function generateAdminOperator()
    {
        Operator::create([

            'nome' => auth()->user()->name,
            'senha' => 123,
            'is_admin' => 1,
            'user_id' => auth()->user()->id

        ]);

        $this->mount();

    }

    public function updatedSelectedOperator()
    {
        $this->reset('operatorPass');

        if (empty($this->selectedOperator)) {
            $this->showInput = false;
            return;
        }

        $this->foundOperator = Operator::find($this->selectedOperator);

        if ($this->foundOperator->user_id != auth()->user()->id) {
            return redirect('404');
        }

        $this->showInput = true;
    }

    public function verifyCredentials()
    {
        $this->validate();

        if ($this->foundOperator->senha === $this->operatorPass) {
            session(['operador_selecionado' => $this->foundOperator]);
            
            $this->dispatchBrowserEvent('unlock-acc-operator');
        } else {
            $this->addError('operatorPass', 'Senha incorreta.');
        }

        $this->emitTo('create-op', 'render');
        $this->emitTo('create-ret', 'render');
        
    }

    public function render()
    {
        
        
        return view('livewire.check-auth');
    }
}

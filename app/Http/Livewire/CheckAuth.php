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
    public $generatingAdmin = false;

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

        $get_operator_online =  session('operador_selecionado');

        $rotaAtual = Route::currentRouteName();

        $rotasPermitidas = ['home', 'geral', 'retiradas'];

        if (!$this->generatingAdmin) {

            if (is_null($get_operator_online) && !in_array($rotaAtual, $rotasPermitidas)) {
                abort(403, 'Erro. Tentativa de acesso inválida.');
            }
        }

        $this->reset('generatingAdmin');


        if (!is_null($get_operator_online)) {
            if ($get_operator_online->is_admin !== 1) {
                if (!in_array($rotaAtual, $rotasPermitidas)) {
                    abort(403, 'Acesso não autorizado. Por favor, entre em contato com o gerente.');
                }
            }
        }
    }

    public function generateAdminOperator()
    {
        Operator::create([

            'nome' => auth()->user()->name,
            'senha' => 123,
            'is_admin' => 1,
            'user_id' => auth()->user()->id

        ]);

        $this->generatingAdmin = true;

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
        $this->emitTo('create-venda', 'mount');
        $this->emitTo('home', 'mount');
        $this->emitTo('visao-geral', 'render');
    }

    public function render()
    {

        return view('livewire.check-auth');
    }
}

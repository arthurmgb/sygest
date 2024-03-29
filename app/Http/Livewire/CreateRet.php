<?php

namespace App\Http\Livewire;

use App\Models\Method;
use App\Models\Operation;
use App\Models\Operator;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateRet extends Component
{
    use WithFileUploads;

    protected $listeners = ['refreshComponent' => '$refresh', 'render'];
    public $state = [];
    public $imagem;

    public $rules = [

        'state.descricao' => 'required|max:100',
        'state.total' => 'required|max:10',
        'state.operador' => 'required',
        'state.especie' => 'required',
        'imagem' => 'nullable|image|max:1024',
    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição da retirada é obrigatória.',
        'state.total.required' => 'O total da retirada é obrigatório.',
        'state.operador.required' => 'O operador de caixa é obrigatório.',
        'state.especie.required' => 'A espécie da operação é obrigatória.',

    ];

    public function refreshOp()
    {
        $this->emit('refreshComponent');
    }

    public function mount()
    {

        $this->state['tipo'] = '3';
        $this->state['fp'] = "";

        if (isset($this->state['operador']) and !empty($this->state['operador'])) {

            $check_operator_active = Operator::where('user_id', auth()->user()->id)
                ->where('id', $this->state['operador'])
                ->first();

            if ($check_operator_active->status == 1) {
                $this->state['operador'] = "";
            }
        }

        $get_default_operator = session()->get('operador_selecionado');

        if (!is_null($get_default_operator)) {
            $this->state['operador'] = $get_default_operator->id;
        } else {
            $this->state['operador'] = "";
        }
    }

    public function dehydrate()
    {

        if (isset($this->state['operador']) and !empty($this->state['operador'])) {

            $check_operator_active = Operator::where('user_id', auth()->user()->id)
                ->where('id', $this->state['operador'])
                ->first();

            if ($check_operator_active->status == 1) {
                $this->state['operador'] = "";
            }
        }

        $get_default_operator = session()->get('operador_selecionado');

        if (!is_null($get_default_operator)) {
            $this->state['operador'] = $get_default_operator->id;
        } else {
            $this->state['operador'] = "";
        }
    }

    public function confirmation()
    {

        $this->validate();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('confirmation-modal');
    }

    public function resetNewOperation()
    {

        $this->dispatchBrowserEvent('close-modal');
        $this->reset('state');
        $this->state['tipo'] = '3';
        $this->state['operador'] = "";
        $this->state['especie'] = "";
        $this->state['fp'] = "";
        $this->reset('imagem');
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->reset('state');
        $this->state['tipo'] = '3';
        $this->state['operador'] = "";
        $this->state['especie'] = "";
        $this->state['fp'] = "";
        $this->reset('imagem');
    }

    public function alternate()
    {

        $this->dispatchBrowserEvent('close-confirm-modal');
        $this->dispatchBrowserEvent('show-modal');
    }

    public function save()
    {

        //Verifica se há receita disponível para retirada
        $receita_entrada = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [1])
            ->sum('total');

        $receita_saida = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [0, 3])
            ->sum('total');

        $receita_valor = $receita_entrada - $receita_saida;

        $total_formatado = str_replace(".", "", $this->state['total']);
        $total_formatado = str_replace(',', '.', $total_formatado);

        if ($total_formatado == 0) {
            $this->emit('alert-error', 'O total da operação deve ser maior do que zero.');
        } else {

            if ($total_formatado <= $receita_valor) {

                if (empty($this->state['fp'])) {
                    $this->state['fp'] = null;
                }

                if ($this->imagem) {
                    $nomeUnico = md5(uniqid()) . '.' . $this->imagem->extension();

                    // Salvar a imagem na pasta storage/public/imagens
                    $caminhoImagem = $this->imagem->storeAs('public/imagens', $nomeUnico);

                    $caminhoImagemNoBanco = str_replace('public/', '', $caminhoImagem);
                } else {
                    $caminhoImagemNoBanco = null;
                }

                Operation::create([

                    'tipo' => $this->state['tipo'],
                    'descricao' => $this->state['descricao'],
                    'category_id' => null,
                    'operator_id' => $this->state['operador'],
                    'especie' => $this->state['especie'],
                    'method_id' => $this->state['fp'],
                    'total' => $total_formatado,
                    'imagem' => $caminhoImagemNoBanco,
                    'user_id' => auth()->user()->id

                ]);

                $this->dispatchBrowserEvent('close-confirm-modal');
                $this->reset('state');
                $this->state['tipo'] = '3';
                $this->state['operador'] = "";
                $this->state['especie'] = "";
                $this->state['fp'] = "";
                $this->reset('imagem');

                $this->emit('alert', 'Retirada de caixa realizada com sucesso!');
                $this->emitTo('retirada', 'render');
            } else {

                $this->dispatchBrowserEvent('close-confirm-modal');
                $this->reset('state');
                $this->state['tipo'] = '3';
                $this->state['operador'] = "";
                $this->state['especie'] = "";
                $this->state['fp'] = "";
                $this->reset('imagem');

                $this->emit('alert-error', 'Você não possui saldo suficiente para realizar uma retirada de caixa.');
                $this->emitTo('retirada', 'render');
            }
        }

        //Fim verificação

    }

    public function render()
    {

        if (session()->get('operador_selecionado')) {
            $operadores = Operator::where('user_id', auth()->user()->id)
                ->where('id', session()->get('operador_selecionado')->id)
                ->orderBy('nome', 'asc')
                ->get();
        } else {
            $operadores = [];
        }

        $formas_de_pag = Method::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'asc')
            ->get();

        if (isset($this->state['especie']) and $this->state['especie'] != 4) {
            $this->state['fp'] = "";
        }

        return view('livewire.create-ret', compact('operadores', 'formas_de_pag'));
    }
}

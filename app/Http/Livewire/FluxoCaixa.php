<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class FluxoCaixa extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $option;

    public $receita = null;

    public $qtd = 10;

    public $operationData;

    public $attachment;

    protected $listeners = ['render'];

    public function changeOption($id)
    {
        $this->option = $id;
    }

    public function mount()
    {
        $this->option = [1, 0];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function geraReceita()
    {
        if ($this->receita == null) {
            $this->receita = true;
        } else {
            $this->receita = null;
        }
    }

    public function prepareToDelete(Operation $operation)
    {

        // Verificando se o dado pertence ao usuário logado
        if ($operation->user_id != auth()->user()->id) {
            return redirect('404');
        }
        // ---

        $this->operationData = $operation;
    }

    public function delete()
    {
        $get_operator_online =  session('operador_selecionado');

        if ($get_operator_online->is_admin !== 1) {
            $this->emit('denied', 'Apenas o gerente desta conta pode apagar operações. Por favor, entre em contato com o gerente.');
            $this->dispatchBrowserEvent('close-delete-item-conf');
            return;
        }

        // Remover a imagem do armazenamento
        if ($this->operationData->imagem) {
            Storage::delete('public/' . $this->operationData->imagem);
        }

        $this->operationData->delete();
        $this->dispatchBrowserEvent('close-delete-item-conf');
        $this->emit('alert', 'Operação apagada com sucesso!');
    }

    public function showAttachedImage(Operation $operation)
    {

        if ($operation->user_id != auth()->user()->id) {
            return redirect('404');
        }

        $this->attachment = $operation->imagem;
    }

    public function resetAttachedImage()
    {
        $this->reset('attachment');
    }

    public function render()
    {

        $operations = Operation::where('user_id', auth()->user()->id)
            ->where('descricao', 'like', '%' . $this->search . '%')
            ->whereIn('tipo', $this->option)
            ->latest('id')
            ->paginate($this->qtd);

        $operations_count = Operation::where('user_id', auth()->user()->id)
            ->where('tipo', '!=', 3)
            ->count();

        $operations_find = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', $this->option)
            ->count();

        if ($this->receita == true) {

            if ($this->option == [1, 0]) {

                $receita_entrada = Operation::where('user_id', auth()->user()->id)
                    ->whereIn('tipo', [1])
                    ->sum('total');

                $receita_saida = Operation::where('user_id', auth()->user()->id)
                    ->whereIn('tipo', [0])
                    ->sum('total');

                $receita_valor = $receita_entrada - $receita_saida;
            } elseif ($this->option == [1]) {

                $receita_entrada = Operation::where('user_id', auth()->user()->id)
                    ->whereIn('tipo', [1])
                    ->sum('total');

                $receita_valor = $receita_entrada;

                $receita_saida = 0;
            } elseif ($this->option == [0]) {

                $receita_saida = Operation::where('user_id', auth()->user()->id)
                    ->whereIn('tipo', [0])
                    ->sum('total');

                $receita_valor = $receita_saida;

                $receita_entrada = 0;
            }

            $receita_valor = number_format($receita_valor, 2, ",", ".");
            $receita_entrada = number_format($receita_entrada, 2, ",", ".");
            $receita_saida = number_format($receita_saida, 2, ",", ".");

            return view('livewire.fluxo-caixa', compact('operations', 'operations_count', 'receita_valor', 'operations_find', 'receita_entrada', 'receita_saida'))
                ->layout('pages.fluxo-caixa');
        } else {
            return view('livewire.fluxo-caixa', compact('operations', 'operations_count'))
                ->layout('pages.fluxo-caixa');
        }
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Retirada extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $qtd = 10;

    public $operationData;

    public $attachment;

    protected $listeners = ['render'];

    public function updatingSearch()
    {
        $this->resetPage();
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
            $this->emit('denied', 'Apenas o gerente desta conta pode apagar retiradas. Por favor, entre em contato com o gerente.');
            $this->dispatchBrowserEvent('close-delete-item-conf');
            return;
        }

        // Remover a imagem do armazenamento
        if ($this->operationData->imagem) {
            Storage::delete('public/' . $this->operationData->imagem);
        }

        $this->operationData->delete();
        $this->dispatchBrowserEvent('close-delete-item-conf');
        $this->emit('alert', 'Retirada apagada com sucesso!');
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

        $retiradas = Operation::where('user_id', auth()->user()->id)
            ->where('descricao', 'like', '%' . $this->search . '%')
            ->whereIn('tipo', [3])
            ->latest('id')
            ->paginate($this->qtd);

        $retiradas_count = Operation::where('user_id', auth()->user()->id)
            ->whereIn('tipo', [3])
            ->count();


        return view('livewire.retirada', compact('retiradas', 'retiradas_count'))
            ->layout('pages.retiradas');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Livewire\Component;
use Livewire\WithPagination;

class Retirada extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $qtd = 10;

    protected $listeners = ['render'];

    public function updatingSearch()
    {
        $this->resetPage();
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

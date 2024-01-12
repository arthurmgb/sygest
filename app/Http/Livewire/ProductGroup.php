<?php

namespace App\Http\Livewire;

use App\Models\Product_Group;
use Livewire\Component;
use Livewire\WithPagination;

class ProductGroup extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $qtd = 10;
    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $groups = Product_Group::where('user_id', auth()->user()->id)
            ->where('descricao', 'like', '%' . $this->search . '%')
            ->where('status', 1)
            ->latest('id')
            ->paginate($this->qtd);

        $groups_count = Product_Group::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->count();

        return view('livewire.product-group', compact('groups', 'groups_count'))
            ->layout('pages.product-groups');
    }
}

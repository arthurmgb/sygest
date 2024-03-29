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
    public $search, $product_group;
    protected $listeners = ['render'];

    public $rules = [
        'product_group.descricao' => 'required|max:100',
        'product_group.status' => 'required',
    ];

    protected $messages = [

        'product_group.descricao.required' => 'A descrição do grupo é obrigatória.',

    ];

    public function edit(Product_Group $product_group)
    {
        // Verificando se o dado pertence ao usuário logado
        if ($product_group->user_id != auth()->user()->id) {
            return redirect('404');
        }
        // ---

        $this->product_group = $product_group;
    }

    public function confirmUpdate()
    {
        $this->validate();
        $this->dispatchBrowserEvent('close-item-edit-modal');
        $this->dispatchBrowserEvent('show-item-edit-confirmation-modal');
    }

    public function resetUpdate()
    {
        $this->dispatchBrowserEvent('close-item-edit-confirmation-modal');
    }

    public function alternate()
    {
        $this->dispatchBrowserEvent('close-item-edit-confirmation-modal');
        $this->dispatchBrowserEvent('show-item-edit-modal');
    }

    public function update()
    {
        $this->product_group->save();
        $this->dispatchBrowserEvent('close-item-edit-confirmation-modal');
        $this->emit('alert', 'Grupo editado com sucesso!');
    }

    public function prepareToDelete(Product_Group $product_group)
    {

        // Verificando se o dado pertence ao usuário logado
        if ($product_group->user_id != auth()->user()->id) {
            return redirect('404');
        }
        // ---

        $this->product_group = $product_group;
        $this->product_group['status'] = 0;
    }

    public function delete()
    {
        $this->product_group->save();
        $this->dispatchBrowserEvent('close-delete-item-conf');
        $this->emit('alert', 'Grupo apagado com sucesso!');
    }

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

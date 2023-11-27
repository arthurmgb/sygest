<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Produto extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search, $produto;
    public $qtd = 10;
    protected $listeners = ['render'];

    public $rules = [
        'produto.status' => 'required',
        'produto.descricao' => 'required|max:100',
    ];

    // protected $messages = [

    //     'categoria.tipo.required' => 'O tipo de categoria é obrigatório.',
    //     'categoria.status.required' => 'O status da categoria é obrigatório.',
    //     'categoria.descricao.required' => 'A descrição da categoria é obrigatória.',

    // ];

    // public function confirmation()
    // {

    //     $this->validate();
    //     $this->dispatchBrowserEvent('close-edit-modal');
    //     $this->dispatchBrowserEvent('show-edit-confirmation-modal');
    // }

    // public function resetOperation()
    // {

    //     $this->dispatchBrowserEvent('close-edit-confirmation-modal');
    // }

    // public function alternate()
    // {

    //     $this->dispatchBrowserEvent('close-edit-confirmation-modal');
    //     $this->dispatchBrowserEvent('show-edit-modal');
    // }

    // public function edit(Category $categoria)
    // {
    //     if ($categoria->user_id != auth()->user()->id) {
    //         return redirect('404');
    //     }


    //     $this->categoria = $categoria;
    // }

    // public function update()
    // {

    //     $this->categoria->save();
    //     $this->dispatchBrowserEvent('close-edit-confirmation-modal');
    //     $this->emit('alert', 'Categoria editada com sucesso!');
    // }

    public function prepare(Product $produto)
    {
        if ($produto->user_id != auth()->user()->id) {
            return redirect('404');
        }

        $this->produto = $produto;
        $this->produto['status'] = 0;
    }

    public function delete()
    {
        $this->produto->save();
        $this->dispatchBrowserEvent('close-delete-item-conf');
        $this->emit('alert', 'Produto apagado com sucesso!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $produtos = Product::where('user_id', auth()->user()->id)
            ->where('descricao', 'like', '%' . $this->search . '%')
            ->whereIn('status', [1])
            ->latest('id')
            ->paginate($this->qtd);

        $prod_count = Product::where('user_id', auth()->user()->id)
            ->whereIn('status', [1])
            ->count();

        return view('livewire.produto', compact('produtos', 'prod_count'))
            ->layout('pages.produtos');
    }
}

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

        'produto.descricao' => 'required|max:100',
        'produto.estoque' => 'required|max:5',
        'produto.estoque_minimo' => 'max:5',
        'produto.preco' => 'required|max:10',
        'produto.status' => 'required',
    ];

    protected $messages = [

        'produto.descricao.required' => 'A descrição do produto é obrigatória.',
        'produto.estoque.required' => 'O estoque do produto é obrigatório.',
        'produto.preco.required' => 'O preço do produto é obrigatório.',

    ];

    public function edit(Product $produto)
    {
        if ($produto->user_id != auth()->user()->id) {
            return redirect('404');
        }


        $this->produto = $produto;
        $this->produto['preco'] = str_replace('.', ',', $this->produto['preco']);
    }

    public function confirmation()
    {

        $this->validate();
        $this->dispatchBrowserEvent('close-item-edit-modal');
        $this->dispatchBrowserEvent('show-item-edit-confirmation-modal');
    }

    public function resetOperation()
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
        $preco_formatado = str_replace(".", "", $this->produto['preco']);
        $preco_formatado = str_replace(',', '.', $preco_formatado);
        $this->produto['preco'] = $preco_formatado;

        empty($this->produto['estoque_minimo']) ? $this->produto['estoque_minimo'] = NULL : $this->produto['estoque_minimo'] = $this->produto['estoque_minimo'];

        $this->produto->save();
        $this->dispatchBrowserEvent('close-item-edit-confirmation-modal');
        $this->emit('alert', 'Produto editado com sucesso!');
    }

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

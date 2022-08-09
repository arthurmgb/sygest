<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Categoria extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search, $categoria;
    public $qtd = 10;
    protected $listeners = ['render'];

    public $rules = [

        'categoria.tipo' => 'required',
        'categoria.status' => 'required',
        'categoria.descricao' => 'required|max:100',
    ];

    protected $messages = [

        'categoria.tipo.required' => 'O tipo de categoria é obrigatório.',
        'categoria.status.required' => 'O status da categoria é obrigatório.',
        'categoria.descricao.required' => 'A descrição da categoria é obrigatória.',

    ];

    public function confirmation()
    {

        $this->validate();
        $this->dispatchBrowserEvent('close-edit-modal');
        $this->dispatchBrowserEvent('show-edit-confirmation-modal');
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
    }

    public function alternate()
    {

        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function edit(Category $categoria)
    {
        if($categoria->user_id != auth()->user()->id){
            return redirect('404');
        }


        $this->categoria = $categoria;
    }

    public function update()
    {

        $this->categoria->save();
        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
        $this->emit('alert', 'Categoria editada com sucesso!');
    }

    public function prepare(Category $categoria)
    {
        if($categoria->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->categoria = $categoria;
        $this->categoria['status'] = 3;
    }

    public function delete()
    {       
        $this->categoria->save();
        $this->dispatchBrowserEvent('close-delete-cat-confirmation-modal');
        $this->emit('alert', 'Categoria apagada com sucesso!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $categorias = Category::where('user_id', auth()->user()->id)
            ->where('descricao', 'like', '%' . $this->search . '%')
            ->whereIn('status', [0,1])
            ->latest('id')
            ->paginate($this->qtd);

        $categorias_count = Category::where('user_id', auth()->user()->id)
            ->whereIn('status', [0,1])
            ->count();

        return view('livewire.categoria', compact('categorias', 'categorias_count'))
            ->layout('pages.categorias');
    }
}

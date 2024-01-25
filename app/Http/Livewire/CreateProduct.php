<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Product_Group;

class CreateProduct extends Component
{

    public $state = [];

    public $product_groups;
    public $selectedGroup = '';

    public $rules = [

        'state.descricao' => 'required|max:100',
        'state.estoque' => 'required|max:5',
        'state.estoque_min' => 'max:5',
        'state.preco' => 'required|max:10',

    ];

    protected $messages = [

        'state.descricao.required' => 'A descrição do produto é obrigatória.',
        'state.estoque.required' => 'O estoque do produto é obrigatório.',
        'state.preco.required' => 'O preço do produto é obrigatório.',

    ];

    public function mount()
    {
        $this->product_groups = Product_Group::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'ASC')
            ->get();
    }

    public function updatedSelectedGroup()
    {
        
    }

    public function confirmation()
    {

        $this->validate();
        $this->dispatchBrowserEvent('close-item-modal');
        $this->dispatchBrowserEvent('show-item-confirmation-modal');
    }

    public function resetNewOperation()
    {

        $this->dispatchBrowserEvent('close-item-modal');
        $this->reset('state');
    }

    public function resetOperation()
    {

        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->reset('state');
    }

    public function alternate()
    {

        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->dispatchBrowserEvent('show-item-modal');
    }

    public function save()
    {
        // ak

        $preco_formatado = str_replace(".", "", $this->state['preco']);
        $preco_formatado = str_replace(',', '.', $preco_formatado);

        Product::create([
            'descricao' => $this->state['descricao'],
            'preco' => $preco_formatado,
            'estoque' => $this->state['estoque'],
            'estoque_minimo' => $this->state['estoque_min'] ?? null,
            'user_id' => auth()->user()->id,
            'product_group_id' => $this->selectedGroup, 

        ]);

        $this->dispatchBrowserEvent('close-item-confirmation-modal');
        $this->reset('state');

        $this->emit('alert', 'Produto cadastrado com sucesso!');
        $this->emitTo('produto', 'render');
    }

    public function render()
    {
        return view('livewire.create-product');
    }
}

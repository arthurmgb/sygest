<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class CreateVenda extends Component
{

    public $produtos;
    public $foo;
    public $estoqueAtual;

    public function mount()
    {
        $this->produtos = Product::all();
    }

    public function updatedFoo()
    {
        if (!is_null($this->foo) and !empty($this->foo)) {
            $produto = Product::find($this->foo);
            $this->estoqueAtual = $produto->estoque;
        } else {
            $this->reset('estoqueAtual');
        }
    }

    public function render()
    {



        return view('livewire.create-venda');
    }
}

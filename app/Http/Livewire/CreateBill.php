<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Method;
use Livewire\Component;

class CreateBill extends Component
{
    public $state = [];

    // public $rules = [
    //     'state.tipo' => 'required',
    //     'state.descricao' => 'required|max:100',
    //     'state.categoria' => 'required',
    //     'state.total' => 'required|max:10',
    // ];

    public function mount()
    {
        $this->state['tipo'] = '1';
    }

    public function changeBillType()
    {
    }

    public function updated($field)
    {
        if ($field == 'state.tipo') {
            $this->emit('recriarSelect2');
        }
    }

    public function render()
    {
        $bill_categories = Category::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->where('tipo', $this->state['tipo'])
            ->orderBy('descricao', 'asc')
            ->get();

        $bill_methods = Method::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'asc')
            ->get();

        return view('livewire.create-bill', compact('bill_categories', 'bill_methods'));
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Method;
use Livewire\Component;
use Livewire\WithPagination;

class FormaPagamento extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search, $method;
    public $qtd = 10;
    protected $listeners = ['render'];

    public $rules = [

        'method.status' => 'required',
        'method.descricao' => 'required|max:100',
    ];

    protected $messages = [

        'method.status.required' => 'O status da forma de pagamento é obrigatório.',
        'method.descricao.required' => 'A descrição da forma de pagamento é obrigatória.',

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

    public function edit(Method $method)
    {
        if($method->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->method = $method;
    }

    public function update()
    {

        $this->method->save();
        $this->dispatchBrowserEvent('close-edit-confirmation-modal');
        $this->emit('alert', 'Forma de pagamento editada com sucesso!');
    }

    public function prepare(Method $method)
    {
        if($method->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->method = $method;
        $this->method['status'] = 3;
    }

    public function delete()
    {       
        $this->method->save();
        $this->dispatchBrowserEvent('close-delete-cat-confirmation-modal');
        $this->emit('alert', 'Forma de pagamento apagada com sucesso!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $formas_de_pagamento = Method::where('user_id', auth()->user()->id)
        ->where('descricao', 'like', '%' . $this->search . '%')
        ->whereIn('status', [0,1])
        ->latest('id')
        ->paginate($this->qtd);

        $formas_de_pagamento_count = Method::where('user_id', auth()->user()->id)
            ->whereIn('status', [0,1])
            ->count();

        return view('livewire.forma-pagamento', compact('formas_de_pagamento', 'formas_de_pagamento_count'))
        ->layout('pages.formas-pagamento');
    }
}

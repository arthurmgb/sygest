<?php

namespace App\Http\Livewire;

use App\Models\Client as ModelsClient;
use Livewire\Component;
use Livewire\WithPagination;

class Client extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $qtd = 10;
    public $search, $client;
    protected $listeners = ['render'];

    public $rules = [
        'client.nome' => 'required|max:100',
        'client.documento' => 'max:18|min:14',
        'client.rg' => 'max:18',
        'client.endereco' => 'max:100',
        'client.celular' => 'max:15|min:14',
        'client.email' => 'max:100',
        'client.obs' => 'max:500',
        'client.status' => 'required',
    ];

    protected $messages = [
        'client.nome.required' => 'O nome do cliente é obrigatório.',
    ];

    // EDIÇÃO

    public function edit(ModelsClient $client)
    {
        // Verificando se o dado pertence ao usuário logado
        if ($client->user_id != auth()->user()->id) {
            return redirect('404');
        }
        // ---

        $this->client = $client;
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

        foreach ($this->client->getAttributes() as $key => $value) {
            if (empty($value)) {
                $this->client->$key = null;
            }
        }

        $this->client->save();
        $this->dispatchBrowserEvent('close-item-edit-confirmation-modal');
        $this->emit('alert', 'Cliente editado com sucesso!');
    }

    // ---

    // DELEÇÃO

    public function prepareToDelete(ModelsClient $client)
    {

        // Verificando se o dado pertence ao usuário logado
        if ($client->user_id != auth()->user()->id) {
            return redirect('404');
        }
        // ---

        $this->client = $client;
        $this->client['status'] = 0;
    }

    public function delete()
    {
        $this->client->save();
        $this->dispatchBrowserEvent('close-delete-item-conf');
        $this->emit('alert', 'Cliente apagado com sucesso!');
    }

    // ---

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clients = ModelsClient::where('user_id', auth()->user()->id)
            ->where('nome', 'like', '%' . $this->search . '%')
            ->where('status', 1)
            ->latest('id')
            ->paginate($this->qtd);

        $clients_count = ModelsClient::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->count();

        return view('livewire.client', compact('clients', 'clients_count'))->layout('pages.clients');
    }
}

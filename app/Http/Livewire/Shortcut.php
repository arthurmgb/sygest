<?php

namespace App\Http\Livewire;

use App\Models\Shortcut as ModelsShortcut;
use Livewire\Component;

class Shortcut extends Component
{

    public $atalho;

    protected $listeners = ['render'];

    public $rules = [
        'atalho.descricao' => 'required|max:100',
        'atalho.url' => 'required',
        'atalho.cor' => 'string',
    ];

    protected $messages = [

        'atalho.descricao.required' => 'A descrição do link é obrigatória.',
        'atalho.url.required' => 'A URL do link é obrigatória.',

    ];

    public function edit(ModelsShortcut $atalho)
    {
        if($atalho->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->atalho = $atalho;
    }

    public function update()
    {
        $this->validate();
        $this->dispatchBrowserEvent('close-edit-modal');
        $this->atalho->save();
        $this->emit('alert', 'Link editado com sucesso!');
    }

    public function prepare(ModelsShortcut $atalho)
    {
        if($atalho->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->atalho = $atalho;
           
    }

    public function delete()
    {
        $this->atalho->delete();
        $this->dispatchBrowserEvent('close-delete-cat-confirmation-modal');
        $this->emit('alert', 'Link apagado com sucesso!');
    }

    public function updateLinkOrder($items){

        foreach($items as $item){
            ModelsShortcut::find($item['value'])->update(['position' => $item['order']]);
        }

    }

    public function render()
    {

        $shortcuts = ModelsShortcut::where('user_id', auth()->user()->id)
            ->orderBy('position', 'ASC')
            ->get();

        $shortcuts_count = ModelsShortcut::where('user_id', auth()->user()->id)
            ->count();

        return view('livewire.shortcut', compact('shortcuts', 'shortcuts_count'))
            ->layout('pages.atalhos');
    }
}

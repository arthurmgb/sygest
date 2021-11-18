<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Maintence;
use Livewire\Component;
use Livewire\WithPagination;

class Admin extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $estado_manutencao;
    public $qtd = 10;

    public function mount(){
        $manutencao = Maintence::find(1);
        $this->estado_manutencao = $manutencao->estado;
    }

    public function manutencao(){
        
        $manutencao = Maintence::find(1);

        if($manutencao->estado === 0){
            $manutencao->estado = 1;
        }elseif($manutencao->estado === 1){
            $manutencao->estado = 0;
        }

        $manutencao->save();
        
        $this->estado_manutencao = $manutencao->estado;

    }

    public function render()
    {

        $users = User::latest('last_login')
        ->paginate($this->qtd);

        $users_count = $users->count();

        return view('livewire.admin', compact('users', 'users_count'))
        ->layout('pages.administrador');
    }
}

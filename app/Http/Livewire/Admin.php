<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Admin extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $qtd = 10;

    public function render()
    {

        $users = User::orderBy('id', 'ASC')
        ->paginate($this->qtd);

        $users_count = $users->count();

        return view('livewire.admin', compact('users', 'users_count'))
        ->layout('pages.administrador');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Bill as ModelsBill;
use App\Models\Bill_Parcel;
use Livewire\Component;
use Livewire\WithPagination;

class Bill extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $qtd = 10;
    protected $listeners = ['render'];

    public function render()
    {

        $parcels = Bill_Parcel::where('user_id', auth()->user()->id)
            ->latest('id')
            ->paginate($this->qtd);

        $parcels_count = Bill_Parcel::where('user_id', auth()->user()->id)
            ->count();

        return view('livewire.bill', compact('parcels', 'parcels_count'))->layout('pages.bills');
    }
}

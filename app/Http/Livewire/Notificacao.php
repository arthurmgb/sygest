<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class Notificacao extends Component
{

    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $qtd = 10;
    public $ntf;
    public $select;

    public function mount(){
        $this->select = [0,1];
    }

    public function filter($id){
        $this->select = $id;
    }

    public function alternateMark($id){
        $this->ntf = $id;

        $get_ntf_to_alternate = Notification::find($this->ntf);

        if($get_ntf_to_alternate->user_id != auth()->user()->id){
            return redirect('404');
        }

        if($get_ntf_to_alternate->is_read == 1){

            $get_ntf_to_alternate->is_read = 0;

        }elseif($get_ntf_to_alternate->is_red == 0){

            $get_ntf_to_alternate->is_read = 1;

        }

        $get_ntf_to_alternate->save();
        $this->reset('ntf');
        $this->emitTo('bell', 'render');
        
    }

    public function readAll(){

       Notification::where('user_id', auth()->user()->id)
       ->where('is_read', 0)
       ->update(['is_read' => 1]);
       
       $this->emitTo('bell', 'render');

    }

    public function render()
    {
        $notificacoes = Notification::where('user_id', auth()->user()->id)->whereIn('is_read', $this->select)->latest('id')->paginate($this->qtd);

        $notificacoes_all = Notification::where('user_id', auth()->user()->id)->count();
        $notificacoes_read = Notification::where('user_id', auth()->user()->id)->where('is_read', 1)->count();
        $notificacoes_not_read = Notification::where('user_id', auth()->user()->id)->where('is_read', 0)->count();

        return view('livewire.notificacao', compact( 'notificacoes', 'notificacoes_all', 'notificacoes_not_read', 'notificacoes_read'))
        ->layout('pages.notificacoes');
    }
}

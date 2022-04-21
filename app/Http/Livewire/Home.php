<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Home extends Component
{
    
    public function doNotShowAgain($id){
        
        $find_user = User::find($id);
        $find_user->modal_start = 0;
        $find_user->save();
        
    }

    public function render()
    {

        $user_last_login = User::where('id', auth()->user()->id)
            ->value('last_login');


        $last_login = Carbon::parse($user_last_login)->format('d/m/Y H:i');

        $dia_atual = Carbon::now();

        $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $dia_atual);
        $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $user_last_login);

        $diferenca = $date2->diffInDays($date1);
        $tempo = 'dias';
        
        if ($diferenca === 1) {
            $diferenca = 'um';
            $tempo = 'dia';
        }
        
        if ($diferenca === 0) {
            $diferenca = $date2->diffInHours($date1);
            $tempo = 'horas';

            if ($diferenca === 1) {
                $diferenca = 'uma';
                $tempo = 'hora';
            }
        
            if ($diferenca === 0) {
                $diferenca = $date2->diffInMinutes($date1);
                $tempo = 'minutos';
        
                if ($diferenca === 1) {
                    $diferenca = 'um';
                    $tempo = 'minuto';
                }
        
                if ($diferenca === 0) {
                    $diferenca = 'poucos';
                    $tempo = 'segundos';
                }
            }
        }

        return view('livewire.home', compact('last_login', 'diferenca', 'tempo'))
            ->layout('home');
    }
}

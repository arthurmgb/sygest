<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Ferramenta extends Component
{

    public $numero1, $numero2, $op;
    public $a, $b, $c, $copy;
    public $p1, $p2;
    public $i1, $i2;
    public $mdl1, $mdl2;

    public function mount(){
        $this->op = 1;
        $this->copy = 0;
    }
  
    public function calc_simples($op){
        $this->op = $op;
    }

    public function copied($copied){
        if($copied == 1){
            $this->copy = 1;       
        }else{
            $this->copy = 0;
        }
    }

    public function reset_copy(){
        $this->reset('copy');
    }

    public function render()
    {

        //Calculadora Simples

        $numero1 = floatval($this->numero1);
        $numero2 = floatval($this->numero2);

        if($this->op == 1){
            $result = $numero1 + $numero2;
        }elseif($this->op == 2){
            $result = $numero1 - $numero2;       
        }elseif($this->op == 3){
            $result = $numero1 * $numero2;
        }elseif($this->op == 4){
            if($numero2 == 0){
                $result = '---';
            }else{
                $result = $numero1 / $numero2;
            }
        }

        //Fim Calculadora Simples

        //RD3

        $a = floatval($this->a);
        $b = floatval($this->b);
        $c = floatval($this->c);

        if($a == 0){
            $result_rd3 = 'X';            
        }else{
            $result_rd3 = $c*$b/$a;
        }

        //Fim RD3

        //Porcentagem

        $p1 = floatval($this->p1);
        $p2 = floatval($this->p2);

        $result_mult = $p1 * $p2;
        $result_percent = $result_mult/100;

        //Fim Porcentagem

        //Porcentagem inversa

        $i1 = floatval($this->i1);
        $i2 = floatval($this->i2);

        if($i2 == 0){
            $result_percent_i = '---';
        }else{
            $result_percent_i = $i1*100/$i2;
        }

        //Fim Porcentagem inversa

        //Margem de Lucro
        
        $mdl1 = floatval($this->mdl1);
        $mdl2 = floatval($this->mdl2);

        if($mdl2 > 100){
            $result_mdl = 'Não é possível lucrar mais que 100%.';
        }else{
            $mdl2 = $mdl2/100;
            $mdl2 = 1 - $mdl2;
    
            if($mdl2 == 0){
                $result_mdl = 'Não é possível lucrar 100%.';
            }else{
                $result_mdl = $mdl1/$mdl2;
            }
        }

        //Fim Margem de Lucro

        return view('livewire.ferramenta', compact('result', 'result_rd3', 'result_percent', 'result_percent_i', 'result_mdl'))
        ->layout('pages.ferramentas');
    }
}

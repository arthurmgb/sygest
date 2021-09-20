<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Navegador extends Component
{

    public $url;
    public $result_https;
    public $result_http;

    public function get_url(){

        $result_https = substr($this->url, 0, 8);
        $this->result_https = $result_https;
        $this->result_https = trim($this->result_https);

        $result_http = substr($this->url, 0, 7);
        $this->result_http = $result_http;
        $this->result_http = trim($this->result_http);

        if($this->result_https == 'https://'){

            $this->url = $this->url;

        }elseif($this->result_http == 'http://'){

            $this->url = $this->url;

        }elseif($this->result_https != 'https://' AND $this->result_http != 'http://'){

            if($this->result_https == '' AND $this->result_http == ''){
                $this->reset('url');
            }else{
                $this->url = 'https://' . $this->url;
            }
        }

    }

    public function reset_url(){
        return redirect()->to('/navegador');
    }

    public function render()
    {
        return view('livewire.navegador')
        ->layout('pages.navegador');
    }
}

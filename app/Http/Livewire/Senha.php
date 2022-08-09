<?php

namespace App\Http\Livewire;

use App\Models\Secret;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Senha extends Component
{
    protected $listeners = ['render'];
    public $locker;
    public $pass;
    public $data_pass;
    public $blur;
    public $secret_to_delete;
    public $pass_to_delete;
    public $data_pass_edit;
    public $pass_to_edit;

    public $rules = [
        'data_pass_edit.descricao' => 'required|max:100',
        'data_pass_edit.login' => 'max:100',
        'data_pass_edit.senha' => 'required|max:100',
    ];

    protected $messages = [

        'data_pass_edit.descricao.required' => 'A descrição da senha é obrigatória.',
        'data_pass_edit.senha.required' => 'É obrigatório definir uma senha.',

    ];

    public function mount(){
        $this->locker = 'locked';
        $this->blur = 'yes';
    }  

    public function authenticate(){

        if(!is_null($this->pass) and !empty($this->pass)){

            if (Hash::check($this->pass, auth()->user()->password)) {

                $this->locker = 'unlocked';
                $this->reset('pass');
                $this->emit('alert-unlocked', 'Bem-vindo ao Gerenciador de Senhas.');

            }
            else{
                $this->emit('alert-locked', 'Senha incorreta, tente novamente.');
            }

        }
       
    }

    public function lock(){
        $this->locker = 'locked';
        $this->emit('alert-blocked', 'Gerenciador bloqueado com sucesso.');
    }

    public function openFolder($id){

        $this->blur = 'yes';

        $this->data_pass = Secret::find($id);

        if($this->data_pass->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->dispatchBrowserEvent('open-secret-folder');
        
    }

    public function resetOpen(){
        
        $this->reset('data_pass');
        $this->blur = 'yes';
        $this->dispatchBrowserEvent('close-secret-folder');

    }

    public function toggleBlur(){

        if($this->blur == 'yes'){
            $this->blur = 'no';
        }elseif($this->blur == 'no'){
            $this->blur = 'yes';
        } 

    }

    public function showAlert(){

        $this->dispatchBrowserEvent('secret-copiado', ['message' => 'Copiado!']);

    }

    public function editSecret(Secret $data){

        $this->data_pass_edit = $data;

        if($this->data_pass_edit->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->dispatchBrowserEvent('edit-secret');

    }

    public function resetEdit(){

        $this->dispatchBrowserEvent('close-edit-secret');
        $this->reset('data_pass_edit');
        $this->blur = 'yes';

    }

    public function resetEditOnConfirmation(){

        $this->dispatchBrowserEvent('close-confirm-edit-secret');
        $this->reset('data_pass_edit');
        $this->reset('pass_to_edit');
        $this->blur = 'yes';
    
    }

    public function update(){

        $this->validate();
        $this->dispatchBrowserEvent('close-edit-secret');
        $this->dispatchBrowserEvent('confirm-edit-secret');

    }

    public function finishUpdate(){


        if(!is_null($this->pass_to_edit) and !empty($this->pass_to_edit)){

            if (Hash::check($this->pass_to_edit, auth()->user()->password)) {

                $this->data_pass_edit['descricao'] = trim($this->data_pass_edit['descricao']);
                $this->data_pass_edit['senha'] = trim($this->data_pass_edit['senha']);

                if(!isset($this->data_pass_edit['login']) or empty($this->data_pass_edit['login'])){

                    $this->data_pass_edit['login'] = null;

                }else{

                    $this->data_pass_edit['login'] = trim($this->data_pass_edit['login']);

                    if(empty($this->data_pass_edit['login'])){
                        $this->data_pass_edit['login'] = null;
                    }

                }

                $this->data_pass_edit->save();
                $this->dispatchBrowserEvent('close-confirm-edit-secret');
                $this->reset('data_pass_edit');
                $this->reset('pass_to_edit');
                $this->blur = 'yes';
                $this->emit('alert', 'Dados de senha editados com sucesso!');

            }
            else{
                $this->emit('alert-locked', 'Senha incorreta, tente novamente.');
            }

        }

    }

    public function deleteSecret($id){

        $check_user_auth = Secret::find($id);

        if($check_user_auth->user_id != auth()->user()->id){
            return redirect('404');
        }

        $this->dispatchBrowserEvent('delete-secret');
        $this->secret_to_delete = $id;

    }

    public function resetDelete(){

        $this->reset('secret_to_delete');
        $this->reset('pass_to_delete');
        $this->dispatchBrowserEvent('close-delete-secret');
        
    }

    public function delete(){


        if(!is_null($this->pass_to_delete) and !empty($this->pass_to_delete)){

            if (Hash::check($this->pass_to_delete, auth()->user()->password)) {

                $get_secret_to_delete = Secret::find($this->secret_to_delete);

                $get_secret_to_delete->delete();

                $this->dispatchBrowserEvent('close-delete-secret');
                $this->reset('secret_to_delete');
                $this->reset('pass_to_delete');
                $this->emit('alert', 'Dados de senha apagados com sucesso!');

            }
            else{
                $this->emit('alert-locked', 'Senha incorreta, tente novamente.');
            }

        }

    }

    public function render()
    {
  
        $secrets = Secret::where('user_id', auth()->user()->id)->latest('id')->get();

        $secrets_ct = Secret::where('user_id', auth()->user()->id)->count();

        return view('livewire.senha', compact('secrets', 'secrets_ct'))->layout('pages.senhas');
    }
}

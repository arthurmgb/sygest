<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class Tarefa extends Component
{

    public $inputTask;
    public $tasks = [];
    public $status = [];
    public $editedTaskIndex = null;

    public $rules = [
        'inputTask' => 'required',
    ];

    protected $messages = [

        'inputTask.required' => 'Qual o sentido de adicionar uma tarefa vazia? =D',
    ];

    public function mount(){
        
        $this->status = [0,1];

    }

    public function filter($filtro){

        
        $this->editedTaskIndex = null;
        $this->status = $filtro;

    }

    public function save(){

        $this->editedTaskIndex = null;

        $this->validate();

        Task::create([

            'descricao' => $this->inputTask,        
            'status' => 0,        
            'user_id' => auth()->user()->id

        ]);

        $this->reset('inputTask');

        $this->dispatchBrowserEvent('tarefa-criada', ['message' => 'Tarefa criada!']);

    }

    public function check($id){

        $tarefa = Task::find($id);

        if($tarefa->user_id != auth()->user()->id){
            return redirect('404');
        }
        
        if($tarefa->status == 0){

            $tarefa->update([
                'status' => 1,
            ]);

            $this->dispatchBrowserEvent('tarefa-concluida', ['message' => 'Tarefa concluída!']);

        }else{

            $tarefa->update([
                'status' => 0,
            ]);

            $this->dispatchBrowserEvent('tarefa-desmarcada', ['message' => 'Tarefa desmarcada!']);

        }

        
        
    }

    public function trash($id){

        $this->editedTaskIndex = null;

        $tarefa = Task::find($id);

        if($tarefa->user_id != auth()->user()->id){
            return redirect('404');
        }

        $tarefa->update([
            'status' => 3,
        ]);

        $this->dispatchBrowserEvent('tarefa-lixeira', ['message' => 'Tarefa movida para a lixeira!']);

    }

    public function delete($id){

        $tarefa = Task::find($id);

        if($tarefa->user_id != auth()->user()->id){
            return redirect('404');
        }

        $tarefa->delete();

        $this->dispatchBrowserEvent('tarefa-excluida', ['message' => 'Tarefa excluída!']);
        
    }

    public function restore($id){

        $tarefa = Task::find($id);

        if($tarefa->user_id != auth()->user()->id){
            return redirect('404');
        }

        $tarefa->update([
            'status' => 0,
        ]);

        $this->dispatchBrowserEvent('tarefa-restaurada', ['message' => 'Tarefa restaurada!']);

    }

    public function editTask($taskIndex){
        $this->editedTaskIndex = $taskIndex;
    }

    public function updateTask($taskIndex){

        $task = $this->tasks[$taskIndex] ?? NULL;

        if(empty($task['descricao']) or !strlen(trim($task['descricao']))){

            $this->editedTaskIndex = null;
            
        }
        else{
            
            if(!is_null($task)){

                $editedTask = Task::find($task['id']);

                if($editedTask->user_id != auth()->user()->id){
                    return redirect('404');
                }
    
                if($editedTask){
                    $editedTask->update($task);
                }
    
            }
    
            $this->editedTaskIndex = null;
            $this->dispatchBrowserEvent('tarefa-editada', ['message' => 'Tarefa editada!']);

        }
  
    }

    public function resetTask(){
        $this->editedTaskIndex = null;
    }

    public function resetValidationTask(){
        $this->resetValidation();
    }

    public function updateTaskOrder($items){
        
        $this->editedTaskIndex = null;
       
        foreach($items as $item){
            Task::find($item['value'])->update(['position' => $item['order']]);
        }

        $this->dispatchBrowserEvent('tarefa-movida', ['message' => 'Posição alterada!']);

    }

    public function render()
    {
        $this->tasks = Task::where('user_id', auth()->user()->id)
        ->whereIn('status', $this->status)
        ->orderBy('position', 'ASC')
        ->get()->toArray();

        $tasks_count = Task::where('user_id', auth()->user()->id)
        ->whereIn('status', [0,1])
        ->count();

        $pendentes = Task::where('user_id', auth()->user()->id)
        ->whereIn('status', [0])
        ->count();

        $concluidas = Task::where('user_id', auth()->user()->id)
        ->whereIn('status', [1])
        ->count();

        $lixeira = Task::where('user_id', auth()->user()->id)
        ->whereIn('status', [3])
        ->count();

        return view('livewire.tarefa', [
            'tasks' => $this->tasks, 
            'tasks_count' => $tasks_count, 
            'pendentes' => $pendentes,
            'concluidas' => $concluidas,
            'lixeira' => $lixeira,
            ])
        ->layout('pages.tarefas');
    }

    public function deleteAll(){

        $tarefas = Task::query()
        ->where('user_id', auth()->user()->id)
        ->where('status', '=', 3)
        ->delete();

        $this->dispatchBrowserEvent('close-delete-all-confirmation-modal');
        $this->dispatchBrowserEvent('tarefa-excluida', ['message' => 'Lixeira esvaziada!']);
        
    }
}

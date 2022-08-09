<div>
    
    <div class="page-header d-flex flex-row align-items-center mb-2">
        <h2 class="f-h2">Minhas tarefas</h2>
        <span class="f-span">{{$tasks_count}} tarefas cadastradas</span>
    </div>

    <div class="block">

        <div class="add-tasks">
            <div style="margin-bottom: 20px !important; padding: 16px !important; border-bottom-left-radius: 0 !important;" class="card">
                <div class="d-flex flex-row align-items-center">
                    <input wire:model.defer="inputTask" wire:keydown.enter="save()" placeholder="Digite sua tarefa..." type="text" class="input-tarefas" autocomplete="off">
                    <button wire:loading.class="pe-none" wire:target="save" wire:click.prevent="save()" style="height: 45px;" class="btn btn-new ml-2">
                        <span wire:loading.remove wire:target="save">Adicionar</span>
                        <span wire:loading wire:target="save">
                            <i style="color: #fff; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-2x fa-spin"></i>
                        </span>                     
                    </button>
                </div>
                @error('inputTask')
                    <div class="d-flex flex-row align-items-center">
                        <span class="wire-error mt-2">{{ $message }}</span>
                        <span wire:loading.class="pe-none" wire:target="resetValidationTask" class="ml-2" wire:click="resetValidationTask()">
                            <i class="fad fa-times-circle fac-reset"></i>
                        </span>
                    </div>
                @enderror
            </div>
            <div class="filter-block d-flex flex-row">
                <div class="card card-filter" style="white-space: nowrap;">
                    <div class="d-inline-flex align-items-center justify-content-start">
                                            
                        <i wire:loading.class="pe-none" wire:target="filter" wire:click="filter([0,1])" style="color: #448DE2;" class="fas fa-thumbtack mr-2 filter-icon"></i>
                        <span wire:loading.class="pe-none" wire:target="filter" wire:click="filter([0,1])" class="mr-4 filter-text @if($status == [0,1]) marked @endif">Todas ({{$tasks_count}})</span>
                        
                        <i wire:loading.class="pe-none" wire:target="filter" wire:click="filter([0])" style="color: #CC9214;" class="fad fa-exclamation-circle mr-2 filter-icon"></i>
                        <span wire:loading.class="pe-none" wire:target="filter" wire:click="filter([0])" class="mr-4 filter-text @if($status == [0]) marked @endif">Pendentes ({{$pendentes}})</span>

                        <i wire:loading.class="pe-none" wire:target="filter" wire:click="filter([1])" style="color: #00A3A3;" class="fad fa-check-circle mr-2 filter-icon"></i>
                        <span wire:loading.class="pe-none" wire:target="filter" wire:click="filter([1])" class="mr-4 filter-text @if($status == [1]) marked @endif">Concluídas ({{$concluidas}})</span>

                        <i wire:loading.class="pe-none" wire:target="filter" wire:click="filter([3])" style="color: #E6274C;" class="fad fa-trash mr-2 filter-icon"></i>
                        <span wire:loading.class="pe-none" wire:target="filter" wire:click="filter([3])" class="mr-0 filter-text @if($status == [3]) marked @endif">Lixeira ({{$lixeira}})</span>

                    </div>
                </div>
                <div class="loading-spinners">
                    <span class="ml-2" wire:loading wire:target="filter">
                        <i style="color: #725BC2; opacity: 90%; margin-top: -24px; position: absolute;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                    </span>
                    <span class="ml-2" wire:loading wire:target="trash">
                        <i style="color: #E6274C; opacity: 90%; margin-top: -24px; position: absolute;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                    </span>                       
                    <span class="ml-2" wire:loading wire:target="restore">
                        <i style="color: #448DE2; opacity: 90%; margin-top: -24px; position: absolute;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                    </span>
                </div>
                @if($status == [3] and count($tasks))
                <div class="delete-all ml-auto">
                    <button data-toggle="modal" data-target="#delete-all-confirmation" class="delete-all-btn">
                        <i style="font-size: 14px;" class="fad fa-trash fa-fw fa-crud mr-1"></i>Esvaziar lixeira
                    </button>
                </div>
                @endif
            </div>
        </div>

        @if (count($tasks))

        <div class="tasks" wire:sortable="updateTaskOrder">

            @foreach ($tasks as $index => $task)
            <div style="margin-bottom: 10px !important; padding: 15px !important;" class="card card-tarefa" wire:sortable.item="{{ $task['id'] }}" wire:key="task-{{ $task['id'] }}">
                <div class="single-task d-flex flex-row align-items-center justify-content-start">

                    <div class="mover-tarefa mr-3 ml-0 mt-1" wire:sortable.handle>
                        <i class="far fa-arrows fa-lg fa-fw"></i>
                    </div>

                    @if ($task['status'] != 3)
                    <input wire:click="check({{$task['id']}})" @if ($task['status'] == 1) checked @endif type="checkbox" id="tarefa-{{$task['id']}}" name="tarefa-{{$task['id']}}">
                    <label for="tarefa-{{$task['id']}}"></label>
                    @endif

                    @if ($task['status'] == 3)
                    <i class="fad fa-times-circle fa-fw fa-crud fac-times"></i>
                    @endif
                    
                    @if($editedTaskIndex !== $index)
                        <span 
                        @if($task['status'] != 3) wire:click.prevent="editTask({{$index}})" @endif
                        @if($task['status'] == 3) style="user-select: none;" @endif
                        @if($task['status'] != 3) data-flow="top" data-tooltip="Editar" @endif
                        class="wrap-task @if($task['status'] != 3) ml-3 mt-1 @endif 
                        @if($task['status'] == 1)task-checked @elseif($task['status'] == 3)task-deleted @else span-task @endif">

                        {!! nl2br(e($task['descricao'])) !!} 

                        </span> 
                    @else  
                    
                    <textarea style="resize: none; height: 100%;" class="input-task-edit ml-3 yampay-scroll" wire:model.defer="tasks.{{$index}}.descricao" rows="3" autocomplete="off"></textarea>

                    <button wire:loading.class="pe-none" wire:target="updateTask" style="height: 35px;" wire:click.prevent="updateTask({{$index}})" class="btn btn-new ml-2 mr-1">
                        <span wire:loading.remove wire:target="updateTask">
                            Salvar
                        </span>
                        <span wire:loading wire:target="updateTask">
                            <i style="color: #fff; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                        </span>
                    </button> 
                    <button wire:loading.class="pe-none" wire:target="resetTask" style="height: 35px;" wire:click.prevent="resetTask()" class="btn-cancel-task mr-2">
                        <span wire:loading.remove wire:target="resetTask">
                            Cancelar
                        </span>
                        <span wire:loading wire:target="resetTask">
                            <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                        </span>
                    </button> 

                    @endif
                    
                    <div style="white-space: nowrap;" class="task-trash ml-auto">
                        @if ($task['status'] == 3)
                        <div wire:click="delete({{$task['id']}})" wire:loading.class="pe-none" style="user-select: none;" class="lixeira d-flex flex-row mx-2 mb-2">
                            <i class="fad fa-trash fa-fw fa-crud fac-del mr-1"></i>
                            <span class="lixeira-text">Excluir permanentemente</span>
                        </div> 
                        <div wire:click="restore({{$task['id']}})" wire:loading.class="pe-none" style="user-select: none;" class="lixeira d-flex flex-row mx-2">
                            <i class="fad fa-trash-undo fa-fw fa-crud fac-rest mr-1"></i>
                            <span class="restore-text">Restaurar tarefa</span>
                        </div>
                        @else
                        <div wire:click="trash({{$task['id']}})" wire:loading.class="pe-none" style="user-select: none;" class="lixeira d-flex flex-row mx-2">
                            <i class="fad fa-trash fa-fw fa-crud fac-del mr-1"></i>
                            <span class="lixeira-text">Lixeira</span>                          
                        </div> 
                        @endif                                      
                    </div>   

                </div>                           
            </div>  
            @endforeach

        </div>
        
        @else

        <div class="card">
            <div wire:target="render, search, qtd, updatingSearch" wire:loading.remove class="card-body px-0 pb-0">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="211"
                        height="145">
                        <style>
                            <![CDATA[
                            .B {
                                fill: #fff
                            }

                            .C {
                                stroke-linecap: round
                            }

                            .D {
                                stroke-width: 1.395
                            }

                            .E {
                                stroke: #a4afb7
                            }

                            .F {
                                fill-rule: nonzero
                            }

                            .G {
                                stroke-linejoin: round
                            }

                            .H {
                                fill: #d5dadf
                            }

                            ]]>
                        </style>
                        <g fill="none" fill-rule="evenodd">
                            <path
                                d="M53.803 136.846h122.8m3.907 0h5.58m-141.207 0h5.58m138.977 0h1.674m-150.696 0h1.674"
                                class="C D E" />
                            <path d="M121.264 47.475c6.093 1.704 9.14 3.238 9.14 4.603" stroke="#170040"
                                class="C D G" />
                            <path
                                d="M3.093 132.455l-.3-33.292L1 98.633v-12.7l42.558-4.92 42.558 4.92v12.7l-1.783.53-.3 33.292-40.465 9.003z"
                                class="D E H" />
                            <path fill-opacity=".5" fill="#c2cbd2"
                                d="M1 86.62l42.558-4.92v62.122l-40.465-7.31-.3-37.35L1 98.633z" />
                            <g class="D E H">
                                <path d="M3.093 136.513l-.3-37.35 40.775 5.6 40.775-5.6-.3 37.35-40.465 7.607z" />
                                <path d="M1 98.633V86.41l42.558 5.088 42.558-5.088v12.224l-42.558 6.12z" />
                            </g>
                            <path fill-opacity=".5"
                                d="M83.508 113.56v-13.6l-34.92 4.804zm1.9-26.454l-41.18 5.1.1 11.74 41.08-5.85z"
                                fill="#c2cbd2" />
                            <g class="D E">
                                <path d="M43.558 91.497v52.326" />
                                <g class="B F">
                                    <path
                                        d="M76.532 65.72c-6.107 5.778-16.427 9.333-18.62 13.24-1.628 2.9-2.144 7.78-1.874 11.144 3.335-.325 4.11-.45 6.436-.838-.273-3.572.4-5.742 1.16-6.798 2.537-3.484 18.037-7.733 18.303-11"
                                        class="C G" />
                                    <path
                                        d="M141.144 29.827L89.04 29.01c-3.54-.056-6.93 1.425-9.295 4.06l-2.888 3.216c-.724.806-1.365 1.684-1.912 2.62-1.976 3.378-2.985 5.908-3.04 7.53-.703 20.954-.858 36.17-.467 45.636.178 4.308.765 8.13 1.76 11.47a16.05 16.05 0 0 0 15.38 11.469h59.993a16.05 16.05 0 0 0 16.046-16.046v-49.83c0-6.943-4.466-13.1-11.066-15.254l-12.41-4.05z" />
                                </g>
                            </g>
                            <rect x="70.332" y="28.22" width="81.73" height="81.882" rx="21.767"
                                class="B F" />
                            <g class="D E B F">
                                <rect x="71.03" y="28.917" width="80.334" height="80.487" rx="16.744" />
                                <g class="C G">
                                    <use xlink:href="#B" />
                                    <use xlink:href="#B" x="-23.441" />
                                </g>
                            </g>
                            <rect fill-opacity=".7" fill="#e6e9ec" x="75.291" y="32.893" width="71.86"
                                height="71.86" rx="11.498" class="F" />
                            <path
                                d="M97.123 72.242c0 1.8-2.25 3.28-5.023 3.28s-5.023-1.47-5.023-3.28 2.25-3.28 5.023-3.28 5.023 1.47 5.023 3.28m23.44 0c0 1.8 2.25 3.28 5.023 3.28s5.023-1.47 5.023-3.28-2.25-3.28-5.023-3.28-5.023 1.47-5.023 3.28"
                                class="H" />
                            <g class="D E">
                                <path
                                    d="M94.325 70.656c2.986 0 5.733-2.328 5.733-5.877s-2.328-5.654-5.315-5.654-5.5 2.547-5.5 6.095 2.094 5.436 5.08 5.436z"
                                    class="B" />
                                <path d="M94.08 62.234c-.772 1.904-.772 3.548 0 4.932" class="C" />
                                <path
                                    d="M123.592 70.656c-2.986 0-5.733-2.328-5.733-5.877s2.328-5.654 5.315-5.654 5.5 2.547 5.5 6.095-2.094 5.436-5.08 5.436z"
                                    class="B" />
                                <path d="M123.838 62.234c.772 1.904.772 3.548 0 4.932" class="C" />
                                <g class="B">
                                    <path
                                        d="M172.708 136.447h-7.356l-1.266-2.218-6.018-10.082-.083-.154c-.895-1.75-.653-3.892 1.096-4.788.14-.072.285-.133.434-.184a3.23 3.23 0 0 1 3.919 1.606c.044.088.102.226.173.414l2.072 6.425c-.09-.562-.566-4.083-1.427-10.565a4.38 4.38 0 0 1 3.985-4.737 4.34 4.34 0 0 1 .558-.012l.25.01c2.464.103 4.378 2.184 4.275 4.647-.003.084-.01.167-.018.25l-1.914 14.53c.024.8.697-1.637 2.02-7.308a2.66 2.66 0 0 1 3.782-1.39c1.49.83 1.588 2.23.763 3.724l-5.247 9.83z" />
                                    <path
                                        d="M161.104 130.992c3.01 0 5.462 2.38 5.577 5.362l.003.218h-11.162c.001-3.01 2.382-5.46 5.362-5.576l.22-.004z" />
                                </g>
                                <ellipse fill="#a4afb7" cx="108.789" cy="83.823" rx="5.233" ry="6.977" />
                                <g class="B">
                                    <path
                                        d="M108.8 81.023c2.9 0 4.255-.993 4.06-1.342-.96-1.73-2.422-2.834-4.06-2.834-1.594 0-3.022 1.046-3.982 2.695-.155.267 1.092 1.48 3.982 1.48z" />
                                    <path
                                        d="M158.6 79.778c5.473 3.196 11.174 10.04 14.06 9.766 5.987-.57 6.628-9.173 7.166-17.228.674-10.082 6.255 1.37 9.17-5.638 1.505-3.617-5.528-7.05-9.17-5.5s-4.14 4.532-4.494 7.385c-.233 1.87-1.567 13.905-2.98 13.743-2.796-.32-9.738-10.83-13.75-11.65"
                                        class="C F G" />
                                </g>
                                <path
                                    d="M194.848 50.46c4.93 2.962 7.9 7.255 8.917 12.88m-.695-12.957c.56.286 4.166 2.128 4.5 6.606"
                                    class="C" />
                            </g>
                            <path d="M85.828 39.033c-2.26 1.377-3.86 3.128-4.802 5.253" stroke="#fff"
                                stroke-width="3.349" class="C" />
                            <circle cx="79.408" cy="49.399" r="1.326" class="B" />
                            <g class="D E">
                                <g class="C">
                                    <path
                                        d="M96.774 47.475c-6.093 1.704-9.14 3.238-9.14 4.603m34.884-4.603c6.093 1.704 9.14 3.238 9.14 4.603"
                                        class="G" />
                                    <path
                                        d="M23.195 55.836c.46 3.045 2.795 1.956 3.087 1.774 1.88-1.173 3.03-1.663 4.342-.56 2.022 1.7-1.555 4.872.66 6.486 2.658 1.937 3.704-3.687 6.936-1.772S36.7 67.4 42.388 67.9M49.52 2.425c2.207.194 4.164 1.2 4.164 3.22 0 2.44-4.174 2.955-3.376 5.577.957 3.146 4.952-.44 5.836 3.482s-7.248 3.923-1.817 7.837" />
                                </g>
                                <g class="B">
                                    <path
                                        d="M47.182 41.33l9.2 2.19a.35.35 0 0 1 .166.586l-7 7a.35.35 0 0 1-.586-.166l-2.19-9.2a.35.35 0 0 1 .42-.42z" />
                                    <circle cx="28.907" cy="32.893" r="4.884" />
                                </g>
                            </g>
                        </g>
                        <defs>
                            <path id="B"
                                d="M123.276 112.706l.55 18.708h-1.3c-1.432 0-2.593 1.16-2.593 2.593s1.16 2.593 2.593 2.593h4.065a3.49 3.49 0 0 0 3.49-3.49c0-.594-1.432-9.597-1.126-20.405" />
                        </defs>
                    </svg>
                    @php

                        if($status == [0,1]){
                            $tipo_tarefa = 'tarefas';
                            $local_tarefa = 'a serem exibidas';
                        }elseif($status == [0]){
                            $tipo_tarefa = 'tarefas pendentes';
                            $local_tarefa = 'a serem exibidas';
                        }elseif($status == [1]){
                            $tipo_tarefa = 'tarefas concluídas';
                            $local_tarefa = 'a serem exibidas';
                        }elseif($status == [3]){
                            $tipo_tarefa = 'tarefas';
                            $local_tarefa = 'na lixeira';
                        }

                    @endphp
                    <h3 class="my-4 no-results">Não há {{$tipo_tarefa}} {{$local_tarefa}}.</h3>
                    <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                        <h3 style="font-size: 28px;" class="no-results-create mb-3">Suas tarefas serão exibidas aqui!</h3>          
                    </div>
                </div>
            </div>
        </div>

        @endif
            
        <div style="user-select: none; padding-bottom: 150px;"
            class="d-flex flex-row align-items-center justify-content-between">
        </div>

    </div>

    <!-- Modal Deletar Confirmação -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="delete-all-confirmation" tabindex="-1"
        aria-labelledby="delete-all-confirmationLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="delete-all-confirmationLabel">Confirmação de exclusão</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente esvaziar a lixeira?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            Ao clicar em <span class="msg-bold">Confirmar</span>, todas as tarefas da lixeira serão excluídas.
                        </p>
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="deleteAll()" type="button"
                        class="btn btn-send">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

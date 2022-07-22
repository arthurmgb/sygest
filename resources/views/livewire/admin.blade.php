<div>

    <div class="page-header d-flex flex-row align-items-center justify-content-between mb-2">
        @if(auth()->user()->is_admin === 1)
        <h2 class="f-h2">Área administrativa</h2>
        <div class="div-right-admin">
            <a href="{{route('register')}}" class="btn btn-new">+ Novo usuário</a>
            @if ($estado_manutencao == 0)
            <button wire:key="manut-active" wire:click.prevent="manutencao" wire:loading.attr="disabled" class="btn btn-new">Ativar manutenção</button>
            @elseif($estado_manutencao == 1)
            <button wire:key="manut-disabled" wire:click.prevent="manutencao" wire:loading.attr="disabled" class="btn-maint">Desativar manutenção</button>
            @endif
        </div>
        @else
        <h2 class="f-h2">Área restrita</h2>
        @endif
    </div>

    <div class="block">

        @if(auth()->user()->is_admin === 1)

        {{-- ÁREA USERS E CONTRATOS --}}
        <div class="div-block-area-1 mb-4">

            <div class="admin-area">

                <div class="card">
                    
                    <div class="topo-ico d-flex flex-row align-items-center mb-1">
                        <i style="color: #725BC2;" class="fad fa-users fa-fw fa-lg mr-2"></i>
                        <div class="card-topo">
                            <div style="margin-bottom: 0 !important;" class="title-block f-calc">                                                                        
                                Usuários cadastrados
                                <span class="period">/ Quantidade: {{$users_count}}</span>
                            </div>                     
                        </div>
                        <div class="dropdown" wire:key="drop1">
                            <button style="padding: 5px 5px; color: #666;" class="btn btn-sm btn-light ml-2 rounded-circle" type="button" id="drop_details1" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-fw fa-lg"></i>
                            </button>
                            <div style="padding: 20px !important; width: 350px !important; max-width: 350px !important; min-width: 350px !important;" class="dropdown-menu text-uppercase" aria-labelledby="drop_details1">                        
                                <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Total de contratos cadastrados: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #725BC2;">
                                    {{$all_contratos}}
                                </span>
                                </span><br>
                                <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Total de contratos ativos: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #16a34a;">
                                    {{$ativos_contratos}}
                                </span>
                                </span><br>
                                <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Total de contratos inativos: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #dc2626;">
                                    {{$inativos_contratos}}
                                </span>
                                </span><br>
                                <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Total de contratos cancelados: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #4b5563;">
                                    {{$cancelados_contratos}}
                                </span>
                                </span><br>
                            </div>
                        </div> 
                    </div>

                    <div class="card-topo mt-3 mb-2">
                        <input wire:model="search" placeholder="buscar usuário" class="search-input" autocomplete="off">
                        <i class="fa fa-search"></i>
                    </div>
                
                    <div wire:target="qtd, search" style="margin-top: 125px; margin-bottom: 125px;"
                        wire:loading wire:loading.class="d-flex flex-row align-items-center justify-content-center">
                        <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-3x fa-spin"></i>
                    </div>

                    <div wire:target="qtd, search" wire:loading.remove class="card-body px-0 pb-0 table-responsive yampay-scroll">

                        @if($users->count())
        
                            <table style="cursor: default; white-space: nowrap; user-select: none;" class="table table-borderless mb-2">
                                <thead class="t-head">
                                    <tr class="t-head-border">
                                        <th>ID #</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>CPF/CNPJ</th>
                                        <th>Cidade e Estado</th>
                                        <th>Banco/Instituição</th>
                                        <th>Chave PIX</th>                                      
                                        <th>Qtd. de operações</th>
                                        <th>Data de criação</th>                                 
                                        <th>Último login</th>
                                        <th>Contratos</th>
                                        <th>Situação</th>                                       
                                        <th>Acesso</th>
                                        <th>Conta</th>
                                    </tr>
                                </thead>
                                <tbody class="t-body">
        
                                    @php
                                        $dia_atual = Carbon\Carbon::now();
                                    @endphp
        
                                    @foreach ($users as $user)
                                
                                        @php
                                            //Data de criação

                                            $data_criacao = $user->created_at->format('d/m/Y H:i');
                                            $ultimo_login = date('d/m/Y H:i', strtotime($user->last_login));
                                            
                                            $date1 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dia_atual);
                                            $date2 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);
                                            
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
                                                                                        
                                        @endphp

                                        @php
                                            //Último login

                                            $date1_log = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dia_atual);
                                            $date2_log = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->last_login);
                                            
                                            $diferenca_log = $date2_log->diffInDays($date1_log);
                                            $tempo_log = 'dias';
                                            
                                            if ($diferenca_log === 1) {
                                                $diferenca_log = 'um';
                                                $tempo_log = 'dia';
                                            }
                                            
                                            if ($diferenca_log === 0) {
                                                $diferenca_log = $date2_log->diffInHours($date1_log);
                                                $tempo_log = 'horas';
        
                                                if ($diferenca_log === 1) {
                                                    $diferenca_log = 'uma';
                                                    $tempo_log = 'hora';
                                                }
                                            
                                                if ($diferenca_log === 0) {
                                                    $diferenca_log = $date2_log->diffInMinutes($date1_log);
                                                    $tempo_log = 'minutos';
                                            
                                                    if ($diferenca_log === 1) {
                                                        $diferenca_log = 'um';
                                                        $tempo_log = 'minuto';
                                                    }
                                            
                                                    if ($diferenca_log === 0) {
                                                        $diferenca_log = 'poucos';
                                                        $tempo_log = 'segundos';
                                                    }
                                                }
                                            }
                                        @endphp                                   
        
                                        <tr @if ($user->is_blocked == 1) style="border: 2px solid #fca5a5 !important;" @endif class="tr-hover">

                                            <td style="color: #1d4ed8;" class="align-middle font-weight-bolder">{{ $user->id }}</td>
                                            <td class="align-middle font-desc">{{ $user->name }}</td>
                                            <td style="user-select: text;" class="align-middle">{{ $user->email }}</td>
                                            <td style="user-select: text;" class="align-middle">
                                                @if (empty($user->documento))
                                                    <span style="color: #725BC2; font-weight: 500;">Não cadastrado</span>
                                                @else
                                                    {{ $user->documento }}
                                                @endif                                              
                                            </td>
                                            <td style="user-select: text;" class="align-middle">
                                                @if (empty($user->cidade) or empty($user->estado))
                                                    <span style="color: #725BC2; font-weight: 500;">Não cadastrados</span>
                                                @else
                                                    {{ $user->cidade }} - {{ $user->estado }}
                                                @endif                             
                                            </td>
                                            <td style="user-select: text;" class="align-middle">
                                                @if (empty($user->banco))
                                                <span style="color: #725BC2; font-weight: 500;">Não cadastrado(a)</span>
                                                @else
                                                    {{ $user->banco }}
                                                @endif 
                                            </td>
                                            <td style="user-select: text;" class="align-middle">
                                                @if (empty($user->chave_pix))
                                                <span style="color: #725BC2; font-weight: 500;">Não cadastrada</span>
                                                @else
                                                    {{ $user->chave_pix }}
                                                @endif 
                                            </td>                                       
                                            <td style="font-size: 14px; font-weight: 500; color: #725BC2;" class="align-middle">
                                                @if ($user->operations->count() === 0)
                                                    Nenhuma
                                                @else
                                                {{ $user->operations->count() }}                                            
                                                @endif
                                            </td>
                                            
                                            <td class="align-middle">{{ $data_criacao }}<br>
                                                <span class="g-light">há {{ $diferenca }} {{ $tempo }}</span>
                                            </td>

                                            <td class="align-middle">
                                                <span style="font-size: 11px;" class="operacao-entrada text-nowrap">{{ $ultimo_login }}</span><br>
                                                <div class="mt-1">
                                                    <span class="g-light">há {{ $diferenca_log }} {{ $tempo_log }}</span>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <button wire:click.prevent="openContracts({{$user->id}})" wire:target="openContracts({{$user->id}})" wire:loading.attr="disabled" data-toggle="modal" data-target="#showContracts" type="button" class="btn btn-new">
                                                    <i class="fad fa-file-signature fa-fw fa-lg mr-1"></i> Abrir
                                                </button>
                                            </td>

                                            <td class="align-middle">
                                                <div class="div-span-center">                                            
                                                    @if ($user->is_blocked == 0)
                                                        <span style="font-size: 11px" class="operacao-entrada text-nowrap">
                                                            Ativo
                                                        </span>
                                                    @elseif ($user->is_blocked == 1)
                                                        <span style="font-size: 11px" class="operacao-saida text-nowrap">
                                                            Bloqueado
                                                        </span>
                                                    @endif
                                                </div>                                                     
                                            </td>                                           

                                            <td class="align-middle">
                                                @if ($user->is_blocked == 0)
                                                    <button wire:target="acesso({{$user->id}})" wire:loading.attr="disabled" wire:click.prevent="acesso({{$user->id}})" type="button" class="btn btn-bloquear"><i class="fad fa-lock fa-fw mr-1"></i>Bloquear</button>
                                                @elseif ($user->is_blocked == 1)
                                                    <button wire:target="acesso({{$user->id}})" wire:loading.attr="disabled" wire:click.prevent="acesso({{$user->id}})" type="button" class="btn btn-desbloquear"><i class="fad fa-lock-open-alt fa-fw mr-1"></i>Desbloquear</button>
                                                @endif
                                            </td>

                                            <td class="align-middle">
                                                
                                                <button wire:key="delUser{{$user->id}}" wire:target="deletarUser({{$user->id}})" wire:loading.attr="disabled" wire:click.prevent="deletarUser({{$user->id}})" type="button" class="btn btn-bloquear"><i class="fad fa-trash fa-fw mr-1"></i>Deletar</button>
                                                
                                            </td>
                                                
                                        </tr>
        
                                    @endforeach
        
                                </tbody>
                            </table>
        
                        @else
        
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
                                        <rect x="70.332" y="28.22" width="81.73" height="81.882" rx="21.767" class="B F" />
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
                                <h3 class="my-4 no-results">Não há usuários a serem exibidos.</h3>
                                <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                                    <h3 class="no-results-create mb-3">Comece cadastrando um</h3>
                                    <a href="{{route('register')}}" class="ml-2 btn btn-nr">+ Novo usuário</a>
                                </div>
                            </div>
        
                        @endif
        
                    </div>

                </div>
            </div>
            <div class="resultados d-flex flex-row align-items-center justify-content-between">
                <div class="div-show-more-results d-flex flex-row align-items-center">
                    <select wire:model="qtd" class="form-control modal-input-cat rpp">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                    <span class="ml-3 ipp">Itens por página</span>
                </div>
                @if ($users->hasPages())
                    <div class="paginacao">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
            
        </div>
        {{-- ÁREA USERS E CONTRATOS --}}

        {{-- ÁREA MENSALIDADES--}}
        <div class="div-block-area-2 mb-4">

            <div class="admin-area">

                <div class="card">
                    
                    <div class="topo-ico d-flex flex-row align-items-center mb-1">
                        @if($modalidade_mensalidade === 1)
                            <i style="color: #16a34a;" class="fad fa-money-bill-alt fa-fw fa-lg mr-2"></i>
                            <div class="card-topo mr-2">
                                <div style="margin-bottom: 0 !important;" class="title-block f-calc">                                                           
                                    Mensalidades à vencer
                                    <span class="period">/ Quantidade: {{$get_mensalidades_a_vencer}}</span>
                                </div>                     
                            </div>
                            <button wire:key="btn1" wire:click.prevent="alternarModalidade(0)" wire:loading.attr="disabled" class="btn btn-sm btn-outline-danger ml-2 p-1" data-tooltip="Mensalidades vencidas" data-flow="top">
                                <i class="fas fa-sort-alt fa-fw fa-lg"></i>
                            </button>
                        @elseif($modalidade_mensalidade === 0)
                            <i style="color: #dc2626;" class="fad fa-money-bill-alt fa-fw fa-lg mr-2"></i>
                            <div class="card-topo mr-2">
                                <div style="margin-bottom: 0 !important;" class="title-block f-calc">                                                           
                                    Mensalidades vencidas
                                    <span class="period">/ Quantidade: {{$get_mensalidades_vencidas}}</span>
                                </div>                     
                            </div>
                            <button wire:key="btn2" wire:click.prevent="alternarModalidade(1)" wire:loading.attr="disabled" class="btn btn-sm btn-outline-success ml-2 p-1" data-tooltip="Mensalidades à vencer" data-flow="top">
                                <i class="fas fa-sort-alt fa-fw fa-lg"></i>
                            </button>
                        @endif
                        <div class="dropdown" wire:key="drop2">
                            <button style="padding: 5px 5px; color: #666;" class="btn btn-sm btn-light ml-2 rounded-circle" type="button" id="drop_details2" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-fw fa-lg"></i>
                            </button>
                            <div style="padding: 20px !important; width: 400px !important; max-width: 400px !important; min-width: 400px !important;" class="dropdown-menu text-uppercase" aria-labelledby="drop_details2">                        
                                <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Total de mensalidade à vencer: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #725BC2;">
                                    R$ {{$get_total_mensalidades_a_vencer}}
                                </span>
                                </span><br>
                                <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Total de mensalidades vencidas: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #dc2626;">
                                    R$ {{$get_total_mensalidades_vencidas}}
                                </span>
                                </span><br>
                                <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Total geral à receber: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #16a34a;">
                                   R$ {{$get_total_geral_a_receber}}
                                </span>
                                </span><br>
                            </div>
                        </div> 
                    </div>

                    @if ($get_mensalidades_vencidas > 0 and $modalidade_mensalidade === 1)
                        <div class="div-ntf-mensalidades-vencidas">
                            <span style="font-size: 14px;"><span style="color: red; font-weight: 500;">ATENÇÃO: </span>Existem mensalidades vencidas, alterne a aba para visualizar.</span>
                        </div>
                    @endif  

                    <div class="card-topo mt-3 mb-2">
                        <input type="number" wire:model="search_mensalidade" placeholder="buscar por ID do usuário" class="search-input" autocomplete="off">
                        <i class="fa fa-search"></i>
                    </div>
                
                    <div wire:target="search_mensalidade" style="margin-top: 125px; margin-bottom: 125px;"
                        wire:loading wire:loading.class="d-flex flex-row align-items-center justify-content-center">
                        <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-3x fa-spin"></i>
                    </div>

                    <div wire:target="search_mensalidade" wire:loading.remove class="card-body px-0 pb-0 table-responsive yampay-scroll">

                        @if($get_mensalidades->count())
        
                            <table style="cursor: default; white-space: nowrap; user-select: none;" class="table table-borderless mb-2">
                                <thead class="t-head">
                                    <tr class="t-head-border">                                    
                                        <th>ID Contrato #</th>
                                        <th>ID Usuário #</th>
                                        <th>Nome</th>
                                        <th>CPF/CNPJ</th>
                                        <th>Cidade e Estado</th>
                                        <th>Vencimento</th>
                                        <th>Pago em</th>
                                        <th>Situação</th>
                                        <th>Valor</th>                                 
                                        <th>Valor pago</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="t-body">
        
                                    @foreach ($get_mensalidades as $row_mensalidade)
                                            
                                        @php

                                            $row_mensalidade_vencimento = date('d/m/Y', strtotime($row_mensalidade->vencimento));
                                            $row_mensalidade_valor = number_format($row_mensalidade->valor, 2, ",", ".");

                                            if ($row_mensalidade->pagamento != null){
                                                $row_mensalidade_pagamento = date('d/m/Y', strtotime($row_mensalidade->pagamento));
                                            }else{
                                                $row_mensalidade_pagamento = null;
                                            }
                                            if($row_mensalidade->valor_pago != null){
                                                $row_mensalidade_valor_pago = number_format($row_mensalidade->valor_pago, 2, ",", ".");
                                            }else{
                                                $row_mensalidade_valor_pago = null;
                                            }

                                        @endphp
            
                                        <tr class="tr-hover @if($row_mensalidade->status == 1) row-paga  @endif">

                                            <td class="align-middle text-bold">
                                                {{$row_mensalidade->contract_id}}
                                            </td>

                                            <td style="color: #1d4ed8;" class="align-middle font-weight-bolder">
                                                {{$row_mensalidade->user_id}}
                                            </td>

                                            <td class="align-middle font-desc">
                                                {{$row_mensalidade->user->name}}
                                            </td>

                                            <td class="align-middle font-desc">
                                                @if (empty($row_mensalidade->user->documento))
                                                    <span style="color: #dc2626;" class="text-bold">Não cadastrado</span>
                                                @else
                                                    {{$row_mensalidade->user->documento}}
                                                @endif
                                            </td>

                                            <td class="align-middle font-desc">
                                                @if (empty($row_mensalidade->user->cidade) or empty($row_mensalidade->user->estado))
                                                    <span style="color: #dc2626;" class="text-bold">Não cadastrados</span>
                                                @else
                                                    {{$row_mensalidade->user->cidade}} - {{$row_mensalidade->user->estado}}
                                                @endif
                                            </td>

                                            <td class="align-middle">
                                                <span style="font-size: 11px;" class="operacao-saida text-nowrap">
                                                    {{$row_mensalidade_vencimento}}
                                                </span>
                                            </td>

                                            <td class="align-middle">
                                                @if (isset($row_mensalidade_pagamento))
                                                    <span style="font-size: 11px;" class="operacao-entrada text-nowrap">
                                                        {{$row_mensalidade_pagamento}}
                                                    </span>
                                                @endif                                                
                                            </td>

                                            @if ($row_mensalidade->status == 0)
                                                <td style="font-size: 14px; font-weight: 600; color: #725BC2;" class="align-middle">                                                 
                                                    Pendente                                                    
                                                </td>
                                            @elseif($row_mensalidade->status == 1)
                                                <td style="font-size: 14px; font-weight: 600; color: #16a34a;" class="align-middle">                                                 
                                                    PAGA                                                   
                                                </td>
                                            @endif
                                            
                                            <td style="font-size: 15px; font-weight: 500; color: #01984E;" class="align-middle">
                                                R$ {{$row_mensalidade_valor}}
                                            </td>

                                            <td style="font-size: 15px; font-weight: 500; color: #2563eb;" class="align-middle">
                                                @if (isset($row_mensalidade_valor_pago))
                                                    R$ {{$row_mensalidade_valor_pago}}
                                                @endif                                   
                                            </td> 
                                            
                                            @if ($row_mensalidade->status == 0)
                                                <td class="align-middle">
                                                    <div wire:key="{{$row_mensalidade->id . 'p'}}" class="div-btns-actions text-center">

                                                        @if (empty($row_mensalidade->user->documento) or empty($row_mensalidade->user->cidade) or empty($row_mensalidade->user->estado))
                                                            <button data-tooltip="Solicite os dados restantes para pagar a mensalidade." data-flow="left" class="btn btn-secondary btn-sm mr-1" disabled>
                                                                <i class="far fa-money-bill-alt fa-fw mr-2"></i>Pagar
                                                            </button>
                                                        @else
                                                            <button wire:click.prevent="payConfirmation({{$row_mensalidade->id}})" wire:loading.attr="disabled" wire:target="payConfirmation({{$row_mensalidade->id}})" class="btn btn-success btn-sm mr-1">
                                                                <i class="far fa-money-bill-alt fa-fw mr-2"></i>Pagar
                                                            </button>
                                                        @endif

                                                        <button wire:click.prevent="vencimentoConfirmation({{$row_mensalidade->id}})" wire:loading.attr="disabled" wire:target="vencimentoConfirmation({{$row_mensalidade->id}})" class="btn btn-warning btn-sm">
                                                            <i class="far fa-money-check-edit-alt fa-fw mr-2"></i>Alterar venc.
                                                        </button>
                                                        @if ($row_mensalidade->contract->is_test == 1)
                                                            <br>
                                                            @if ($modalidade_mensalidade === 1)
                                                                <div class="div-space-span mt-2">
                                                                    <span class="operacao-entrada">Período de avaliação ativo</span>
                                                                </div>
                                                            @elseif($modalidade_mensalidade === 0)
                                                                <div class="div-space-span mt-2">
                                                                    <span class="operacao-saida">Período de avaliação encerrado</span>
                                                                </div>
                                                            @endif                                                         
                                                        @endif
                                                    </div>                                                   
                                                </td>
                                            @elseif($row_mensalidade->status == 1)
                                                <td class="align-middle">
                                                    <div wire:key="{{$row_mensalidade->id . 'e'}}" class="div-btns-actions text-center">

                                                        <button wire:click.prevent="estornoConfirmation({{$row_mensalidade->id}})" wire:loading.attr="disabled" wire:target="estornoConfirmation({{$row_mensalidade->id}})" type="button" class="btn btn-primary btn-sm mr-1">
                                                            <i class="far fa-undo-alt fa-fw mr-1"></i>Estornar
                                                        </button>
                                                        
                                                        @if ($row_mensalidade->contract->is_test == 1)
                                                            <br>
                                                            @if ($modalidade_mensalidade === 1)
                                                                <div class="div-space-span mt-2">
                                                                    <span class="operacao-entrada">Período de avaliação ativo</span>
                                                                </div>
                                                            @elseif($modalidade_mensalidade === 0)
                                                                <div class="div-space-span mt-2">
                                                                    <span class="operacao-saida">Período de avaliação encerrado</span>
                                                                </div>
                                                            @endif
                                                        @endif

                                                    </div>                                                   
                                                </td>                                              
                                            @endif

                                        </tr>    

                                    @endforeach
        
                                </tbody>
                            </table>
        
                        @else
        
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
                                        <rect x="70.332" y="28.22" width="81.73" height="81.882" rx="21.767" class="B F" />
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
                                <h3 class="my-4 no-results">Não há mensalidades a serem exibidas.</h3>
                            </div>
        
                        @endif
        
                    </div>

                </div>

            </div>
            
        </div>
        {{-- ÁREA MENSALIDADES--}}

        {{-- ÁREA COMISSÕES--}}
        @livewire('comissao')
        {{-- ÁREA COMISSÕES--}}

        @else
            <div class="card">

                <div class="card-body px-0 pb-0">
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
                        <h3 style="font-size: 30px;" class="my-4 no-results">Área restrita <i class="fad fa-shield"></i></h3>                 
                        <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                            <h3 style="font-size: 26px;" class="no-results-create mb-3">Você não possui permissão para visualizar este conteúdo.</h3>
                            <h3 style="font-size: 22px; color: #666;" class="no-results-create mb-3 mt-2">Tem dúvidas?</h3>
                            <a target="_blank" href="https://api.whatsapp.com/send?phone=5534998395367&text=Ol%C3%A1!%20Preciso%20de%20ajuda%20com%20a%20Plataforma%20Cashiers!" class="ml-2 btn btn-nr"><i class="fad fa-user-headset fa-lg mr-2"></i>Fale conosco</a>
                        </div>
                    </div>
                </div>
        
            </div>
        @endif

        <div style="user-select: none; padding-bottom: 150px;" class="d-flex flex-row align-items-center justify-content-between">
        </div>

    </div>

    @if(auth()->user()->is_admin === 1)

        {{-- Modal Contratos --}}
        <div class="modal fade" id="showContracts" tabindex="-1"
        aria-labelledby="showContractsLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                    
                        <h5 class="modal-title px-3 py-3" id="showContractsLabel">Contratos de {{$username}}</h5>
                        <div class="div-fl-modal float-right">
                            <button data-toggle="modal" data-target="#new-contract" type="button" class="btn btn-new my-3">
                                + Novo contrato
                            </button>                  
                            <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times"></i>
                            </button>
                        </div>                  

                    </div>
                    <div class="modal-body py-4 px-4 yampay-scroll">

                        @if ($contracts->count())

                        <div class="div-qtd-contracts text-uppercase">
                            <span style="font-size: 13px; font-weight: 600; color: #555;">
                                Quantidade de contratos: 
                                <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #725BC2;">{{$contracts->count()}}</span>
                            </span>
                        </div>
                        
                        @foreach ($contracts as $contract)
                            
                            <div class="accordion mt-3" id="accordion{{$contract->id}}">                   
                                <div style="padding: 0px !important; margin-bottom: 0 !important;" class="card">
                                <div style="background-color: #f9fafb;" class="card-header p-3" id="heading{{$contract->id}}">
                                    <h2 class="mb-0 d-flex flex-row align-items-center justify-content-between">
                                    <button style="color: #725BC2;" class="btn py-2 btn-link btn-block text-left collapsed font-weight-bold" type="button" data-toggle="collapse" data-target="#collapse{{$contract->id}}" aria-expanded="false" aria-controls="collapse{{$contract->id}}">
                                        <i class="fad fa-chevron-down fa-fw mr-1"></i> 
                                        Plataforma Cashiers 
                                        @if($contract->is_test == 1) 
                                        [<span style="color: #08af45;">PERÍODO DE AVALIAÇÃO GRATUITA: <span style="color: #a855f7;">1 MÊS</span></span>]
                                        @elseif($contract->is_test == 0)
                                        [<span style="color: #a855f7;">{{$contract->id}}</span>]
                                        @endif
                                    </button>
                                    <div class="div-accordion-right d-flex flex-row align-items-center">

                                            @php
                                                $data_contrato = $contract->created_at->format('d/m/Y');                       
                                            @endphp

                                            @if ($contract->status == 1)
                                                <span style="color: #16a34a; font-weight: 600;" class="span-contract mr-4">
                                                    Ativo
                                                </span>
                                            @elseif($contract->status == 0)
                                                <span style="color: #dc2626; font-weight: 600;" class="span-contract mr-4">
                                                    Inativo
                                                </span>
                                            @elseif($contract->status == 3)
                                                <span style="color: #4b5563; font-weight: 600;" class="span-contract mr-4">
                                                    Cancelado
                                                </span>
                                            @endif                                 

                                        <span style="color: #725BC2" class="span-contract mr-2">
                                            {{$data_contrato}}
                                        </span>

                                        <button style="padding: 4px 7px;" class="btn btn-light rounded-circle text-primary" type="button" data-toggle="collapse" data-target="#contract-info{{$contract->id}}" aria-expanded="false" aria-controls="contract-info{{$contract->id}}">
                                            <i class="fas fa-info-circle fa-fw"></i>
                                        </button>                          

                                    </div>
                                    </h2>

                                    <div class="collapse" id="contract-info{{$contract->id}}" wire:ignore.self>
                                        <div style="margin-bottom: 0 !important; padding: 10px 15px 15px 15px!important;" class="card card-body">

                                            <table style="cursor: default; white-space: nowrap; user-select: none;" class="table table-borderless">
                                                <thead class="t-head">
                                                    <tr class="t-head-border">
                                                        <th>Vigência</th>
                                                        <th>Valor</th>
                                                        <th>Vencimento</th>     
                                                        <th>Comissionado</th>     
                                                        <th>Ações</th>     
                                                    </tr>
                                                </thead>
                                                <tbody class="t-body">     
                                                    
                                                    @php
                                                        $valor_contrato = number_format($contract->valor, 2, ",", ".");
                                                        $vencimento_contrato = date('d/m/Y', strtotime($contract->vencimento));
                                                    @endphp
                        
                                                    <tr class="tr-hover">

                                                        <td style="font-size: 14px; font-weight: 600; color: #725BC2;" class="align-middle">                                                 
                                                            {{$contract->periodo}} meses                   
                                                        </td>

                                                        <td style="font-size: 15px; font-weight: 500; color: #01984E;" class="align-middle">
                                                            R$ {{$valor_contrato}}
                                                        </td>

                                                        <td class="align-middle">
                                                            <span style="font-size: 11px;" class="operacao-saida text-nowrap">
                                                                {{$vencimento_contrato}}
                                                            </span>
                                                        </td>

                                                        <td style="font-size: 14px; font-weight: 600; color: #2563eb;" class="align-middle">

                                                            @if ($contract->comissionado_id != null)

                                                                @php
                                                                $get_comissionado = App\Models\User::where('id', $contract->comissionado_id)->pluck('name')->toArray();
                                                                @endphp

                                                                {{$get_comissionado['0']}}
                                                            
                                                                @else

                                                                Nenhum
                                         
                                                            @endif                                   
                                                                             
                                                        </td>

                                                        <td class="align-middle">
                                                            @if($contract->status != 3)
                                                            <div wire:key="{{$contract->id}}" class="div-key-contract">
                                                                <button wire:click.prevent="cancelamentoConfirmation({{$contract->id}})" wire:loading.attr="disabled" wire:target="cancelamentoConfirmation({{$contract->id}})" class="btn btn-sm btn-outline-secondary mr-1">
                                                                    <i class="far fa-ban fa-fw mr-1"></i>Cancelar contrato
                                                                </button>
                                                            </div>
                                                            @endif
                                                            @if($contract->status == 3)
                                                                @if ($contract->comissionado_id == null)
                                                                    <button wire:click.prevent="exclusaoConfirmation({{$contract->id}})" wire:loading.attr="disabled" wire:target="exclusaoConfirmation({{$contract->id}})" class="btn btn-sm btn-danger">
                                                                        <i class="far fa-trash-alt fa-fw mr-1"></i>Excluir contrato
                                                                    </button>
                                                                @else
                                                                    <button data-tooltip="Não é possível excluir um contrato caso haja um comissionado." data-flow="bottom" class="btn btn-sm btn-danger" disabled>
                                                                        <i class="far fa-trash-alt fa-fw mr-1"></i>Excluir contrato
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </td>

                                                    </tr>                        
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                </div>
                                    
                                <div id="collapse{{$contract->id}}" class="collapse" aria-labelledby="heading{{$contract->id}}" data-parent="#accordion{{$contract->id}}" wire:ignore.self>
                                    <div class="card-body table-responsive yampay-scroll">

                                        <table style="cursor: default; white-space: nowrap; user-select: none;" class="table table-borderless mb-2">
                                            <thead class="t-head">
                                                <tr class="t-head-border">
                                                    <th>Vencimento</th>
                                                    <th>Pago em</th>
                                                    <th>Situação</th>
                                                    <th>Valor</th>
                                                    <th>Valor pago</th>
                                                    <th class="text-center">Ações</th>       
                                                </tr>
                                            </thead>
                                            <tbody class="t-body">
                                                
                                                @php
                                                    
                                                    $mensalidades = App\Models\Payment::where('contract_id', $contract->id)
                                                    ->orderBy('id', 'ASC')
                                                    ->get();

                                                @endphp

                                                @foreach ($mensalidades as $mensalidade)
                                                
                                                @php

                                                    $mensalidade_vencimento = date('d/m/Y', strtotime($mensalidade->vencimento));
                                                    $mensalidade_valor = number_format($mensalidade->valor, 2, ",", ".");

                                                    if ($mensalidade->pagamento != null){
                                                        $mensalidade_pagamento = date('d/m/Y', strtotime($mensalidade->pagamento));
                                                    }else{
                                                        $mensalidade_pagamento = null;
                                                    }
                                                    if($mensalidade->valor_pago != null){
                                                        $mensalidade_valor_pago = number_format($mensalidade->valor_pago, 2, ",", ".");
                                                    }else{
                                                        $mensalidade_valor_pago = null;
                                                    }

                                                @endphp
                    
                                                <tr class="tr-hover @if($mensalidade->status == 1) row-paga  @endif">

                                                    <td class="align-middle">
                                                        <span style="font-size: 11px;" class="operacao-saida text-nowrap">
                                                            {{$mensalidade_vencimento}}
                                                        </span>
                                                    </td>

                                                    <td class="align-middle">
                                                        @if (isset($mensalidade_pagamento))
                                                            <span style="font-size: 11px;" class="operacao-entrada text-nowrap">
                                                                {{$mensalidade_pagamento}}
                                                            </span>
                                                        @endif                                                
                                                    </td>

                                                    @if ($mensalidade->status == 0)
                                                        <td style="font-size: 14px; font-weight: 600; color: #725BC2;" class="align-middle">                                                 
                                                            Pendente                                                    
                                                        </td>
                                                    @elseif($mensalidade->status == 1)
                                                        <td style="font-size: 14px; font-weight: 600; color: #16a34a;" class="align-middle">                                                 
                                                            PAGA                                                   
                                                        </td>
                                                    @endif
                                                    

                                                    <td style="font-size: 15px; font-weight: 500; color: #01984E;" class="align-middle">
                                                        R$ {{$mensalidade_valor}}
                                                    </td>

                                                    <td style="font-size: 15px; font-weight: 500; color: #2563eb;" class="align-middle">
                                                        @if (isset($mensalidade_valor_pago))
                                                            R$ {{$mensalidade_valor_pago}}
                                                        @endif                                   
                                                    </td> 
                                                    
                                                    @if($contract->status == 3)
                                                        <td class="align-middle">
                                                            <div class="div-btns-actions text-center">
                                                                <button disabled type="button" class="btn btn-secondary btn-sm mr-1">
                                                                    <i class="far fa-ban fa-fw mr-2"></i>Cancelado
                                                                </button>
                                                            </div>                                                   
                                                        </td>
                                                    @else
                                                        @if ($mensalidade->status == 0)
                                                            <td class="align-middle">
                                                                <div wire:key="{{$mensalidade->id . 'pag'}}" class="div-btns-actions text-center">

                                                                    <button wire:click.prevent="payConfirmation({{$mensalidade->id}})" wire:loading.attr="disabled" wire:target="payConfirmation({{$mensalidade->id}})" class="btn btn-success btn-sm mr-1">
                                                                        <i class="far fa-money-bill-alt fa-fw mr-2"></i>Pagar
                                                                    </button>

                                                                    <button wire:click.prevent="vencimentoConfirmation({{$mensalidade->id}})" wire:loading.attr="disabled" wire:target="vencimentoConfirmation({{$mensalidade->id}})" class="btn btn-warning btn-sm">
                                                                        <i class="far fa-money-check-edit-alt fa-fw mr-2"></i>Alterar venc.
                                                                    </button>

                                                                </div>                                                   
                                                            </td>
                                                        @elseif($mensalidade->status == 1)
                                                            <td class="align-middle">
                                                                <div wire:key="{{$mensalidade->id . 'est'}}" class="div-btns-actions text-center">

                                                                    <button wire:click.prevent="estornoConfirmation({{$mensalidade->id}})" wire:loading.attr="disabled" wire:target="estornoConfirmation({{$mensalidade->id}})" type="button" class="btn btn-primary btn-sm mr-1">
                                                                        <i class="far fa-undo-alt fa-fw mr-1"></i>Estornar
                                                                    </button>

                                                                </div>                                                   
                                                            </td>                                              
                                                        @endif

                                                    @endif

                                                </tr>    

                                                @endforeach

                                            </tbody>
                                        </table>
                                    
                                    </div>
                                </div>
                                </div>                      
                            </div>

                        @endforeach

                        @else
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
                                        <rect x="70.332" y="28.22" width="81.73" height="81.882" rx="21.767" class="B F" />
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
                                <h3 class="my-4 no-results">Não há contratos a serem exibidos.</h3>
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <h3 class="no-results-create mb-3">Comece criando um</h3>                               
                                    <a data-toggle="modal" data-target="#new-contract" class="ml-2 btn btn-nr">+ Novo contrato</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer py-4">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmação Pagamento-->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="pay-mensalidade-confirmation" tabindex="-1"
        aria-labelledby="pay-mensalidade-confirmationLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="pay-mensalidade-confirmationLabel">Confirmação de pagamento</h5>
                        <button wire:click.prevent="resetOperation()" wire:loading.attr="disabled" type="button" class="close px-4"
                            aria-label="Close" data-dismiss="modal">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente pagar esta mensalidade?</h5>

                        <div class="confirmation-msg text-center mb-3">
                            <p class="m-0 mb-3 px-4">
                                Ao clicar em <span class="msg-bold">Confirmar</span>, a mensalidade será paga para este usuário do sistema.
                            </p>                      
                        </div>

                    </div>
                    <div class="modal-footer py-4">
                        <button wire:loading.attr="disabled" wire:click.prevent="resetOperation()" type="button"
                            class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                        <button wire:click.prevent="payMensalidade({{$mensalidade_target}})" wire:loading.attr="disabled" type="button" class="btn btn-send" data-dismiss="modal">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmação Estorno-->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="estorno-mensalidade-confirmation" tabindex="-1"
        aria-labelledby="estorno-mensalidade-confirmationLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="estorno-mensalidade-confirmationLabel">Confirmação de estorno</h5>
                        <button wire:click.prevent="resetEstorno()" wire:loading.attr="disabled" type="button" class="close px-4"
                            aria-label="Close" data-dismiss="modal">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente estornar este pagamento?</h5>

                        <div class="confirmation-msg text-center mb-3">
                            <p class="m-0 mb-3 px-4">
                                Ao clicar em <span class="msg-bold">Confirmar</span>, a mensalidade será estornada para este usuário do sistema.
                            </p>                      
                        </div>

                    </div>
                    <div class="modal-footer py-4">
                        <button wire:loading.attr="disabled" wire:click.prevent="resetEstorno()" type="button"
                            class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                        <button wire:click.prevent="estornarPagamento({{$mensalidade_target}})" wire:loading.attr="disabled" type="button" class="btn btn-send" data-dismiss="modal">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Alterar Vencimento -->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="vencimento-mensalidade-confirmation" tabindex="-1"
        aria-labelledby="vencimento-mensalidade-confirmationLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="vencimento-mensalidade-confirmationLabel">Alterar vencimento</h5>
                        <button wire:click.prevent="resetVencimento()" wire:loading.attr="disabled" type="button" class="close px-4"
                            aria-label="Close" data-dismiss="modal">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <div class="form-group mb-0">
                            <label class="modal-label" for="desc-op">Data de vencimento <span class="red">*</span></label>
                            <input style="width: 100%; height: calc(2.25rem + 2px);" wire:model.defer="vencimento_mensalidade" type="date" class="form-control modal-input search-relatorio"
                                id="desc-op" autocomplete="off"> 
                            @error('vencimento_mensalidade')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer py-4">
                        <button wire:loading.attr="disabled" wire:click.prevent="resetVencimento()" type="button"
                            class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                        <button wire:click.prevent="alterarVencimento({{$mensalidade_target}})" wire:loading.attr="disabled" type="button" class="btn btn-send">
                            Confirmar
                        </button>                 
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmação Cancelamento Contrato-->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="cancelamento-contrato" tabindex="-1"
        aria-labelledby="cancelamento-contratoLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="cancelamento-contratoLabel">Confirmação de cancelamento</h5>
                        <button wire:click.prevent="resetCancelamento()" wire:loading.attr="disabled" type="button" class="close px-4"
                            aria-label="Close" data-dismiss="modal">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente cancelar este contrato?</h5>

                        <div class="confirmation-msg text-center mb-3">
                            <p class="m-0 mb-3 px-4">
                                Ao clicar em <span class="msg-bold">Confirmar</span>, este contrato será cancelado no sistema.
                                <br>
                                <span class="msg-bold text-uppercase">Atenção:</span> Esta ação é irreversível e o contrato não poderá ser ativo novamente!
                            </p>                      
                        </div>

                    </div>
                    <div class="modal-footer py-4">
                        <button wire:loading.attr="disabled" wire:click.prevent="resetCancelamento()" type="button"
                            class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                        <button wire:click.prevent="cancelContract({{$contrato_target}})" wire:loading.attr="disabled" type="button" class="btn btn-send" data-dismiss="modal">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmação Exclusão Contrato-->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="exclusao-contrato" tabindex="-1"
        aria-labelledby="exclusao-contratoLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="exclusao-contratoLabel">Confirmação de exclusão</h5>
                        <button wire:click.prevent="resetExclusao()" wire:loading.attr="disabled" type="button" class="close px-4"
                            aria-label="Close" data-dismiss="modal">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente excluir este contrato?</h5>

                        <div class="confirmation-msg text-center mb-3">
                            <p class="m-0 mb-3 px-4">
                                Ao clicar em <span class="msg-bold">Confirmar</span>, este contrato será inteiramente excluído do sistema.
                                <br>
                                <span class="msg-bold text-uppercase">Atenção:</span> Esta ação é irreversível e o contrato não poderá ser visualizado novamente!
                            </p>                      
                        </div>

                    </div>
                    <div class="modal-footer py-4">
                        <button wire:loading.attr="disabled" wire:click.prevent="resetExclusao()" type="button"
                            class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                        <button wire:click.prevent="deleteContract({{$contrato_target}})" wire:loading.attr="disabled" type="button" class="btn btn-send" data-dismiss="modal">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmação Exclusão USUÁRIO -->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="delete-user-confirmation" tabindex="-1"
        aria-labelledby="delete-user-confirmationLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="delete-user-confirmationLabel">Confirmação de exclusão</h5>
                        <button wire:click.prevent="resetUserToDeleteInfo()" wire:loading.attr="disabled" type="button" class="close px-4" aria-label="Close" data-dismiss="modal">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente deletar este usuário da plataforma?</h5>

                        <div class="confirmation-msg text-center mb-3">
                            <p class="m-0 mb-3 px-4">
                                Ao clicar em <span class="msg-bold">Confirmar</span>, o usuário <span class="msg-bold">{{$username_to_delete}}</span> e todos os seus dados serão inteiramente excluídos da plataforma.
                                <br>
                                <span class="msg-bold text-uppercase">Atenção:</span> Esta ação é irreversível e o usuário não poderá ser recuperado!
                            </p>                      
                        </div>

                    </div>
                    <div class="modal-footer py-4">
                        <button wire:click.prevent="resetUserToDeleteInfo()" wire:loading.attr="disabled" type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                        <button wire:click.prevent="confirmDeletarUser()" wire:loading.attr="disabled" type="button" class="btn btn-send" data-dismiss="modal">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>


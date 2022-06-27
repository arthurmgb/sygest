<div>

    <div class="page-header d-flex flex-row align-items-center mb-2">
        <h2 class="f-h2">Meus contratos</h2>
        <span class="f-span">{{$all_contratos_user}} contratos</span>
    </div>

    <div class="block">

        <div class="card">

            <div class="topo-ico d-flex flex-row align-items-center mb-1">
                <i style="color: #725BC2;" class="fad fa-file-signature fa-fw fa-lg mr-2"></i>
                <div class="card-topo">
                    <div style="margin-bottom: 0 !important;" class="title-block f-calc">                                                                        
                        Contratos com a plataforma
                    </div>                     
                </div>
                <div class="dropdown" wire:key="drop1">
                    <button style="padding: 5px 5px; color: #666;" class="btn btn-sm btn-light ml-2 rounded-circle" type="button" id="drop_details1" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-fw fa-lg"></i>
                    </button>
                    <div style="padding: 20px !important; width: 350px !important; max-width: 350px !important; min-width: 350px !important;" class="dropdown-menu text-uppercase" aria-labelledby="drop_details1">                        
                        <span style="font-size: 13px; font-weight: 600; color: #555;">
                        Total de contratos: 
                        <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #725BC2;">
                            {{$all_contratos_user}}
                        </span>
                        </span><br>
                        <span style="font-size: 13px; font-weight: 600; color: #555;">
                        Total de contratos ativos: 
                        <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #16a34a;">
                            {{$ativos_contratos_user}}
                        </span>
                        </span><br>
                        <span style="font-size: 13px; font-weight: 600; color: #555;">
                        Total de contratos inativos: 
                        <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #dc2626;">
                            {{$inativos_contratos_user}}
                        </span>
                        </span><br>
                        <span style="font-size: 13px; font-weight: 600; color: #555;">
                        Total de contratos cancelados: 
                        <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #4b5563;">
                            {{$cancelados_contratos_user}}
                        </span>
                        </span><br>
                    </div>
                </div> 
            </div>
            
            <div class="card-body px-0 py-0 ">

                @if ($contracts->count())
                
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
                                                <th class="text-center">Detalhes</th>       
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
                                                        <td class="align-middle" style="font-size: 15px; font-weight: 500; color: #2563eb;">
                                                            <div class="div-btns-actions text-center">
                                                              
                                                            </div>                                                   
                                                        </td>
                                                    @elseif($mensalidade->status == 1)

                                                        @if ($contract->is_test == 0)
                                                            <td class="align-middle">
                                                                <div class="div-btns-actions text-center">

                                                                    <button class="btn btn-success btn-sm mr-1" disabled>
                                                                        <i class="far fa-money-bill-alt fa-fw mr-2"></i>Pago
                                                                    </button> 

                                                                    <button wire:click.prevent="openReceipt({{$mensalidade->id}})" wire:target="openReceipt({{$mensalidade->id}})" wire:loading.attr="disabled" data-toggle="modal" data-target="#get-recibo" type="button" class="btn btn-outline-primary btn-sm">
                                                                        <i class="far fa-file-invoice-dollar fa-fw mr-1"></i>Recibo
                                                                    </button>

                                                                </div>                                                   
                                                            </td>
                                                        @elseif($contract->is_test == 1)
                                                            <td class="align-middle">
                                                                <div class="div-btns-actions text-center">

                                                                    <button class="btn btn-danger btn-sm mr-1" disabled>
                                                                        <i class="far fa-clock fa-fw mr-2"></i>Período de avaliação encerrado
                                                                    </button>                                                           

                                                                </div>                                                   
                                                            </td>
                                                        @endif
                                              
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
                </div>

                @endif

            </div>

        </div>

        @if ($contracts->count())

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
                        Total geral à pagar: 
                        <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #16a34a;">
                        R$ {{$get_total_geral_a_pagar}}
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
                    
            <div class="card-body px-0 py-0 table-responsive yampay-scroll">

                @if($get_mensalidades->count())

                    <table style="cursor: default; white-space: nowrap; user-select: none;" class="table table-borderless mb-2">
                        <thead class="t-head">
                            <tr class="t-head-border">                                    
                                <th>ID Contrato #</th>                               
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
                                        
                                        @if ($row_mensalidade->contract->is_test == 0)
                                            <td class="align-middle">
                                                <div class="div-btns-actions text-center">

                                                    <button data-toggle="modal" data-target="#formas-pagamento" class="btn btn-success btn-sm mr-1">
                                                        <i class="far fa-money-bill-alt fa-fw mr-2"></i>Pagar
                                                    </button>                                         

                                                </div>                                                   
                                            </td>
                                        @elseif($row_mensalidade->contract->is_test == 1)
                                            <td class="align-middle">
                                                <div class="div-btns-actions text-center">

                                                    <button class="btn btn-success btn-sm mr-1" disabled>
                                                        <i class="far fa-clock fa-fw mr-2"></i>
                                                        Período de avaliação encerra em: {{date('d/m/Y', strtotime($row_mensalidade->contract->vencimento))}}
                                                    </button>                                         

                                                </div>                                                   
                                            </td>
                                        @endif                                 

                                    @elseif($row_mensalidade->status == 1)

                                    @if ($row_mensalidade->contract->is_test == 0)
                                        <td class="align-middle">
                                            <div class="div-btns-actions text-center">

                                                <button class="btn btn-success btn-sm mr-1" disabled>
                                                    <i class="far fa-money-bill-alt fa-fw mr-2"></i>Pago
                                                </button> 

                                                <button wire:click.prevent="openReceipt({{$row_mensalidade->id}})" wire:target="openReceipt({{$row_mensalidade->id}})" wire:loading.attr="disabled" data-toggle="modal" data-target="#get-recibo" type="button" class="btn btn-outline-primary btn-sm">
                                                    <i class="far fa-file-invoice-dollar fa-fw mr-1"></i>Recibo
                                                </button>

                                            </div>                                                   
                                        </td>
                                    @elseif($row_mensalidade->contract->is_test == 1)
                                        <td class="align-middle">
                                            <div class="div-btns-actions text-center">

                                                <button class="btn btn-danger btn-sm mr-1" disabled>
                                                    <i class="far fa-clock fa-fw mr-2"></i>Período de avaliação encerrado
                                                </button>

                                            </div>                                                   
                                        </td>
                                    @endif
                                        

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

        @endif
        
        <div style="user-select: none; padding-bottom: 150px;" class="d-flex flex-row align-items-center justify-content-between">

        </div>

    </div>

    {{-- MODAL FORMAS DE PAGAMENTO --}}
    <div class="modal fade" id="formas-pagamento" tabindex="-1"
    aria-labelledby="formas-pagamentoLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="formas-pagamentoLabel">Pagar mensalidade</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 style="font-weight: 500;" class="modal-confirmation-msg m-0 text-center px-4 mb-3">Escolha a forma de pagamento</h5>

                    <div class="confirmation-msg text-center">

                        <div class="row">

                            <div class="col-12">
                                <button data-dismiss="modal" data-toggle="modal" data-target="#fp-pix" style="font-size: 18px;" class="mt-3 my-2 btn btn-new">
                                    <i class="fa-brands fa-pix mr-2 fa-fw"></i>PIX
                                </button>
                            </div>

                            <div class="col-12">
                                <button data-dismiss="modal" data-toggle="modal" data-target="#fp-ted" style="font-size: 18px;" class="my-2 btn btn-new">
                                    <i class="fa-solid fa-building-columns fa-fw mr-2"></i>Transferência bancária
                                </button>
                            </div>

                            <div class="col-12">
                                <a href="https://seguro.cashiers.com.br/r/NAAMX2PKRO" target="_blank" style="font-size: 18px;" class="mt-2 mb-4 btn btn-new py-2">
                                    <img class="mr-1" style="width: 32px; heigth: 32px;" src="{{asset('vendor/adminlte/dist/img/cashier-logo.png')}}"> 
                                    Checkout Cashiers
                                </a>
                            </div>
                            
                        </div>

                        <span style="font-size: 14px;"><span class="text-bold">Observação: </span>pode demorar alguns minutos até que a plataforma identifique seu pagamento.</span>
                        <br>
                        <div class="div-notificacao-pag mt-2">
                            <span style="font-size: 13px;"><i style="color: #16a34a; font-size: 18px;" class="fad fa-comment-dollar fa-fw mr-1"></i>Enviaremos uma notificação assim que seu pagamento for recebido.</span>
                        </div>
                        
                    </div>

                </div>
                <div class="modal-footer py-4 d-flex flex-row align-items-center justify-content-end">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL FORMAS DE PAGAMENTO - PIX --}}
    <div class="modal fade" id="fp-pix" tabindex="-1"
    aria-labelledby="fp-pixLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="fp-pixLabel">Pagar com PIX</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 style="font-size: 24px;" class="modal-confirmation-msg m-0 text-center px-4 mb-3">
                        Use o <span class="text-bold">QR Code</span> abaixo ou transfira para a <span class="text-bold">chave PIX</span> em destaque
                    </h5>

                    <div class="confirmation-msg text-center">

                        <img style="width: 402px; height: 375px; pointer-events: none; user-drag: none;" class="rounded mx-auto d-block" src="{{'vendor/adminlte/dist/img/pix-150.png'}}">

                        <button onclick="changePix()" id="btn-pix" data-clipboard-text="00020126330014BR.GOV.BCB.PIX0111155332526575204000053039865406150.005802BR5924Arthur de Oliveira Silva6009SAO PAULO61080540900062070503***63049304" style="font-size: 18px;" class="copy-pix-150 my-3 btn btn-new">Copiar código do QR Code <i class="fa-fw fas fa-clone ml-1"></i></button>

                        <ul class="list-group">
                            <li class="list-group-item list-pix">
                                <i class="fa-brands fa-pix fa-fw fa-lg mr-1"></i><span class="text-bold">Chave PIX:</span> 155.332.526-57
                            </li>
                        </ul>
                        
                    </div>

                </div>
                <div class="modal-footer py-4 d-flex flex-row align-items-center justify-content-end">
                    <button type="button" class="btn btn-new" data-dismiss="modal" data-toggle="modal" data-target="#formas-pagamento">
                        <i class="fad fa-angle-double-left fa-fw fa-lg mr-1"></i>Alterar forma de pagamento
                    </button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL FORMAS DE PAGAMENTO - TED --}}
    <div class="modal fade" id="fp-ted" tabindex="-1"
    aria-labelledby="fp-tedLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="fp-tedLabel">Pagar via Transferência Bancária</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 style="font-size: 24px;" class="modal-confirmation-msg m-0 text-center px-4 mb-3">
                        Use os <span class="text-bold">dados bancários</span> abaixo para <span class="text-bold">realizar a transferência</span>.
                    </h5>

                    <div class="confirmation-msg text-center mt-4 mb-0">

                        <div class="row">
                            <div id="data-bank" class="col-12 blur-dados" wire:ignore>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item text-left list-bank flex-fill">
                                        <i style="color: #725BC2;" class="fad fa-user fa-fw mr-2 fa-lg"></i>Beneficiário
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill">Arthur de Oliveira Silva</li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item text-left list-bank flex-fill">
                                        <i style="color: #725BC2;" class="fad fa-id-card fa-fw mr-2 fa-lg"></i>CPF
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill">155.332.526-57</li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item text-left list-bank flex-fill">
                                        <i style="color: #725BC2;" class="fad fa-university fa-fw mr-2 fa-lg"></i>Banco
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill"><span class="text-bold">0260</span> · Nu Pagamentos S.A.</li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item text-left list-bank flex-fill">
                                        <i style="color: #725BC2;" class="fad fa-money-check-alt fa-fw mr-2 fa-lg"></i>Agência
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill">0001</li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item text-left list-bank flex-fill">
                                        <i style="color: #725BC2;" class="fad fa-user-circle fa-fw mr-2 fa-lg"></i>Conta
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill">14977424-2</li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item text-left list-bank flex-fill">
                                        <i style="color: #725BC2;" class="fad fa-shield-check fa-fw mr-2 fa-lg"></i>Tipo de conta
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill">Conta de pagamentos</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="div-lgpd d-flex flex-row align-items-center">
                                    <input type="checkbox" id="privacy">
                                    <label for="privacy"></label>
                                    <span style="font-size: 15px;" class="px-2 pt-2 pb-0">Declaro ter plena consciência de que não devo compartilhar com terceiros os dados aqui fornecidos e que estou de acordo com a <span class="text-bold">LGPD (Lei Geral de Proteção de Dados Pessoais), <a style="font-weight: 600 !important;" class="verify-font" href="https://www.in.gov.br/materia/-/asset_publisher/Kujrw0TZC2Mb/content/id/36849373/do1-2018-08-15-lei-no-13-709-de-14-de-agosto-de-2018-36849337" target="_blank">Lei nº 13.709/2018 <i class="fad fa-external-link fa-fw"></i></a></span>.</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
                <div class="modal-footer py-4 d-flex flex-row align-items-center justify-content-end">
                    <button type="button" class="btn btn-new" data-dismiss="modal" data-toggle="modal" data-target="#formas-pagamento">
                        <i class="fad fa-angle-double-left fa-fw fa-lg mr-1"></i>Alterar forma de pagamento
                    </button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL RECIBO --}}
    <div class="modal fade" id="get-recibo" tabindex="-1"
    aria-labelledby="get-reciboLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-custom">
                <div class="modal-body py-4 px-4">

                    <div class="confirmation-msg">

                        <div class="div-title-recibo d-flex flex-row align-items-center mb-4">
                            <img style="width: 64px; height: 64px; -webkit-user-drag: none !important; user-select: none;" src="{{asset('vendor/adminlte/dist/img/cashier-logo.png')}}">
                            <div class="mx-auto">
                                <h5 style="font-size: 24px; color: #725BC2;" class="mb-0">Recibo de Prestação de Serviço</h5>
                            </div>
                        </div>
                        
                        @if (isset($recibo_info))
                                                 
                        <div class="row mb-5">

                            <div class="col d-flex flex-column align-items-center">
                                <div class="div-number-mensalidade ml-auto">
                                    <span style="font-size: 18px; color: #725BC2;">Nº: <span style="font-weight: 600;">{{$recibo_info['0']['payment_id']}}</span></span>
                                </div>
                                <div style="border: 2px solid #01984E; border-radius: 4px;" class="div-valor-mensalidade ml-auto px-3 py-1">
                                    <span style="font-size: 18px; color: #16a34a; font-weight: 600;">R$ 150,00</span>
                                </div>
                            </div>

                        </div>

                        <div class="div-row-1 mb-2">
                            <span style="font-size: 17px; color: #444;">
                                Recebemos de <span style="font-weight: 600;">{{$recibo_info['0']['nome']}}</span> - CPF/CNPJ nº <span style="font-weight: 600;">{{$recibo_info['0']['documento']}}</span>, a importância de <span style="font-weight: 600;">cento e cinquenta reais</span> referente à <span style="font-weight: 600;">Mensalidade da Plataforma de Gerenciamento Financeiro - Cashiers</span>.
                            </span>
                        </div>

                        <div class="div-row-2 mb-2">
                            <span style="font-size: 17px; color: #444;">
                                Para maior clareza firmamos o presente recibo para que produza os seus efeitos, dando plena, rasa e irrevogável quitação, pelo valor recebido. 
                            </span>
                        </div>

                        <div class="div-row-3 mb-4">
                            <span style="font-size: 17px; color: #444;">
                                Pagamento recebido por: <span style="font-weight: 600;">Arthur de Oliveira Silva</span> - Chave PIX: <span style="font-weight: 600;">155.332.526-57</span>. 
                            </span><br>
                            <span style="font-size: 17px; color: #444;">
                                Agência: <span style="font-weight: 600;">0001</span> - Conta: <span style="font-weight: 600;">14977424-2</span> - Banco : <span style="font-weight: 600;">0260 - Nu Pagamentos S.A</span>. 
                            </span>
                        </div>

                        <div class="row mb-5">

                            <div class="col d-flex flex-column align-items-center">
                                <div class="div-final-recibo ml-auto">
                                    <span style="font-size: 17px; color: #444;">{{$recibo_info['0']['cidade']}} - {{$recibo_info['0']['estado']}}, {{$data_info['0']}} de {{$data_info['1']}} de {{$data_info['2']}}</span>
                                </div>                           
                            </div>

                        </div>

                        <div class="row">

                            <div class="col text-center">
                                <div class="div-assinatura">
                                    <span style="font-size: 17px; color: #444;">Arthur de Oliveira Silva</span>
                                </div>                           
                                <div class="div-assinatura">
                                    <span style="font-size: 17px; color: #444;">Rua Péricles Borges de Paiva, 483, Cidade Jardim - CEP 38747-122, Patrocínio - MG</span>
                                </div>                           
                                <div class="div-assinatura">
                                    <span style="font-size: 17px; color: #444;">CPF: 155.332.526-57</span>
                                </div>                           
                                <div class="div-assinatura">
                                    <span style="font-size: 17px; color: #444;">(34) 99839-5367</span>
                                </div>                           
                            </div>

                        </div>

                        @endif

                    </div>

                </div>
                <div class="modal-footer py-2 d-flex flex-row align-items-center justify-content-end">
                    <button wire:click.prevent="printPage()" wire:loading.attr="disabled" type="button" class="btn btn-send">
                        <i class="fad fa-print fa-fw fa-lg mr-1"></i>Imprimir
                    </button>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</div>

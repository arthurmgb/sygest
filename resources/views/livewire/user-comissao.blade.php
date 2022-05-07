<div>

    <div class="page-header d-flex flex-row align-items-center mb-2">
        <h2 class="f-h2">Minhas comissões</h2>
        <span class="f-span">{{$get_count_geral_comissoes_recebidas}} comissões recebidas</span>
        <button data-toggle="modal" data-target="#como-funciona" class="btn btn-new ml-auto"><i class="fad fa-info-circle fa-fw fa-lg mr-2"></i>Como funciona?</button>
    </div>

    <div class="block">

        <div class="card">
            
            <div class="topo-ico d-flex flex-row align-items-center mb-1">

                @if ($modalidade_comissao === 1)
                    
                    <i style="color: #2563eb;" class="fad fa-hand-holding-usd fa-fw fa-lg mr-2"></i>
                    <div class="card-topo mr-2">
                        <div style="margin-bottom: 0 !important;" class="title-block f-calc">                                                           
                            Comissões à receber
                            <span class="period">/ Quantidade: {{$get_count_geral_comissoes_a_receber}}</span>
                        </div>                     
                    </div>
                    <button wire:key="btn3" wire:click.prevent="alternarModalidadeComissao(0)" wire:loading.attr="disabled" class="btn btn-sm btn-outline-success ml-2 p-1" data-tooltip="Comissões recebidas" data-flow="top">
                        <i class="fas fa-sort-alt fa-fw fa-lg"></i>
                    </button>

                    @elseif($modalidade_comissao === 0)  
                        
                        <i style="color: #16a34a;" class="fad fa-hand-holding-usd fa-fw fa-lg mr-2"></i>
                        <div class="card-topo mr-2">
                            <div style="margin-bottom: 0 !important;" class="title-block f-calc">                                                           
                                Comissões recebidas
                                <span class="period">/ Quantidade: {{$get_count_geral_comissoes_recebidas}}</span>
                            </div>                     
                        </div>
                        <button wire:key="btn4" wire:click.prevent="alternarModalidadeComissao(1)" wire:loading.attr="disabled" class="btn btn-sm btn-outline-primary ml-2 p-1" data-tooltip="Comissões à receber" data-flow="top">
                            <i class="fas fa-sort-alt fa-fw fa-lg"></i>
                        </button>

                @endif   
                <div class="dropdown" wire:key="drop3">
                    <button style="padding: 5px 5px; color: #666;" class="btn btn-sm btn-light ml-2 rounded-circle" type="button" id="drop_details3" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-fw fa-lg"></i>
                    </button>
                    <div style="padding: 20px !important; width: 400px !important; max-width: 400px !important; min-width: 400px !important;" class="dropdown-menu text-uppercase" aria-labelledby="drop_details3">                        
                        <span style="font-size: 13px; font-weight: 600; color: #555;">
                        Total de comissões à receber: 
                        <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #2563eb;">
                            R$ {{$get_total_geral_comissoes_a_receber}}
                        </span>
                        </span><br>
                        <span style="font-size: 13px; font-weight: 600; color: #555;">
                        Total de comissões recebidas: 
                        <span class="ml-1" style="font-size: 15px; font-weight: 600; color: #16a34a;">
                            R$ {{$get_total_geral_comissoes_recebidas}}
                        </span>
                        </span><br>
                    </div>
                </div> 
            </div>

            <div wire:target="qtd_comissao" style="margin-top: 125px; margin-bottom: 125px;"
            wire:loading wire:loading.class="d-flex flex-row align-items-center justify-content-center">
                <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-3x fa-spin"></i>
            </div>

            <div wire:target="qtd_comissao" wire:loading.remove class="card-body px-0 pb-0 table-responsive yampay-scroll">

                @if ($get_comissoes->count())

                    <table style="cursor: default; white-space: nowrap; user-select: none;" class="table table-borderless mb-2">
                        <thead class="t-head">
                            <tr class="t-head-border">                                    
                                <th>ID Contrato #</th>
                                <th>Comissionado</th>
                                <th>Valor</th>
                                <th>Previsto para</th>
                                <th>Pago em</th>
                                <th>Situação</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody class="t-body">

                            @foreach ($get_comissoes as $row_comissao)

                                @php
                                    
                                    $comissao_valor = number_format($row_comissao->valor, 2, ",", ".");
                                    $comissao_previsao = date('d/m/Y', strtotime($row_comissao->previsao));

                                    if ($row_comissao->pagamento != null){
                                            $comissao_pagamento = date('d/m/Y', strtotime($row_comissao->pagamento));
                                        }else{
                                            $comissao_pagamento = null;
                                        }
                                    
                                @endphp
                                    
                                <tr class="tr-hover @if($row_comissao->status == 1) row-paga  @endif">

                                    <td class="align-middle text-bold">
                                        {{$row_comissao->contract_id}}
                                    </td>

                                    <td class="align-middle font-desc">
                                        {{$row_comissao->user->name}}
                                    </td>

                                    <td style="font-size: 15px; font-weight: 500; color: #01984E;" class="align-middle">
                                        R$ {{$comissao_valor}}
                                    </td>                          

                                    <td class="align-middle">
                                        
                                        <span style="font-size: 11px; background: #3b82f6;" class="operacao-entrada text-nowrap">
                                            {{$comissao_previsao}}
                                        </span>
                                                                                        
                                    </td>

                                    <td class="align-middle">
                                        @if (isset($comissao_pagamento))
                                            <span style="font-size: 11px;" class="operacao-entrada text-nowrap">
                                                {{$comissao_pagamento}}
                                            </span>
                                        @endif                                          
                                    </td>
                
                                    @if ($row_comissao->status == 0)             
                                        <td style="font-size: 14px; font-weight: 600; color: #725BC2;" class="align-middle">                                                 
                                            Pendente                                                   
                                        </td>
                                    @elseif($row_comissao->status == 1)
                                        <td style="font-size: 14px; font-weight: 600; color: #16a34a;" class="align-middle">                                                 
                                            PAGA                                                   
                                        </td>
                                    @endif

                                    @if ($row_comissao->status == 0)
                                    <td class="align-middle">
                                                                                          
                                    </td>
                                    @elseif($row_comissao->status == 1)
                                        <td class="align-middle">
                                            <div class="div-btns-actions text-center">

                                                <button class="btn btn-success btn-sm mr-1" disabled>
                                                    <i class="far fa-money-bill-alt fa-fw mr-2"></i>Pago
                                                </button>

                                                <button wire:click.prevent="openReceipt({{$row_comissao->id}})" wire:target="openReceipt({{$row_comissao->id}})" wire:loading.attr="disabled" data-toggle="modal" data-target="#get-recibo" type="button" class="btn btn-outline-primary btn-sm">
                                                    <i class="far fa-file-invoice-dollar fa-fw mr-1"></i>Recibo
                                                </button>

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
                    <h3 class="my-4 no-results">Não há comissões a serem exibidas.</h3>
                    <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                        <h3 class="no-results-create mb-3">Comece por aqui</h3>
                        <button data-toggle="modal" data-target="#como-funciona" class="ml-2 btn btn-nr"><i class="fad fa-info-circle fa-fw fa-lg mr-2"></i>Como funciona?</button>                 
                    </div>
                </div>
                
                @endif
            </div>

        </div>

        <div class="resultados d-flex flex-row align-items-center justify-content-between">
            <div class="div-show-more-results d-flex flex-row align-items-center">
                <select wire:model="qtd_comissao" class="form-control modal-input-cat rpp">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
                <span class="ml-3 ipp">Itens por página</span>
            </div>
            @if ($get_comissoes->hasPages())
                <div class="paginacao">
                    {{ $get_comissoes->links() }}
                </div>
            @endif
        </div>
        
        <div style="user-select: none; padding-bottom: 150px;" class="d-flex flex-row align-items-center justify-content-between">

        </div>

    </div>

    {{-- MODAL COMO FUNCIONA --}}
    <div class="modal fade" id="como-funciona" tabindex="-1"
    aria-labelledby="como-funcionaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="como-funcionaLabel">Como funcionam as comissões?</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 mb-3">É mais simples do que parece!</h5>

                    <div style="z-index: 10; position: relative;" class="confirmation-msg text-center">
                        <p style="font-size: 18px;" class="m-0 mb-4 px-4">
                            Convide <span class="msg-bold">um amigo ou empresa</span> para se juntar à plataforma. <br>Assim que seu parceiro efetivar um contrato conosco e <span class="msg-bold">realizar o primeiro pagamento</span>, você receberá uma comissão de <span style="font-size: 20px;" class="msg-bold">10%</span> diretamente em sua conta!
                        </p>
                        
                        @php
                            $stripped_name = preg_replace('/\s+/', '%20', auth()->user()->name . ' [Código: CASH' . auth()->user()->id . ']');                      
                        @endphp

                        <button onclick="copyInvite()" id="btn-invite" data-clipboard-text="Olá!! Estou-lhe convidando a fazer parte da melhor *Plataforma de Gerenciamento Financeiro - Cashiers*! Você não pode ficar fora dessa! 🤑&#10;&#10;🔗 *Meu link de convite:* https://api.whatsapp.com/send?phone=5534998395367&text=Ol%C3%A1!%20Fui%20indicado%20a%20participar%20da%20Plataforma%20Cashiers%20pelo(a)%20*{{$stripped_name}}*%2C%20quero%20saber%20mais%20detalhes%2C%20como%20funciona%3F" style="font-size: 18px;" class="copy-invite btn btn-new mb-4">Copiar link de convite <i class="fa-fw fas fa-clone ml-1"></i></button>

                        <h5 style="font-size: 25px;" class="modal-confirmation-msg m-0 text-center px-4 mb-3">Atenção!</h5>

                        <p style="font-size: 18px;" class="m-0 mb-3 px-4">
                            Para começar a <span class="msg-bold">receber pagamentos</span>, você deve obrigatoriamente ter <span class="msg-bold">uma chave PIX</span> e um <span class="msg-bold">banco ou instituição</span> cadastrados em sua conta.
                        </p>

                        <p style="font-size: 18px;" class="m-0 mb-3 px-4">
                            Se você ainda não realizou esses cadastros, <a style="font-size: 18px !important;" class="verify-font" href="{{route('profile.show')}}">clique aqui</a> para ir até seu perfil e completar a verificação.
                        </p>

                        @if (empty(auth()->user()->chave_pix) or empty(auth()->user()->banco))
                            <span style="color: #dc2626; font-size: 16px;"><i class="fad fa-times-circle fa-fw mr-2"></i>Você ainda não possui uma chave PIX ou um banco/instituição cadastrados em sua conta.</span>
                        @else
                            <span style="color: #16a34a; font-size: 16px;"><i class="fad fa-check-circle fa-fw mr-2"></i>Tudo certo! Você já possui uma chave PIX e um banco/instituição cadastrados em sua conta e já pode receber pagamentos!</span>
                        @endif
                        
                        <p style="font-size: 18px;" class="m-0 mt-3 px-4">
                            Quer nos dar alguma sugestão de melhoria? <span class="msg-bold">Entre em contato</span>!
                        </p>
                        <a style="font-size: 18px !important; padding-bottom: 30px;" href="https://api.whatsapp.com/send?phone=5534998395367&amp;text=Ol%C3%A1!%20Quero%20fazer%20uma%20sugestão%20de%20melhoria%20para%20a%20Cashiers!" target="_blank" type="button" class="px-4 verify-font">Fale conosco</a><br>                   
                    </div>

                    <img style="position: absolute; margin-top: -55px; left: -4px; bottom: -20px; z-index: 5;" class="urso-img" src="{{asset('vendor/adminlte/dist/img/no-results-300.png')}}">

                </div>
                <div class="modal-footer py-4 d-flex flex-row align-items-center justify-content-end">
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
                                <h5 style="font-size: 24px; color: #725BC2;" class="mb-0">Recibo de Pagamento</h5>
                            </div>
                        </div>
                        
                        @if (isset($recibo_info))
                                                    
                        <div class="row mb-5">

                            <div class="col d-flex flex-column align-items-center">
                                <div class="div-number-mensalidade ml-auto">
                                    <span style="font-size: 18px; color: #725BC2;">Nº: <span style="font-weight: 600;">{{$recibo_info['0']['comission_id']}}</span></span>
                                </div>
                                <div style="border: 2px solid #01984E; border-radius: 4px;" class="div-valor-mensalidade ml-auto px-3 py-1">
                                    <span style="font-size: 18px; color: #16a34a; font-weight: 600;">R$ 15,00</span>
                                </div>
                            </div>

                        </div>

                        <div class="div-row-1 mb-2">
                            <span style="font-size: 17px; color: #444;">
                                Recebemos de <span style="font-weight: 600;">Arthur de Oliveira Silva</span> - CPF nº <span style="font-weight: 600;">155.332.526-57</span>, a importância de <span style="font-weight: 600;">quinze reais</span> referente ao <span style="font-weight: 600;">Pagamento de Comissão do contrato [{{$contract_number}}]</span>.
                            </span>
                        </div>

                        <div class="div-row-2 mb-2">
                            <span style="font-size: 17px; color: #444;">
                                Para maior clareza firmamos o presente recibo para que produza os seus efeitos, dando plena, rasa e irrevogável quitação, pelo valor recebido. 
                            </span>
                        </div>

                        <div class="div-row-3 mb-4">
                            <span style="font-size: 17px; color: #444;">
                                Pagamento recebido por: <span style="font-weight: 600;">{{$recibo_info['0']['nome']}}</span> - Chave PIX: <span style="font-weight: 600;">{{$recibo_info['0']['chave_pix']}}</span>. 
                            </span><br>
                            <span style="font-size: 17px; color: #444;">
                                Banco : <span style="font-weight: 600;">{{$recibo_info['0']['banco']}}</span>. 
                            </span>
                        </div>

                        <div class="row mb-5">

                            <div class="col d-flex flex-column align-items-center">
                                <div class="div-final-recibo ml-auto">
                                    <span style="font-size: 17px; color: #444;">Patrocínio - MG, {{$data_info['0']}} de {{$data_info['1']}} de {{$data_info['2']}}</span>
                                </div>                           
                            </div>

                        </div>

                        <div class="row">

                            <div class="col text-center">
                                <div class="div-assinatura">
                                    <span style="font-size: 17px; color: #444;">Arthur de Oliveira Silva</span>
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

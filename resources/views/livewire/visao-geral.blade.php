<div>
    <div class="page-header d-flex flex-row align-items-center justify-content-between">
        <h2 style="white-space: nowrap;" class="f-h2">Visão geral</h2>

        @if ($totais == 0)
            <div class="div-right-vg d-flex flex-row">
                <div class="div-label-totais d-flex flex-row align-items-center ml-4">
                    <span wire:click.prevent="ocultarTotais()" class="mr-2 info-total-cx" data-flow="bottom"
                        data-tooltip="Ocultar totais" id="tt-show">
                        <i class="fa-fw fad fa-eye fa-lg"></i>
                    </span>
                    <span class="mr-2 info-total-cx" data-flow="bottom" data-tooltip="Capital por espécie / GERAL"
                        id="tt-info">
                        <i class="fa-fw fad fa-info-circle fa-lg info-ret"></i>
                    </span>
                    <span class="totais-label-style">Totais: </span>
                </div>
                <div class="div-coins d-flex flex-wrap flex-row align-items-end">

                    <div class="dropdown">

                        <div data-toggle="dropdown" aria-expanded="false" class="div-coin-box-light my-1"
                            data-flow="bottom" data-tooltip="Dinheiro">
                            <span style="border-bottom-left-radius: 6px;" class="emoji-coin ec-totais">
                                <i style="color: #01984E;" class="fad fa-money-bill-alt"></i>
                            </span>
                            <span class="coin-valor">
                                R$ {{ $coin_dinheiro }}
                            </span>
                        </div>

                        <div class="dropdown-menu dropdown-vg-totais">

                            <div class="d-flex flex-column">
                                <span>
                                    Entrou:
                                    <span style="color: green; white-space: nowrap;">
                                        R$ {{ $coin_dinheiro_entrada }}
                                    </span>
                                </span>
                                <span>
                                    Saiu:
                                    <span style="color: red; white-space: nowrap;">
                                        R$ {{ $coin_dinheiro_saida }}
                                    </span>
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="dropdown">

                        <div data-toggle="dropdown" aria-expanded="false" class="div-coin-box-light my-1"
                            data-flow="bottom" data-tooltip="Cheques">
                            <span style="border-bottom-left-radius: 6px;" class="emoji-coin ec-totais">
                                <i style="color: #458DE3;" class="fad fa-money-check-edit-alt"></i>
                            </span>
                            <span class="coin-valor">
                                R$ {{ $coin_cheque }}
                            </span>
                        </div>

                        <div class="dropdown-menu dropdown-vg-totais">

                            <div class="d-flex flex-column">
                                <span>
                                    Entrou:
                                    <span style="color: green; white-space: nowrap;">
                                        R$ {{ $coin_cheque_entrada }}
                                    </span>
                                </span>
                                <span>
                                    Saiu:
                                    <span style="color: red; white-space: nowrap;">
                                        R$ {{ $coin_cheque_saida }}
                                    </span>
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="dropdown">

                        <div data-toggle="dropdown" aria-expanded="false" class="div-coin-box-light my-1"
                            data-flow="bottom" data-tooltip="Moedas">
                            <span style="border-bottom-left-radius: 6px;" class="emoji-coin ec-totais">
                                <i style="color: #e6c300;" class="fad fa-coins"></i>
                            </span>
                            <span class="coin-valor">
                                R$ {{ $coin_moeda }}
                            </span>
                        </div>

                        <div class="dropdown-menu dropdown-vg-totais">

                            <div class="d-flex flex-column">
                                <span>
                                    Entrou:
                                    <span style="color: green; white-space: nowrap;">
                                        R$ {{ $coin_moeda_entrada }}
                                    </span>
                                </span>
                                <span>
                                    Saiu:
                                    <span style="color: red; white-space: nowrap;">
                                        R$ {{ $coin_moeda_saida }}
                                    </span>
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="dropdown">

                        <div data-toggle="dropdown" aria-expanded="false" class="div-coin-box-light my-1"
                            data-flow="bottom" data-tooltip="Outros">
                            <span style="border-bottom-left-radius: 6px;" class="emoji-coin ec-totais">
                                <i style="color: #10B981;" class="fas fa-cash-register"></i>
                            </span>
                            <span class="coin-valor">
                                R$ {{ $coin_outros }}
                            </span>
                        </div>

                        <div class="dropdown-menu dropdown-vg-totais">

                            <div class="d-flex flex-column">
                                <span>
                                    Entrou:
                                    <span style="color: green; white-space: nowrap;">
                                        R$ {{ $coin_outros_entrada }}
                                    </span>
                                </span>
                                <span>
                                    Saiu:
                                    <span style="color: red; white-space: nowrap;">
                                        R$ {{ $coin_outros_saida }}
                                    </span>
                                </span>
                            </div>

                        </div>

                    </div>

                    <div onclick="window.location = '{{ route('retiradas') }}';" style="margin-right: 0;"
                        class="div-coin-box-light my-1" data-flow="bottom" data-tooltip="Retiradas">
                        <span style="border-bottom-left-radius: 6px;" class="emoji-coin ec-totais">
                            <i style="color: #E6274C;" class="fad fa-wallet"></i>
                        </span>
                        <span style="color: #E6274C;" class="coin-valor">
                            - R$ {{ $coin_retiradas }}
                        </span>
                    </div>

                </div>
            </div>
        @elseif($totais == 1)
            <div class="div-view-tt">
                <span wire:click.prevent="ocultarTotais()" class="mr-1 info-total-cx" data-tooltip="Exibir totais"
                    data-flow="bottom">
                    <i class="fa-fw fad fa-eye fa-lg"></i>
                </span>
                <span wire:click.prevent="ocultarTotais()" class="text-show-boxes">Exibir totais</span>
            </div>
        @endif

    </div>
    <div class="vg">

        @if ($rc_soma >= 1)
            <div class="row">
                <div class="col-12">
                    <div class="div-show-all-boxes d-flex flex-row align-items-center justify-content-end">
                        <span wire:click.prevent="mostrarBoxes()" class="text-show-boxes">Exibir tudo
                            ({{ $rc_soma }})</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="row cards-vg">
            @if ($rc_hoje == $rc)
                <div id="mq-col-1" class="col">
                    <div class="block-vg">
                        <div class="title-block fs-title-block d-flex flex-row align-items-center">
                            Saldo&nbsp;
                            <span class="period">/ Hoje</span>
                            <div class="div-details ml-auto">
                                <span data-target="#detalhesHoje" data-toggle="modal" class="details-font">+
                                    Detalhes</span>
                            </div>
                        </div>
                        <div class="value-block mt-3">
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Entradas</span>
                                <span class="value-real">R$ {{ $entradas_hoje }}</span>
                            </div>
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Saídas</span>
                                <span class="value-real">- R$ {{ $saidas_hoje }}</span>
                            </div>
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Retiradas</span>
                                <span class="value-real">- R$ {{ $retiradas_hoje }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Total</span>
                                <span style="font-weight: 500;" class="value-real">R$ {{ $total_hoje }}</span>
                            </div>
                            <div
                                class="total-operations-done mt-2 d-flex flex-row justify-content-between align-items-center">
                                <span>{{ $op_hoje }} operações <span class="bold-span"> realizadas</span></span>
                                <div data-tooltip="Ocultar" data-flow="bottom" class="div-ocult"
                                    wire:click.prevent="ocultarBox(1)">
                                    <i class="fad fa-eye fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($rc_mes == $rc)
                <div id="mq-col-2" class="col">
                    <div class="block-vg">
                        <div class="title-block fs-title-block d-flex flex-row align-items-center">
                            Saldo&nbsp;
                            <span class="period">/ No mês</span>
                            <div class="div-details ml-auto">
                                <span data-target="#detalhesMes" data-toggle="modal" class="details-font">+
                                    Detalhes</span>
                            </div>
                        </div>
                        <div class="value-block mt-3">
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Entradas</span>
                                <span class="value-real">R$ {{ $entradas_mes }}</span>
                            </div>
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Saídas</span>
                                <span class="value-real">- R$ {{ $saidas_mes }}</span>
                            </div>
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Retiradas</span>
                                <span class="value-real">- R$ {{ $retiradas_mes }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Total</span>
                                <span style="font-weight: 500;" class="value-real">R$ {{ $total_mes }}</span>
                            </div>
                            <div
                                class="total-operations-done mt-2 d-flex flex-row justify-content-between align-items-center">
                                <span>{{ $op_mes }} operações <span class="bold-span"> realizadas</span></span>
                                <div data-tooltip="Ocultar" data-flow="bottom" class="div-ocult"
                                    wire:click.prevent="ocultarBox(2)">
                                    <i class="fad fa-eye fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($rc_total == $rc)
                <div id="mq-col-3" class="col">
                    <div class="block-vg">

                        @if ($rendimento)
                            @php $rend_flut = number_format($rendimento, 2, ",", ".");@endphp
                            <div style="user-select: none;" class="rend-flut">+ R$ {{ $rend_flut }}</div>
                        @endif

                        <div class="title-block fs-title-block">
                            Balanço
                            <span class="period">/ Geral</span>
                            <a style="user-select: none;" data-toggle="modal" data-target="#rendimento"
                                class="float-right rendimento">+ Rendimento</a>
                        </div>
                        <div class="value-block mt-3">
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Entradas</span>
                                <span class="value-real">R$ {{ $entradas_total }}</span>
                            </div>
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Saídas</span>
                                <span class="value-real">- R$ {{ $saidas_total }}</span>
                            </div>
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Retiradas</span>
                                <span class="value-real">- R$ {{ $retiradas_total }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                                <span class="type-operation">Total <br> em caixa @if ($rendimento)
                                        <br>c/ rend.
                                    @endif
                                </span>
                                <span style="font-weight: 600; color: #01984E;" class="value-real">R$
                                    {{ $valor_real }}</span>
                            </div>
                            <div
                                class="total-operations-done mt-2 d-flex flex-row justify-content-between align-items-center">
                                <span>{{ $op_total }} operações <span class="bold-span"> realizadas</span></span>
                                <div class="div-left-oc d-flex flex-row align-items-center">
                                    <div data-tooltip="Ocultar" data-flow="bottom" class="div-ocult"
                                        wire:click.prevent="ocultarBox(3)">
                                        <i class="fad fa-eye fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <div class="card">
                        <div class="title-block">
                            Operações realizadas
                            <span class="period">/ Hoje</span>
                        </div>

                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="card-topo mb-3 mt-3">
                                <input wire:model="search" placeholder="buscar operação" class="search-input"
                                    autocomplete="off">
                                <i class="fa fa-search"></i>
                            </div>
                            <div style="margin-top: -12px" class="d-flex align-items-center flex-wrap">
                                <a data-toggle="modal" data-target="#operacao" class="btn btn-new m-1"
                                    id="js-new-op">
                                    + Nova operação &#91; F1 &#93;
                                </a>
                                <a data-toggle="modal" data-target="#venda"
                                    class="btn btn-new-pdv mt-1 mb-1 ml-1 mr-0" id="js-new-venda">

                                    <i class="fal fa-cart-plus fa-fw fa-lg mr-2"></i> Nova venda &#91; F2 &#93;
                                </a>
                            </div>
                        </div>

                        <div style="margin-top: 125px; margin-bottom: 125px;" wire:loading
                            wire:loading.class="d-flex flex-row align-items-center justify-content-center">
                            <i style="color: #725BC2; opacity: 90%;"
                                class="fad fa-spinner-third fa-fw fa-3x fa-spin"></i>
                        </div>

                        <div wire:loading.remove
                            class="card-body px-0 pb-0 pt-1 @if (auth()->user()->table_scroll == 1) table-responsive yampay-scroll-lg @endif">

                            @if ($operations->count())

                                <div class="div-opt-table mb-2">
                                    <a class="home-link my-0" href="{{ route('configuracoes') }}">
                                        <i class="fal fa-cog mr-1"></i>Configurações
                                    </a>
                                </div>

                                <table style="cursor: default;" class="table table-borderless mb-2">
                                    <thead class="t-head">
                                        <tr class="t-head-border">
                                            <th>Cód.</th>
                                            <th style="min-width: 220px;">Descrição</th>
                                            <th>Data</th>
                                            <th>Total</th>
                                            <th width="200px">Categoria</th>
                                            <th>Espécie</th>
                                            <th width="100px">
                                                <div class="d-flex flex-row align-items-center fp-infos">
                                                    FP <i wire:ignore data-toggle="tooltip" data-html="true"
                                                        data-placement="top"
                                                        title='<b><em>Forma de pagamento</em></b> <br> Se selecionado o tipo de <b>Espécie</b> como <b>Outros</b>, você pode definir uma forma de pagamento no cadastro da operação.</span>'
                                                        style="margin-top: 2px;"
                                                        class="fad fa-info-circle fa-fw ml-1 fa-lg fp-info-ico"></i>
                                                </div>
                                            </th>
                                            <th width="100px">Operador</th>
                                            <th width="200px">Operação</th>
                                        </tr>
                                    </thead>
                                    <tbody class="t-body">

                                        @php
                                            $dia_atual = Carbon\Carbon::now();
                                        @endphp

                                        @foreach ($operations as $operation)
                                            @php

                                                $total_operacao = number_format($operation->total, 2, ',', '.');
                                                $data_operacao = $operation->created_at->format('d/m/Y H:i');

                                                $date1 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dia_atual);
                                                $date2 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $operation->created_at);

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

                                                if ($operation->is_venda === 1) {
                                                    $categoria_op = 'Venda';
                                                } elseif ($operation->is_venda === 0) {
                                                    if (is_null($operation->category)) {
                                                        $categoria_op = 'Retirada';
                                                    } else {
                                                        $categoria_op = $operation->category->descricao;
                                                    }
                                                }

                                                if ($operation->especie === 1) {
                                                    $especie_op = 'Dinheiro';
                                                } elseif ($operation->especie === 2) {
                                                    $especie_op = 'Cheque';
                                                } elseif ($operation->especie === 3) {
                                                    $especie_op = 'Moedas';
                                                } elseif ($operation->especie === 4) {
                                                    $especie_op = 'Outros';
                                                }

                                            @endphp

                                            <tr class="tr-hover">

                                                <td class="align-middle">
                                                    <div style="cursor: pointer;" data-tooltip="{{ $operation->id }}"
                                                        data-flow="right" class="div-codigo">
                                                        <i class="fad fa-info-circle fa-fw fa-lg icon-info-cod"></i>
                                                    </div>
                                                </td>
                                                <td style="@if (auth()->user()->table_scroll == 1) word-wrap: break-word @elseif(auth()->user()->table_scroll == 0) word-break: break-all @endif"
                                                    class="align-middle font-desc">{{ $operation->descricao }}</td>
                                                <td style="white-space: nowrap;" class="align-middle">
                                                    {{ $data_operacao }}<br><span class="g-light">há
                                                        {{ $diferenca }} {{ $tempo }}</span></td>
                                                <td style="white-space: nowrap; font-weight: 500;"
                                                    class="align-middle">R$ {{ $total_operacao }}</td>
                                                <td style="@if (auth()->user()->table_scroll == 1) word-wrap: break-word @elseif(auth()->user()->table_scroll == 0) word-break: break-all @endif"
                                                    class="align-middle">
                                                    <span class="categoria">{{ $categoria_op }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="especie">
                                                        {{ $especie_op }}
                                                    </span>
                                                </td>
                                                <td style="word-wrap: break-word;" class="align-middle">
                                                    <span>
                                                        @if (is_null($operation->method_id))
                                                            @if ($operation->is_venda === 1)
                                                                <span style="color: #725BC2; font-weight: 500;">
                                                                    Em detalhes
                                                                </span>
                                                            @else
                                                                @if ($operation->especie == 4)
                                                                    <span style="color: #725BC2; font-weight: 500;">Não
                                                                        especificada</span>
                                                                @else
                                                                    {{ $especie_op }}
                                                                @endif
                                                            @endif
                                                        @else
                                                            {{ $operation->method->descricao }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td style="word-wrap: break-word;" class="align-middle">
                                                    {{ $operation->operator->nome ?? auth()->user()->name }}</td>
                                                @if ($operation->tipo == 1)
                                                    <td class="align-middle"><span style="white-space: nowrap;"
                                                            class="operacao-entrada">Entrada</span></td>
                                                @elseif ($operation->tipo == 3)
                                                    <td class="align-middle"><span style="white-space: nowrap;"
                                                            class="operacao-retirada">Retirada</span></td>
                                                @else
                                                    <td class="align-middle"><span style="white-space: nowrap;"
                                                            class="operacao-saida">Saída</span>
                                                    </td>
                                                @endif

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="211" height="145">
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
                                            <path d="M121.264 47.475c6.093 1.704 9.14 3.238 9.14 4.603"
                                                stroke="#170040" class="C D G" />
                                            <path
                                                d="M3.093 132.455l-.3-33.292L1 98.633v-12.7l42.558-4.92 42.558 4.92v12.7l-1.783.53-.3 33.292-40.465 9.003z"
                                                class="D E H" />
                                            <path fill-opacity=".5" fill="#c2cbd2"
                                                d="M1 86.62l42.558-4.92v62.122l-40.465-7.31-.3-37.35L1 98.633z" />
                                            <g class="D E H">
                                                <path
                                                    d="M3.093 136.513l-.3-37.35 40.775 5.6 40.775-5.6-.3 37.35-40.465 7.607z" />
                                                <path
                                                    d="M1 98.633V86.41l42.558 5.088 42.558-5.088v12.224l-42.558 6.12z" />
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
                                                <rect x="71.03" y="28.917" width="80.334" height="80.487"
                                                    rx="16.744" />
                                                <g class="C G">
                                                    <use xlink:href="#B" />
                                                    <use xlink:href="#B" x="-23.441" />
                                                </g>
                                            </g>
                                            <rect fill-opacity=".7" fill="#e6e9ec" x="75.291" y="32.893"
                                                width="71.86" height="71.86" rx="11.498" class="F" />
                                            <path
                                                d="M97.123 72.242c0 1.8-2.25 3.28-5.023 3.28s-5.023-1.47-5.023-3.28 2.25-3.28 5.023-3.28 5.023 1.47 5.023 3.28m23.44 0c0 1.8 2.25 3.28 5.023 3.28s5.023-1.47 5.023-3.28-2.25-3.28-5.023-3.28-5.023 1.47-5.023 3.28"
                                                class="H" />
                                            <g class="D E">
                                                <path
                                                    d="M94.325 70.656c2.986 0 5.733-2.328 5.733-5.877s-2.328-5.654-5.315-5.654-5.5 2.547-5.5 6.095 2.094 5.436 5.08 5.436z"
                                                    class="B" />
                                                <path d="M94.08 62.234c-.772 1.904-.772 3.548 0 4.932"
                                                    class="C" />
                                                <path
                                                    d="M123.592 70.656c-2.986 0-5.733-2.328-5.733-5.877s2.328-5.654 5.315-5.654 5.5 2.547 5.5 6.095-2.094 5.436-5.08 5.436z"
                                                    class="B" />
                                                <path d="M123.838 62.234c.772 1.904.772 3.548 0 4.932"
                                                    class="C" />
                                                <g class="B">
                                                    <path
                                                        d="M172.708 136.447h-7.356l-1.266-2.218-6.018-10.082-.083-.154c-.895-1.75-.653-3.892 1.096-4.788.14-.072.285-.133.434-.184a3.23 3.23 0 0 1 3.919 1.606c.044.088.102.226.173.414l2.072 6.425c-.09-.562-.566-4.083-1.427-10.565a4.38 4.38 0 0 1 3.985-4.737 4.34 4.34 0 0 1 .558-.012l.25.01c2.464.103 4.378 2.184 4.275 4.647-.003.084-.01.167-.018.25l-1.914 14.53c.024.8.697-1.637 2.02-7.308a2.66 2.66 0 0 1 3.782-1.39c1.49.83 1.588 2.23.763 3.724l-5.247 9.83z" />
                                                    <path
                                                        d="M161.104 130.992c3.01 0 5.462 2.38 5.577 5.362l.003.218h-11.162c.001-3.01 2.382-5.46 5.362-5.576l.22-.004z" />
                                                </g>
                                                <ellipse fill="#a4afb7" cx="108.789" cy="83.823" rx="5.233"
                                                    ry="6.977" />
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
                                    <h3 class="my-4 no-results">Não há operações realizadas hoje.</h3>
                                    <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                                        <h3 class="no-results-create mb-3">Comece criando uma</h3>
                                        <a data-toggle="modal" data-target="#operacao" class="ml-2 btn btn-nr">+ Nova
                                            operação</a>
                                        <h3 class="no-results-create my-3">ou uma</h3>
                                        <a data-toggle="modal" data-target="#venda" class="btn btn-new-pdv-nr ml-2">
                                            <i class="fal fa-cart-plus fa-fw mr-2"></i> Nova venda
                                        </a>
                                    </div>
                                </div>

                            @endif

                        </div>
                        @if (auth()->user()->table_scroll == 1)
                            <div wire:ignore style="width: fit-content; cursor: pointer; user-select: none;"
                                class="tip-scroll mt-3" data-toggle="tooltip" data-html="true"
                                data-placement="right"
                                title="Pressione <b>SHIFT</b> + <b>Scroll do Mouse</b> em cima da tabela para visualizar todo o conteúdo. Ou se preferir, segure e arraste a barra de rolagem.">
                                <span class="info-total-cx">
                                    <i class="fa-fw fad fa-info-circle fa-lg info-ret" aria-hidden="true"></i>
                                </span>
                                <span
                                    style="font-size: 15px !important; color: #666; text-transform: uppercase; font-weight: 600;">Dica</span>
                            </div>
                        @endif
                    </div>
                    <div style="user-select: none; padding-bottom: 150px;"
                        class="d-flex flex-row align-items-center justify-content-between">

                        <div class="resultados d-flex flex-row align-items-center">
                            <select wire:model="qtd" class="form-control modal-input-cat rpp">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                            </select>
                            <span class="ml-3 ipp">Itens por página</span>
                        </div>

                        @if ($operations->hasPages())
                            <div class="paginacao">
                                {{ $operations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Rendimento -->

    <div data-backdrop="static" data-keyboard="false" class="modal fade" id="rendimento" tabindex="-1"
        aria-labelledby="rendimentoLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="rendimentoLabel">Visualizar saldo com rendimento</h5>
                    <button wire:loading.attr="disabled" wire:click.prevent="removeRendimento()" type="button"
                        class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <form>
                        <div class="form-group mb-0">
                            <label class="modal-label" for="total-op">Total do rendimento bancário <span
                                    class="red">*</span></label>
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input wire:keydown.enter.prevent="fechaRendimento()" maxlength="8"
                                    wire:model="rendimento" placeholder="0.00" min="0" type="text"
                                    class="form-control modal-input total-operation" id="total-op2"
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="mt-4 operation-block d-flex flex-row justify-content-between align-items-center">
                            <label class="type-operation mt-1" for="total-op">Total em caixa</label>
                            <span class="value-real">R$ {{ $total_total }}</span>
                        </div>
                        <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                            <label class="type-operation mt-1" for="total-op">Rendimento</label>
                            @php
                                if ($rendimento) {
                                    $rendimento = number_format($rendimento, 2, ',', '.');
                                }
                            @endphp
                            <span class="value-real">+ R$ @if ($rendimento)
                                    {{ $rendimento }}
                                @else
                                    0,00
                                @endif
                            </span>
                        </div>
                        <hr class="my-2">
                        <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                            <label class="type-operation mt-1" for="total-op">Total em caixa<br>com rendimento</label>
                            <span class="value-real">R$ {{ $valor_real }}</span>
                        </div>
                        <div
                            class="total-operations-done mt-2 d-flex flex-row justify-content-between align-items-center">
                            <span>Esta adição é apenas visual.<br>Seu fluxo de caixa <span class="bold-span">não será
                                    afetado.</span></span>
                            <span class="align-self-start"
                                data-tooltip="Este é o valor total que você deve possuir no banco." data-flow="left">
                                <i class="fa-fw fad fa-info-circle fa-lg info-ret"></i>
                            </span>
                        </div>

                </div>
                <div class="modal-footer py-4">
                    <button data-dismiss="modal" wire:loading.attr="disabled" wire:click.prevent="removeRendimento()"
                        type="button" class="btn btn-cancel">Remover</button>
                    <button data-dismiss="modal" type="button" class="btn btn-send">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalhes Receita Hoje -->

    <div class="modal fade" id="detalhesHoje" tabindex="-1" aria-labelledby="detalhesHojeLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="detalhesHojeLabel">Detalhes do saldo <span
                            style="font-weight: 500; text-transform: uppercase; font-size: 22px;">/ Hoje</span></h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">Entradas hoje</label>
                        <span class="value-real">R$ {{ $entradas_hoje }}</span>
                    </div>
                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">Saídas hoje</label>
                        <span class="value-real">- R$ {{ $saidas_hoje }}</span>
                    </div>
                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">Retiradas hoje</label>
                        <span class="value-real">- R$ {{ $retiradas_hoje }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">
                            Saldo hoje
                        </label>
                        <span style="font-weight: 500;" class="value-real">R$ {{ $total_hoje }}</span>
                    </div>
                    <div class="total-operations-done mt-2 d-flex flex-row justify-content-between align-items-center">
                        <span>{{ $op_hoje }} operações <span class="bold-span">realizadas hoje.</span></span>
                        <span class="align-self-start"
                            data-tooltip="Este é o valor total em que o saldo fechará hoje." data-flow="left">
                            <i class="fa-fw fad fa-info-circle fa-lg info-ret"></i>
                        </span>
                    </div>
                    <hr class="mt-3 mb-2">
                    <label class="type-operation mt-2 mb-3">Capital por espécie / <span
                            style="color: #777;">Hoje</span></label>
                    <div style="user-select: none;" class="div-coins mb-0">
                        <div class="row">
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Dinheiro">
                                    <span class="emoji-coin">
                                        <i style="color: #01984E;" class="fad fa-money-bill-alt"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_dinheiro_hj }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_dinheiro_entrada_hj }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_dinheiro_saida_hj }}</span>
                                </span>
                            </div>
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Cheques">
                                    <span class="emoji-coin">
                                        <i style="color: #458DE3;" class="fad fa-money-check-edit-alt"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_cheque_hj }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_cheque_entrada_hj }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_cheque_saida_hj }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Moedas">
                                    <span class="emoji-coin">
                                        <i style="color: #e6c300;" class="fad fa-coins"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_moeda_hj }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_moeda_entrada_hj }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_moeda_saida_hj }}</span>
                                </span>
                            </div>
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Outros">
                                    <span class="emoji-coin">
                                        <i style="color: #10B981;" class="fas fa-cash-register"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_outros_hj }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_outros_entrada_hj }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_outros_saida_hj }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 px-3">
                                <div onclick="window.location = '{{ route('retiradas') }}';"
                                    class="div-coin-box mr-0" data-flow="bottom" data-tooltip="Retiradas">
                                    <span style="border-bottom-left-radius: 6px;" class="emoji-coin ec-totais">
                                        <i style="color: #E6274C;" class="fad fa-wallet"></i>
                                    </span>
                                    <span style="color: #E6274C;" class="coin-valor">
                                        - R$ {{ $coin_retiradas_hj }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button data-dismiss="modal" type="button" class="btn btn-cancel">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalhes Receita Mês -->

    <div class="modal fade" id="detalhesMes" tabindex="-1" aria-labelledby="detalhesMesLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="detalhesMesLabel">Detalhes do saldo <span
                            style="font-weight: 500; text-transform: uppercase; font-size: 22px;">/ No mês</span></h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">Entradas no mês</label>
                        <span class="value-real">R$ {{ $entradas_mes }}</span>
                    </div>
                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">Saídas no mês</label>
                        <span class="value-real">- R$ {{ $saidas_mes }}</span>
                    </div>
                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">Retiradas no mês</label>
                        <span class="value-real">- R$ {{ $retiradas_mes }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="operation-block d-flex flex-row justify-content-between align-items-center">
                        <label class="type-operation mt-1" for="total-op">
                            Saldo no mês
                        </label>
                        <span style="font-weight: 500;" class="value-real">R$ {{ $total_mes }}</span>
                    </div>
                    <div class="total-operations-done mt-2 d-flex flex-row justify-content-between align-items-center">
                        <span>{{ $op_mes }} operações <span class="bold-span">realizadas neste
                                mês.</span></span>
                        <span class="align-self-start"
                            data-tooltip="Este é o valor total em que o saldo fechará neste mês." data-flow="left">
                            <i class="fa-fw fad fa-info-circle fa-lg info-ret"></i>
                        </span>
                    </div>
                    <hr class="mt-3 mb-2">
                    <label class="type-operation mt-2 mb-3">Capital por espécie / <span style="color: #777;">No
                            mês</span></label>
                    <div style="user-select: none;" class="div-coins mb-0">
                        <div class="row">
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Dinheiro">
                                    <span class="emoji-coin">
                                        <i style="color: #01984E;" class="fad fa-money-bill-alt"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_dinheiro_mes }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_dinheiro_entrada_mes }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_dinheiro_saida_mes }}</span>
                                </span>
                            </div>
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Cheques">
                                    <span class="emoji-coin">
                                        <i style="color: #458DE3;" class="fad fa-money-check-edit-alt"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_cheque_mes }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_cheque_entrada_mes }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_cheque_saida_mes }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Moedas">
                                    <span class="emoji-coin">
                                        <i style="color: #e6c300;" class="fad fa-coins"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_moeda_mes }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_moeda_entrada_mes }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_moeda_saida_mes }}</span>
                                </span>
                            </div>
                            <div class="col-6 px-3">
                                <div class="div-coin-box cb-modal" data-flow="bottom" data-tooltip="Outros">
                                    <span class="emoji-coin">
                                        <i style="color: #10B981;" class="fas fa-cash-register"></i>
                                    </span>
                                    <span class="coin-valor">
                                        R$ {{ $coin_outros_mes }}
                                    </span>
                                </div>
                                <span class="d-block small-detail">Entrou: <span style="color: green;">R$
                                        {{ $coin_outros_entrada_mes }}</span>
                                </span>
                                <span class="d-block small-detail small-detail-bottom">Saiu: <span
                                        style="color: red;">R$ {{ $coin_outros_saida_mes }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 px-3">
                                <div onclick="window.location = '{{ route('retiradas') }}';"
                                    class="div-coin-box mr-0" data-flow="bottom" data-tooltip="Retiradas">
                                    <span style="border-bottom-left-radius: 6px;" class="emoji-coin ec-totais">
                                        <i style="color: #E6274C;" class="fad fa-wallet"></i>
                                    </span>
                                    <span style="color: #E6274C;" class="coin-valor">
                                        - R$ {{ $coin_retiradas_mes }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button data-dismiss="modal" type="button" class="btn btn-cancel">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</div>

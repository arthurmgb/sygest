<div>
    <div class="page-header d-flex flex-row align-items-center">
        <h2 class="f-h2">Fluxo de caixa</h2>
        <span class="f-span">{{ $operations_count }} operações</span>
    </div>
    <div style="gap: 5px;" class="page-filters d-flex flex-row align-items-center justify-content-start flex-wrap">

        <a wire:click.prevent="changeOption([1,0])" wire:loading.attr="disabled"
            class="filter-base filter-ops @if ($option == [1, 0]) filter-10 @endif">
            <span>Todas as operações</span>
        </a>
        <a wire:click.prevent="changeOption([1])" wire:loading.attr="disabled"
            class="filter-base filter-entrada @if ($option == [1]) filter-1 @endif">
            <span>Operações de entrada</span>
        </a>
        <a wire:click.prevent="changeOption([0])" wire:loading.attr="disabled"
            class="filter-base filter-saida @if ($option == [0]) filter-0 @endif">
            <span>Operações de saída</span>
        </a>
        <a wire:click.prevent="geraReceita()" wire:loading.attr="disabled"
            class="filter-base filter-soma @if ($receita == true) filter-s @endif">
            <span>Exibir <br>saldo</span>
        </a>
        <small class="text-muted ml-auto align-self-end">
            Para realizar operações, navegue até
            <a class="verify-font" href="{{ route('geral') }}">Visão geral</a>.
        </small>
    </div>
    <div class="block">
        <div class="card">

            <div class="card-topo mb-3">
                <input wire:model="search" placeholder="buscar operação" class="search-input" autocomplete="off">
                <i class="fa fa-search"></i>
            </div>

            <div style="margin-top: 125px; margin-bottom: 125px;" wire:loading
                wire:loading.class="d-flex flex-row align-items-center justify-content-center">
                <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-3x fa-spin"></i>
            </div>

            <div wire:loading.remove
                class="card-body px-0 pb-0 pt-1 js-scrollable-table @if ($receita) pt-1 @endif @if (auth()->user()->table_scroll == 1) table-responsive yampay-scroll-lg @endif"
                onmousedown="startDragging(event)">

                @if ($operations->count())

                    @if ($receita and $search != true)

                        <div class="receita-alert d-flex flex-column align-items-start">

                            @if ($option == [1, 0])
                                <span>
                                    Total de entradas:
                                    <b style="color: #00A3A3;">
                                        R$ {{ $receita_entrada }}
                                    </b>
                                </span>

                                <span>
                                    Total de saídas:
                                    <b style="color: #E6274C;">
                                        - R$ {{ $receita_saida }}
                                    </b>
                                </span>
                            @endif

                            <span>
                                Saldo:
                                <b
                                    style="@if ($option == [0]) color: #E6274C; @elseif($option == [1]) color: #00A3A3; @endif">
                                    @if ($option == [0])
                                        -
                                    @endif R$ {{ $receita_valor }}
                                </b>
                            </span>

                            <span>
                                Total de operações:
                                <b>
                                    {{ $operations_find }}
                                </b>
                            </span>

                            <span>
                                Operações na página:
                                <b>
                                    {{ $operations->count() }}
                                </b>
                            </span>

                            <div class="d-flex flex-row align-items-center ml-auto">

                                <a class="limpar-filtro" wire:click.prevent="geraReceita()" href="#">
                                    Remover filtro
                                </a>

                                @if ($option == [1, 0])
                                    <span style="cursor: pointer;" wire:ignore class="ml-2" data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="O total das retiradas não é considerado no fluxo de caixa, portanto o saldo aqui calculado não corresponde ao seu total em caixa.">
                                        <i class="fa-fw fad fa-info-circle fa-lg info-ret mt-1"></i>
                                    </span>
                                @endif
                            </div>

                        </div>

                    @endif

                    <div class="div-opt-table my-2">
                        <a class="home-link my-0" href="{{ route('configuracoes') }}">
                            <i class="fal fa-cog mr-1"></i>Configurações
                        </a>
                    </div>

                    <table style="cursor: default;" class="table table-borderless mb-2">
                        <thead class="t-head">
                            <tr class="t-head-border">
                                <th>Cód.</th>
                                <th style="min-width: 220px;">Descrição</th>
                                <th>Imagem</th>
                                <th>Data</th>
                                <th>Total</th>
                                <th width="200px">Categoria</th>
                                <th>Espécie</th>
                                <th width="100px">
                                    <div class="d-flex flex-row align-items-center fp-infos">
                                        FP <i wire:ignore data-toggle="tooltip" data-html="true" data-placement="left"
                                            title='<b><em>Forma de pagamento</em></b> <br> Se selecionado o tipo de <b>Espécie</b> como <b>Outros</b>, você pode definir uma forma de pagamento no cadastro da operação.</span>'
                                            style="margin-top: 2px;"
                                            class="fad fa-info-circle fa-fw ml-1 fa-lg fp-info-ico"></i>
                                    </div>
                                </th>
                                <th width="100px">Operador</th>
                                <th width="200px">Operação</th>
                                <th>Detalhes</th>
                                <th>Ações</th>
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
                                    <td class="align-middle">
                                        @if ($operation->imagem)
                                            <img style="object-fit: contain; user-select: none; -webkit-user-drag: none; user-drag: none;"
                                                width="50" height="50"
                                                src="{{ asset('storage/' . $operation->imagem) }}">
                                            <button wire:click.prevent="showAttachedImage({{ $operation->id }})"
                                                wire:target="showAttachedImage({{ $operation->id }})"
                                                wire:loading.attr="disabled" data-toggle="modal"
                                                data-target="#operation-attachment"
                                                class="btn btn-sm btn-link mt-1 verify-font"
                                                style="font-size: 14px !important;">
                                                Abrir
                                            </button>
                                        @elseif($operation->is_venda === 1)
                                            <i>Não se aplica</i>
                                        @else
                                            <i>Nenhuma</i>
                                        @endif
                                    </td>
                                    <td style="white-space: nowrap;" class="align-middle">
                                        {{ $data_operacao }}<br><span class="g-light">há
                                            {{ $diferenca }} {{ $tempo }}</span></td>
                                    <td style="white-space: nowrap; font-weight: 500;" class="align-middle">R$
                                        {{ $total_operacao }}</td>
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
                                                        <span style="color: #725BC2; font-weight: 500;">
                                                            Não
                                                            especificada
                                                        </span>
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
                                    <td class="align-middle text-center">
                                        @if ($operation->is_venda === 1)
                                            <div class="toggleCollapseIcon" style="cursor: pointer;"
                                                data-toggle="collapse" data-target="#fold-{{ $operation->id }}"
                                                aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fad fa-plus-circle fa-fw fa-2x icon-info-cod"></i>
                                                <i class="fad fa-minus-circle fa-fw fa-2x icon-info-cod"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-row align-items-center">
                                            <div wire:target="prepareToDelete({{ $operation->id }})"
                                                wire:loading.attr="disabled"
                                                wire:click.prevent="prepareToDelete({{ $operation->id }})"
                                                data-toggle="modal" data-target="#delete-this-confirmation"
                                                data-tooltip="Apagar" data-flow="left" class="cba mr-2">
                                                <i class="fad fa-trash fa-fw fa-crud fac-del"></i>
                                            </div>
                                            @if ($operation->is_venda === 1)
                                                <div wire:target="showCnf({{ $operation->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:click.prevent="showCnf({{ $operation->id }})"
                                                    data-toggle="modal" data-target="#operation-receipt"
                                                    data-tooltip="Cupom" data-flow="left" class="cba">
                                                    <i class="fad fa-receipt fa-fw fa-crud fac-link"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr wire:ignore.self class="collapse bg-light" id="fold-{{ $operation->id }}">
                                    <td class="p-4" colspan="12">
                                        <h6 class="mb-3">Detalhes da venda</h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <b>Total da venda</b>
                                                <br>
                                                {{ 'R$ ' . number_format($operation->total_venda, 2, ',', '.') }}
                                            </li>
                                            <li class="list-group-item">
                                                <b>Valor pago</b>
                                                <br>
                                                {{ 'R$ ' . number_format($operation->valor_pago, 2, ',', '.') }}
                                            </li>
                                            <li class="list-group-item">
                                                <b>Troco</b>
                                                <br>
                                                {{ 'R$ ' . number_format($operation->troco, 2, ',', '.') }}
                                            </li>
                                            <li class="list-group-item">
                                                <b>Desconto</b>
                                                <br>
                                                {{ 'R$ ' . number_format($operation->desconto, 2, ',', '.') }}
                                            </li>
                                            <li class="list-group-item">
                                                <b>Adicional</b>
                                                <br>
                                                {{ 'R$ ' . number_format($operation->adicional, 2, ',', '.') }}
                                            </li>
                                            <li class="list-group-item">
                                                <b style="font-size: 14px;">SUBTOTAL</b>
                                                <br>
                                                <span style="font-size: 14px;"
                                                    class="text-success font-weight-bold">{{ 'R$ ' . $total_operacao }}</span>
                                            </li>
                                        </ul>
                                        <h6 class="my-3">Produtos vendidos</h6>
                                        <table class="table table-striped table-hover table-sm mini-table border mb-3">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="20" class="px-3">
                                                    </th>
                                                    <th scope="col">Produto</th>
                                                    <th scope="col">Preço un.</th>
                                                    <th scope="col">Quantidade</th>
                                                    <th scope="col">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="mini-table-body">
                                                @foreach ($operation->products as $item_product)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->index += 1 }}
                                                        </td>
                                                        <td style="max-width: 200px;">
                                                            {{ $item_product->nome_produto }}
                                                        </td>
                                                        <td class="font-weight-bold">
                                                            R$
                                                            {{ number_format($item_product->preco_unitario, 2, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            &#215;{{ $item_product->quantidade_vendida }}
                                                        </td>
                                                        <td class="font-weight-bold text-success">
                                                            R$
                                                            {{ number_format($item_product->subtotal_vendido, 2, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <h6 class="mb-3">Formas de pagamento</h6>

                                        <table class="table table-striped table-hover table-sm mini-table border mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="20" class="px-3">
                                                    </th>
                                                    <th scope="col">Forma de pagamento</th>
                                                    <th scope="col">Valor pago</th>
                                                </tr>
                                            </thead>
                                            <tbody class="mini-table-body">
                                                @foreach ($operation->operationMethods as $item_method)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->index += 1 }}
                                                        </td>
                                                        <td style="max-width: 200px;">
                                                            {{ $item_method->nome_fp }}
                                                        </td>
                                                        <td class="font-weight-bold">
                                                            R$
                                                            {{ number_format($item_method->valor_pago, 2, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </td>
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
                        <h3 class="my-4 no-results">Não há operações a serem exibidas.</h3>
                    </div>

                @endif
            </div>
            @if (auth()->user()->table_scroll == 1)
                <div wire:ignore style="width: fit-content; cursor: pointer; user-select: none;"
                    class="tip-scroll mt-3" data-toggle="tooltip" data-html="true" data-placement="right"
                    title="Clique e arraste o mouse em cima da tabela para visualizar todo o conteúdo. Ou se preferir, pressione <b>SHIFT</b> + <b>Scroll do Mouse</b>.">
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
    <!-- Modal Deletar Confirmação -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="delete-this-confirmation"
        tabindex="-1" aria-labelledby="delete-this-confirmationLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="delete-cat-confirmationLabel">Confirmação de apagamento</h5>
                    <button type="button" class="close px-4" data-dismiss="modal"
                        wire:click.prevent="resetDelete()" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente apagar esta operação?
                    </h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            Ao clicar em <span class="msg-bold">Confirmar</span>, esta operação será
                            apagada completamente.
                            <br>
                            <span class="msg-bold text-uppercase text-danger">Atenção:</span> Esta ação é irreversível
                            e a operação <b>NÃO</b> poderá ser recuperada!
                        </p>
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal"
                        wire:click.prevent="resetDelete()">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="delete()" type="button"
                        class="btn btn-send">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cupom -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="operation-receipt" tabindex="-1"
        aria-labelledby="operation-receiptLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" style="max-width: 80mm;">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 style="font-size: 20px !important;" class="modal-title p-1"
                        id="delete-cat-confirmationLabel">Cupom <b>não</b> fiscal</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-0 printable d-flex flex-row align-items-start justify-content-start">

                    <div wire:loading.class="blur-cnf" class="cnf-container d-flex flex-column align-items-center p-2"
                        style="width: 90vw;">
                        <p class="cnf-fantasia font-weight-bold mb-0 text-center">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="mb-0 text-center">
                            @if (!is_null(auth()->user()->razao_social) && !empty(auth()->user()->razao_social))
                                {{ auth()->user()->razao_social }}
                            @else
                                <span style="color: red;">---</span>
                            @endif
                        </p>
                        <p class="mb-0 text-center">

                            @php
                                if (!is_null(auth()->user()->endereco) && !empty(auth()->user()->endereco)) {
                                    $user_endereco = auth()->user()->endereco;
                                } else {
                                    $user_endereco = '<span style="color: red;">---</span>';
                                }
                                if (!is_null(auth()->user()->cidade) && !empty(auth()->user()->cidade)) {
                                    $user_cidade = auth()->user()->cidade;
                                } else {
                                    $user_cidade = '<span style="color: red;">---</span>';
                                }
                                if (!is_null(auth()->user()->estado) && !empty(auth()->user()->estado)) {
                                    $user_estado = auth()->user()->estado;
                                } else {
                                    $user_estado = '<span style="color: red;">---</span>';
                                }
                            @endphp

                            {!! $user_endereco . ' - ' . $user_cidade . '/' . $user_estado !!}

                        </p>
                        <p class="mb-2">
                            @if (!is_null(auth()->user()->celular) && !empty(auth()->user()->celular))
                                {{ auth()->user()->celular }}
                            @else
                                <span style="color: red;">---</span>
                            @endif
                        </p>
                        <p class="align-self-start mb-2">
                            CNPJ: {!! auth()->user()->documento ?? "<span style='color: red;'>---</span>" !!}
                        </p>
                        <p class="align-self-start mb-1">CLIENTE: CONSUMIDOR FINAL</p>
                        <p style="overflow-wrap: anywhere;" class="align-self-start mb-1">
                            @if ($cnfData)
                                {{ $cnfData->created_at->format('d/m/Y H:i') }}
                            @endif
                        </p>
                        <p class="cnf-title font-weight-bold mb-0">CUPOM NÃO FISCAL</p>
                        <table
                            class="table table-sm cnf-table border border-secondary border-right-0 border-left-0 my-1">
                            <thead>
                                <tr>
                                    <th width="150" class="font-weight-normal align-middle border-secondary"
                                        scope="col">
                                        DESCRIÇÃO</th>
                                    <th class="font-weight-normal align-middle border-secondary" scope="col">QTD X
                                        UNIT</th>
                                    <th class="font-weight-normal align-middle border-secondary" scope="col">R$
                                        TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cnfData)
                                    @foreach ($cnfData->products as $cnfItemProduct)
                                        <tr class="font-weight-bold">
                                            <td class="align-middle">{{ $cnfItemProduct->nome_produto }}</td>
                                            <td class="align-middle">{{ $cnfItemProduct->quantidade_vendida }} x
                                                {{ number_format($cnfItemProduct->preco_unitario, 2, ',', '.') }}</td>
                                            <td class="align-middle">
                                                {{ number_format($cnfItemProduct->subtotal_vendido, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div
                            class="align-self-start d-flex flex-row align-items-center justify-content-between w-100 cnf-resumo font-weight-bold">
                            <p class="mb-1">Total da venda R$</p>
                            <p class="mb-1">
                                @if ($cnfData)
                                    {{ number_format($cnfData->total_venda, 2, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        <div
                            class="align-self-start d-flex flex-row align-items-center justify-content-between w-100 cnf-resumo font-weight-bold">
                            <p class="mb-1">Adicional R$</p>
                            <p class="mb-1">
                                @if ($cnfData)
                                    {{ number_format($cnfData->adicional, 2, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        <div
                            class="align-self-start d-flex flex-row align-items-center justify-content-between w-100 cnf-resumo font-weight-bold">
                            <p class="mb-1">Desconto R$</p>
                            <p class="mb-1">
                                @if ($cnfData)
                                    {{ number_format($cnfData->desconto, 2, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        <div
                            class="align-self-start d-flex flex-row align-items-center justify-content-between w-100 cnf-resumo font-weight-bold">
                            <p class="mb-1">Total da nota R$</p>
                            <p class="mb-1">
                                @if ($cnfData)
                                    <b>{{ number_format($cnfData->total, 2, ',', '.') }}</b>
                                @endif
                            </p>
                        </div>
                        <div
                            class="align-self-start d-flex flex-row align-items-center justify-content-between w-100 cnf-resumo font-weight-bold">
                            <p class="mb-1">Valor recebido R$</p>
                            <p class="mb-1">
                                @if ($cnfData)
                                    {{ number_format($cnfData->valor_pago, 2, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        <div
                            class="align-self-start d-flex flex-row align-items-center justify-content-between w-100 cnf-resumo font-weight-bold">
                            <p class="mb-3">Troco R$</p>
                            <p class="mb-3">
                                @if ($cnfData)
                                    {{ number_format($cnfData->troco, 2, ',', '.') }}
                                @endif
                            </p>
                        </div>

                        <p class="align-self-start font-weight-bold cnf-resumo mb-1">FORMAS DE PGTO.</p>

                        <table
                            class="table table-sm cnf-table border border-secondary border-right-0 border-left-0 my-1">
                            <thead>
                                <tr>
                                    <th class="font-weight-normal align-middle border-secondary" scope="col">
                                        DATA PGTO.</th>
                                    <th class="font-weight-normal align-middle border-secondary" scope="col">
                                        VALOR R$
                                    </th>
                                    <th class="font-weight-normal align-middle border-secondary" scope="col">
                                        TIPO PGTO.
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cnfData)
                                    @foreach ($cnfData->operationMethods as $cnfItemMethod)
                                        <tr class="font-weight-bold">
                                            <td style="white-space: nowrap" class="align-middle">
                                                {{ $cnfData->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="align-middle">
                                                {{ number_format($cnfItemMethod->valor_pago, 2, ',', '.') }}</td>
                                            <td class="align-middle">{{ $cnfItemMethod->nome_fp }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <p class="w-100 align-self-start py-1 my-0 border-bottom border-secondary">
                            VENDEDOR(A): @if ($cnfData)
                                {{ $cnfData->operator->nome }}
                            @endif
                        </p>

                        <p class="w-100 mt-5 text-center border-top border-secondary font-weight-bold">
                            * OBRIGADO E VOLTE SEMPRE! *
                        </p>


                    </div>

                </div>
                <div class="modal-footer p-2 d-flex flex-column align-items-center">
                    <button type="button" class="btn btn-cancel w-100 mx-0 mt-0 mb-2"
                        data-dismiss="modal">Fechar</button>
                    <button id="print-cnf" wire:loading.attr="disabled" wire:click.prevent="" type="button"
                        class="btn btn-send w-100 m-0">Imprimir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Anexo -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="operation-attachment" tabindex="-1"
        aria-labelledby="operation-attachmentLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 style="font-size: 20px !important;" class="modal-title p-1"
                        id="delete-cat-confirmationLabel">Imagem anexada</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close"
                        wire:click.prevent="resetAttachedImage" wire:loading.attr="disabled">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-0 d-flex flex-row justify-content-center">

                    <img id="img-anexo" src="{{ asset('storage/' . $attachment) }}" alt="Anexo não encontrado"
                        wire:loading.remove>

                </div>
                <div class="modal-footer p-2 d-flex flex-column align-items-center">
                    <button type="button" class="btn btn-cancel w-100 mx-0 mt-0 mb-2" data-dismiss="modal"
                        wire:click.prevent="resetAttachedImage" wire:loading.attr="disabled">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div>

    <div class="page-header d-flex flex-row align-items-center mb-2">
        <h2 class="f-h2">Ferramentas</h2>
    </div>

    <div class="block">

        <div class="row">
            <div class="col-6">
                <div class="card">
                    
                    <div class="card-topo mb-1">
                        <div class="title-block f-calc">
                            Calculadora Simples
                            <span class="period">/ Operações básicas</span>
                        </div>                     
                    </div>
                    <div class="select-op my-2 d-flex flex-row">
                        <div class="label-select-op">
                            <span style="color: #725bc2 !important;" class="title-block f-calc">Escolha a operação:</span>
                        </div>
                        <div class="buttons-op ml-2">
                            <button wire:loading.attr="disabled" wire:click.prevent="calc_simples(1)" class="@if($op == 1) btn-operation @else btn-operation-v2 @endif">
                                <i class="far fa-plus"></i>
                            </button>
                            <button wire:loading.attr="disabled" wire:click.prevent="calc_simples(2)" class="@if($op == 2) btn-operation @else btn-operation-v2 @endif ml-1">
                                <i class="far fa-minus"></i>
                            </button>
                            <button wire:loading.attr="disabled" wire:click.prevent="calc_simples(3)" class="@if($op == 3) btn-operation @else btn-operation-v2 @endif ml-1">
                                <i class="far fa-times"></i>
                            </button>
                            <button wire:loading.attr="disabled" wire:click.prevent="calc_simples(4)" class="@if($op == 4) btn-operation @else btn-operation-v2 @endif ml-1">
                                <i class="far fa-divide"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-op">
                        <div class="d-inline-block py-2">
                            <span class="type-calc ml-0 d-inline">Número 1</span>
                            <input wire:model="numero1" min="0" type="number" class="input-op d-inline" autocomplete="off">
                        </div>
                        <div class="d-inline-block py-2">
                            <span class="type-calc d-inline">Número 2</span>
                            <input wire:model="numero2" min="0" type="number" class="input-op d-inline" autocomplete="off">                           
                        </div>
                    </div>
                    <div class="box-result">
                        <span class="result-calc">Resultado:</span>
                        <div class="value-calc mx-1" wire:target="render, calc_simples, numero1, numero2" wire:loading>
                            <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                        </div>
                        <span wire:target="calc_simples, numero1, numero2" wire:loading.remove class="value-calc mx-1">@if($result){{$result}}@elseif($result == 0) 0 @else---@endif</span>
                    </div>
                    
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-topo mb-1">
                        <div class="title-block f-calc">
                            Calculadora de Regra de 3
                            <span class="period">/ Simples</span>
                        </div>                     
                    </div>
                    <div class="box-op d-block">
                        <input wire:click="reset_copy()" wire:model="a" placeholder="A" min="0" type="number" class="input-op d-inline-block my-2" autocomplete="off">                     
                        <span class="type-calc-v2 d-inline-block my-2">Está para</span>
                        <input wire:click="reset_copy()" wire:model="b" placeholder="B" min="0" type="number" class="input-op d-inline-block my-2" autocomplete="off">
                    </div>
                    <div class="divisor-calc d-flex flex-row align-items-center">
                        <span class="divisor-label">Assim como</span>
                    </div>
                    <div class="box-op d-block mb-0">       
                        <input wire:click="reset_copy()" wire:model="c" placeholder="C" min="0" type="number" class="input-op d-inline-block mt-2" autocomplete="off">                     
                        <span class="type-calc-v2 d-inline-block mt-2">Está para</span>
                        <span wire:click="copied(1)" class="result-to-copy" data-clipboard-target="#rd3" @if($copy == 1) data-tooltip="Copiado!" @else data-tooltip="Copiar" @endif data-flow="right">
                            <input id="rd3" @if($result_rd3 != 'X') value="{{ $result_rd3 }}" @elseif($result_rd3 == 'X') placeholder="X" @endif min="0" type="text" class="input-op input-x d-inline-block mt-2" readonly autocomplete="off">                       
                        </span>                       
                        <div class="mx-1" wire:target="render, a, b, c" wire:loading>
                            <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                        </div>
                    </div>                     
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    
                    <div class="card-topo mb-1">
                        <div class="title-block f-calc">
                            Calculadora de Porcentagem
                            <span class="period">/ %</span>
                        </div>                     
                    </div>
                    <div class="box-op">
                        <div class="d-inline-block py-2">
                            <span class="type-calc ml-0 d-inline">Quanto é</span>
                            <input wire:model="p1" min="0" type="number" class="input-op d-inline" autocomplete="off">
                            <i class="fas fa-percent icon-calc d-inline"></i>
                        </div>
                        <div class="d-inline-block py-2">
                            <span class="type-calc d-inline">de</span>
                            <input wire:model="p2" min="0" type="number" class="input-op d-inline" autocomplete="off">
                            <span class="type-calc d-inline">?</span>
                        </div>
                    </div>

                    <div class="box-result">
                        <span class="result-calc">Resultado:</span>
                        <div class="value-calc mx-1" wire:target="render, p1, p2" wire:loading>
                            <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                        </div>
                        <span wire:target="p1, p2" wire:loading.remove class="value-calc mx-1">@if($result_percent){{$result_percent}}@else---@endif</span>
                    </div>
                    
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    
                    <div class="card-topo mb-1">
                        <div class="title-block f-calc">
                            Calculadora de Porcentagem
                            <span class="period">/ Inversa</span>
                        </div>                     
                    </div>
                    <div class="box-op">
                        <div class="d-inline-block py-2">
                            <span class="type-calc ml-0 d-inline">O valor</span>
                            <input wire:model="i1" min="0" type="number" class="input-op d-inline" autocomplete="off">                           
                        </div>
                        <div class="d-inline-block py-2">
                            <span class="type-calc d-inline ml-0">é qual porcentagem de</span>
                            <input wire:model="i2" min="0" type="number" class="input-op d-inline" autocomplete="off">
                            <span class="type-calc d-inline">?</span>
                        </div>
                    </div>

                    <div class="box-result">
                        <span class="result-calc">Resultado:</span>
                        <div class="value-calc mx-1" wire:target="render, i1, i2" wire:loading>
                            <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                        </div>
                        <span wire:target="i1, i2" wire:loading.remove class="value-calc mx-1">@if($result_percent_i){{$result_percent_i}}%@else---@endif</span>
                    </div>
                    
                </div>
            </div>
        </div>
        <img class="urso-img" style="transform: scaleX(-1); position: absolute; margin-top: -134px; margin-left: 250px;" src="{{asset('vendor/adminlte/dist/img/no-results-300.png')}}">
        <img class="urso-img" style="position: absolute; margin-top: -101px;" src="{{asset('vendor/adminlte/dist/img/no-results-300.png')}}">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-topo mb-1">
                        <div class="title-block f-calc">
                            Precificação de Produtos
                            <span class="period">/ Margem de lucro</span>
                        </div>                     
                    </div>
                    <div class="box-op">
                        <div class="d-inline-block py-2">
                            <span class="type-calc ml-0 d-inline">O preço de custo do meu produto é</span>
                            <input wire:model="mdl1" min="0" type="number" class="input-op d-inline" autocomplete="off">                           
                        </div>
                        <div class="d-inline-block py-2">
                            <span class="type-calc d-inline">, quero lucrar</span>
                            <input wire:model="mdl2" min="0" type="number" class="input-op d-inline" autocomplete="off">
                            <i class="fas fa-percent icon-calc d-inline"></i>
                            <span class="type-calc d-inline">sobre esse valor.</span>
                        </div>
                    </div>

                    <div class="box-result">
                        <span class="result-calc">Devo vender meu produto por:</span>
                        <div class="value-calc mx-1" wire:target="render, mdl1, mdl2" wire:loading>
                            <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-lg fa-spin"></i>
                        </div>
                        <span wire:target="mdl1, mdl2" wire:loading.remove class="value-calc mx-1">@if(!is_numeric($result_mdl)){{$result_mdl}}@elseif($result_mdl)R$ {{$result_mdl}}@else---@endif</span>
                    </div>
                    
                </div>
            </div>
        </div>
                
    </div>

    <div style="user-select: none; padding-bottom: 150px;"
            class="d-flex flex-row align-items-center justify-content-between">
    </div>

</div>

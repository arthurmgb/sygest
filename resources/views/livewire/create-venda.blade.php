<div>
    <!-- Modal Operação-->
    <div class="modal modal-pdv" id="venda" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="vendaLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-pdv">
            <div class="modal-content modal-custom modal-pdv-content">
                <div class="modal-header pt-2 pb-1 px-2 pdv-header">
                    <h5 class="modal-title px-0 py-0" id="vendaLabel">
                        <i class="far fa-shopping-cart fa-fw mr-3"></i>PDV - Nova venda
                    </h5>
                    <button style="color: #fff; opacity: 1;" type="button" class="close py-1 m-0" data-dismiss="modal"
                        aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body px-2 py-0 modal-pdv-body">
                    <div class="container-fluid h-100">
                        <div class="row h-100">
                            <div class="col-4 p-2 h-100">
                                <form class="h-100">
                                    <div
                                        class="pdv-flex d-flex flex-column align-items-center justify-content-between h-100">
                                        <div class="pdv-left w-100">
                                            <div class="form-group my-2">
                                                <label class="modal-label">
                                                    Produtos
                                                    <span class="red">*</span>
                                                </label>
                                                <div wire:ignore>
                                                    <select wire:loading.attr="disabled" id="prod-select"
                                                        placeholder="Selecione um produto">
                                                        <option value="">Selecione um
                                                            produto</option>
                                                        @foreach ($produtos as $produto)
                                                            <option value="{{ $produto->id }}">
                                                                {{ $produto->descricao . ' - R$ ' . number_format($produto->preco, 2, ',', '.') }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                @error('selectedProduct')
                                                    <span class="wire-error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="modal-label">
                                                            Em estoque
                                                        </label>
                                                        <input wire:keydown.enter.prevent="addProduct"
                                                            wire:model.defer="estoqueAtual" readonly type="number"
                                                            class="form-control modal-input" autocomplete="off"
                                                            wire:loading.attr="disabled">
                                                    </div>
                                                    <div class="col">
                                                        <label class="modal-label">
                                                            Quantidade
                                                            <span class="red">*</span>
                                                        </label>
                                                        <input wire:loading.attr="disabled"
                                                            wire:keydown.enter.prevent="addProduct"
                                                            wire:model.defer="quantidadeAdicionada" type="text"
                                                            class="form-control modal-input qtd-item" autocomplete="off"
                                                            placeholder="0-99999">
                                                        @error('quantidadeAdicionada')
                                                            <span class="wire-error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button wire:loading.attr="disabled" type="button"
                                                wire:click.prevent="addProduct"
                                                class="btn btn-new btn-block">Adicionar</button>
                                            <hr>
                                        </div>
                                        <div class="pdv-left w-100">
                                            @empty($produtosAdicionados)
                                                <div class="pdv-caixa-livre">
                                                    <h1 class="text-uppercase text-center text-white p-3 mb-0">
                                                        Caixa livre
                                                    </h1>
                                                </div>
                                            @endempty
                                        </div>
                                    </div>
                            </div>
                            <div class="col-8 border-left py-2 px-0 d-flex flex-column justify-content-between mh-100">
                                <div class="produtos-adicionados flex-fill">
                                    <table
                                        class="table table-striped table-sm table-hover text-center table-pdv-produtos">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Produto</th>
                                                <th scope="col">Preço un.</th>
                                                <th scope="col">Quantidade</th>
                                                <th scope="col">Subtotal</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="produtos-adicionados-body">
                                            @foreach ($produtosAdicionados as $produtoItem)
                                                @php
                                                    $num_item = $loop->index;
                                                    $num_item += 1;
                                                @endphp
                                                <tr wire:key="{{ $loop->index }}">
                                                    <td><b>{{ $num_item }}</b></td>
                                                    <td style="max-width: 200px">{{ $produtoItem['descricao'] }}</td>
                                                    <td><b>R$
                                                            {{ number_format($produtoItem['preco'], 2, ',', '.') }}</b>
                                                    </td>
                                                    <td>&#215;{{ $produtoItem['quantidade'] }}</td>
                                                    <td><b class="text-success">R$
                                                            {{ number_format($produtoItem['subtotal'], 2, ',', '.') }}</b>
                                                    </td>
                                                    <td>
                                                        <i title="Remover" style="cursor: pointer;"
                                                            wire:click="removeProduct({{ $loop->index }})"
                                                            class="fad fa-trash-alt fa-fw text-danger fa-lg"></i>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row border-top pt-3 px-2 ml-0">
                                    <div class="col-6 border-right h-100">
                                        <div class="form-group mb-2">
                                            <label class="modal-label">
                                                Forma de pagamento
                                                <span class="red">*</span>
                                            </label>
                                            <div wire:ignore>
                                                <select wire:loading.attr="disabled" id="pdv-fp-select"
                                                    placeholder="Selecione uma forma de pag.">
                                                    <option value="">
                                                        Selecione uma forma de pag.
                                                    </option>
                                                    <option value="1">💵 Dinheiro</option>
                                                    <option value="2">💲 Cheque</option>
                                                    <option value="3">💰 Moedas</option>
                                                    @foreach ($fps as $fp)
                                                        <option value="{{ $fp->id }}">
                                                            {{ $fp->descricao }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('selectedFp')
                                                <span class="wire-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="modal-label">
                                                Valor desta forma de pagamento
                                                <span class="red">*</span>
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><b>R$</b></span>
                                                </div>
                                                <input id="pdv-fp-val" wire:model.defer="valorDaFp"
                                                    placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation precos-mask"
                                                    autocomplete="off"
                                                    @if (empty($selectedFp)) disabled @endif>
                                            </div>
                                            @error('valorDaFp')
                                                <span class="wire-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button wire:click.prevent="addFp" wire:loading.attr="disabled"
                                            type="button" class="btn btn-new btn-block">Adicionar</button>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Total da venda
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><b>R$</b></span>
                                                </div>
                                                <input wire:model="totalVenda" readonly placeholder="0,00"
                                                    type="text" class="form-control modal-input total-operation"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Valor pago
                                                <span class="red">*</span>
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><b>R$</b></span>
                                                </div>
                                                <input wire:model="valorPago" placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation precos-mask"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            @php
                                                $check_troco = $troco;
                                                $check_troco = str_replace('.', '', $check_troco);
                                                $check_troco = str_replace(',', '.', $check_troco);
                                                $check_troco = floatval($check_troco);
                                            @endphp
                                            <label class="modal-label">
                                                Troco
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span
                                                        style="@if ($check_troco < 0) border-color: red; @endif"
                                                        class="input-group-text"><b>R$</b></span>
                                                </div>
                                                <input wire:model="troco" readonly placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation"
                                                    autocomplete="off"
                                                    style="@if ($check_troco < 0) border-color: red; @endif">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Desconto
                                                <small>(opcional)</small>
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><b>R$</b></span>
                                                </div>
                                                <input wire:model="desconto" placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation precos-mask"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            @php
                                                $check_stv = $subtotalVenda;
                                                $check_stv = str_replace('.', '', $check_stv);
                                                $check_stv = str_replace(',', '.', $check_stv);
                                                $check_stv = floatval($check_stv);
                                            @endphp
                                            <label style="font-size: 20px !important;" class="modal-label">
                                                <b class="text-success">SUBTOTAL</b>
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span
                                                        style="font-size: 22px; @if ($check_stv < 0) border-color: red; @endif"
                                                        class="input-group-text"><b>R$</b></span>
                                                </div>
                                                <input
                                                    style="font-size: 35px; @if ($check_stv < 0) border-color: red; @endif"
                                                    wire:model="subtotalVenda" readonly placeholder="0,00"
                                                    type="text"
                                                    class="form-control modal-input total-operation form-control-lg"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-1">
                    <button wire:loading.attr="disabled" type="button" class="btn btn-cancel"
                        data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" type="submit" class="btn btn-send">Finalizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#prod-select').on('change', function(e) {
            var data = $('#prod-select').select2("val");
            @this.set('selectedProduct', data);
        });

        Livewire.on('resetSelect', function() {
            $('#prod-select').val('').trigger('change');
        });
    });

    $(document).ready(function() {
        $('#pdv-fp-select').on('change', function(e) {
            var data = $('#pdv-fp-select').select2("val");
            @this.set('selectedFp', data);
            @this.set('valorDaFp', '');
        });

        Livewire.on('resetSelectFp', function() {
            $('#pdv-fp-select').val('').trigger('change');
        });
    });
</script>

<div>
    <!-- Modal Operação-->
    <div class="modal fade modal-pdv" id="venda" tabindex="-1" aria-labelledby="vendaLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-pdv">
            <div class="modal-content modal-custom modal-pdv-content">
                <div class="modal-header pt-2 pb-1 px-2">
                    <h5 class="modal-title px-0 py-0" id="vendaLabel">
                        <i class="far fa-shopping-cart fa-fw mr-3"></i>PDV - Nova venda
                    </h5>
                    <button type="button" class="close py-1 m-0" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body px-2 py-0 modal-pdv-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-4 p-2">
                                <form>
                                    <div class="form-group my-2">
                                        <label class="modal-label">
                                            Produtos
                                            <span class="red">*</span>
                                        </label>
                                        <div wire:ignore>
                                            <style>
                                                .select2-container{
                                                    display: block;
                                                }
                                            </style>
                                            <select id="prod-select" placeholder="Selecione um produto">
                                                <option value="">Selecione um produto</option>
                                                @foreach ($produtos as $produto)
                                                    <option value="{{ $produto->id }}">{{ $produto->descricao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="row">
                                            <div class="col">
                                                <label class="modal-label">
                                                    Em estoque
                                                    <span class="red">*</span>
                                                </label>
                                                <input wire:model="estoqueAtual" readonly type="number"
                                                    class="form-control modal-input" autocomplete="off">
                                            </div>
                                            <div class="col">
                                                <label class="modal-label">
                                                    Quantidade
                                                    <span class="red">*</span>
                                                </label>
                                                <input type="number" class="form-control modal-input"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-new btn-block">Adicionar</button>
                                    <hr>
                            </div>
                            <div class="col-8 border-left p-2">
                                <div class="produtos-adicionados">
                                    <table class="table table-striped table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Produto</th>
                                                <th scope="col">Preço un.</th>
                                                <th scope="col">Quantidade</th>
                                                <th scope="col">Subtotal</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Camiseta</td>
                                                <td>R$ 80,00</td>
                                                <td>x2</td>
                                                <td>R$ 160,00</td>
                                                <td>
                                                    <i class="fad fa-trash-alt fa-fw text-danger fa-lg"></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-7">

                                    </div>
                                    <div class="col-5">
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Total da venda
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input readonly placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Valor pago
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Troco
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input readonly placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Desconto
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label class="modal-label">
                                                Subtotal
                                            </label>
                                            <div class="input-group mb-0">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input readonly placeholder="0,00" type="text"
                                                    class="form-control modal-input total-operation" autocomplete="off">
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
                        wire:click.prevent="resetNewOperation()" data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:target="confirmation" type="submit"
                        class="btn btn-send">Finalizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmação-->
    {{-- <div class="modal fade" data-backdrop="static" data-keyboard="false" id="confirm-operation" tabindex="-1"
        aria-labelledby="confirm-operationLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="confirm-operationLabel">Confirmação da operação</h5>
                    <button wire:loading.attr="disabled" type="button" class="close px-4" data-dismiss="modal"
                        aria-label="Close" wire:click.prevent="alternate()">
                        <i class="far fa-arrow-left"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente realizar esta
                        operação?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            Ao clicar em <span class="msg-bold">Confirmar</span>, uma nova operação será realizada e
                            não
                            poderá mais ser excluída da plataforma.
                            Para excluir uma operação, entre em contato com nosso suporte.
                        </p>
                        <button type="button" wire:loading.attr="disabled" wire:click.prevent="alternate()"
                            data-dismiss="modal" class="px-4 verify-font">Verificar dados da operação</button>
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button wire:loading.attr="disabled" wire:click.prevent="resetOperation()" type="button"
                        class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="save()" type="button"
                        class="btn btn-send">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $('#prod-select').select2();
        $('#prod-select').on('change', function(e) {
            var data = $('#prod-select').select2("val");
            @this.set('foo', data);
        });
    });
</script>

<div>
    <!-- Modal Operação-->
    <div class="modal fade" id="venda" tabindex="-1" aria-labelledby="vendaLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="vendaLabel">Nova venda</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body px-2 py-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <form>
                                    <div class="form-group py-3 mb-0">
                                        <label class="modal-label">
                                            Produtos
                                            <span class="red">*</span>
                                        </label>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <select class="flex-fill" id="prod-select"
                                                placeholder="Selecione um produto">
                                                <option value="">Select a state...</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="DC">District of Columbia</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                            </select>
                                        </div>
                                        <label class="modal-label">
                                            Quantidade
                                            <span class="red">*</span>
                                        </label>
                                        <input type="number" class="form-control modal-input" autocomplete="off">
                                        <button class="btn btn-new btn-block">Adicionar</button>
                                    </div>
                            </div>
                            <div class="col-6 border">
                                <div class="produtos-adicionados">
                                    <div class="form-group mb-1">
                                        <label class="modal-label">
                                            Produtos adicionados
                                        </label>
                                    </div>
                                </div>
                                <hr>
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
                <div class="modal-footer py-4">
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
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="confirm-operation" tabindex="-1"
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
    </div>
</div>

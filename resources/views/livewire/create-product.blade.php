<div>
    <!-- Modal Operação-->
    <div class="modal fade" id="create-item" tabindex="-1" aria-labelledby="operacaoLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="operacaoLabel">Novo produto</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <form wire:submit.prevent="confirmation()">
                        <div class="form-group">
                            <label class="modal-label" for="desc-item">Descrição <small>(nome do produto) </small> <span
                                    class="red">*</span></label>
                            <input wire:model.defer="state.descricao" type="text" class="form-control modal-input"
                                id="desc-item" autocomplete="off">
                            @error('state.descricao')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="modal-label" for="qtd-item">Qtd. em estoque <span
                                            class="red">*</span></label>
                                    <input wire:model.defer="state.estoque" type="text"
                                        class="form-control modal-input" id="qtd-item" placeholder="0-99999"
                                        autocomplete="off">
                                    @error('state.estoque')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="modal-label" for="total-op">Preço unitário <span
                                            class="red">*</span></label>
                                    <div class="input-group mb-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input wire:model.defer="state.preco" placeholder="0,00" type="text"
                                            class="form-control modal-input total-operation" id="total-op"
                                            autocomplete="off">
                                    </div>
                                    @error('state.preco')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer py-4">
                    <button wire:loading.attr="disabled" type="button" class="btn btn-cancel"
                        wire:click.prevent="resetNewOperation()">Cancelar</button>
                    <button wire:loading.attr="disabled" type="submit" class="btn btn-send">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmação-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="confirm-item-creation" tabindex="-1"
        aria-labelledby="confirm-item-creationLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="confirm-item-creationLabel">Confirmação de cadastro</h5>
                    <button wire:loading.attr="disabled" type="button" class="close px-4" data-dismiss="modal"
                        aria-label="Close" wire:click.prevent="alternate()">
                        <i class="far fa-arrow-left"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente cadastrar este
                        produto?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            Ao clicar em <span class="msg-bold">Confirmar</span>, um novo produto será
                            cadastrada na plataforma.
                        </p>
                        <button type="button" wire:loading.attr="disabled" wire:click.prevent="alternate()"
                            data-dismiss="modal" class="px-4 verify-font">Verificar dados do produto</button>
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

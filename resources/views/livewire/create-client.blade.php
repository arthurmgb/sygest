<div>
    <!-- Modal Cadastro -->
    <div class="modal fade" id="create-item" tabindex="-1" aria-labelledby="createItemLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="createItemLabel">Novo cliente</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <form wire:submit.prevent="confirmation()">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">

                                    <label class="modal-label" for="nome-item">
                                        Nome completo
                                        <span class="red">*</span>
                                    </label>

                                    <input wire:model.defer="state.nome" type="text" class="form-control modal-input"
                                        id="nome-item" autocomplete="off">

                                    @error('state.nome')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">

                                    <label class="modal-label" for="documento-item">
                                        CPF/CNPJ
                                        <small>(opcional)</small>
                                    </label>

                                    <input wire:model.defer="state.documento" type="text"
                                        class="form-control modal-input" id="documento-item" autocomplete="off">

                                    @error('state.documento')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">

                                    <label class="modal-label" for="rg-item">
                                        RG
                                        <small>(opcional)</small>
                                    </label>

                                    <input wire:model.defer="state.rg" type="text" class="form-control modal-input"
                                        id="rg-item" autocomplete="off">

                                    @error('state.rg')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">

                                    <label class="modal-label" for="endereco-item">
                                        Endereço
                                        <small>(opcional)</small>
                                    </label>

                                    <input wire:model.defer="state.endereco" type="text"
                                        class="form-control modal-input" id="endereco-item" autocomplete="off">

                                    @error('state.endereco')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">

                                    <label class="modal-label" for="celular-item">
                                        Celular
                                        <small>(opcional)</small>
                                    </label>

                                    <input wire:model.defer="state.celular" type="text"
                                        class="form-control modal-input" id="celular-item" autocomplete="off"
                                        placeholder="(00) 00000-0000">

                                    @error('state.celular')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">

                                    <label class="modal-label" for="email-item">
                                        E-mail
                                        <small>(opcional)</small>
                                    </label>

                                    <input wire:model.defer="state.email" type="email"
                                        class="form-control modal-input" id="email-item" autocomplete="off">

                                    @error('state.email')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">

                                    <label class="modal-label" for="obs-item">
                                        Observações
                                        <small>(opcional)</small>
                                    </label>

                                    <textarea class="form-control modal-input yampay-scroll" wire:model.defer="state.obs" autocomplete="off" name="" id="obs-item"
                                        rows="5">
                                    </textarea>

                                    @error('state.obs')
                                        <span class="wire-error">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer py-4">
                    <button wire:loading.attr="disabled" type="button" class="btn btn-cancel"
                        wire:click.prevent="resetData()">Cancelar</button>
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
                        cliente?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            Ao clicar em <span class="msg-bold">Confirmar</span>, um novo cliente será
                            cadastrado na plataforma.
                        </p>
                        <button type="button" wire:loading.attr="disabled" wire:click.prevent="alternate()"
                            data-dismiss="modal" class="px-4 verify-font">Verificar dados do cliente</button>
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button wire:loading.attr="disabled" wire:click.prevent="resetDataOnConfirm()" type="button"
                        class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="save()" type="button"
                        class="btn btn-send">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

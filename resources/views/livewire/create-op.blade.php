<div>
    <!-- Modal Operação-->
    <div class="modal fade" id="operacao" tabindex="-1" aria-labelledby="operacaoLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="operacaoLabel">Nova operação</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <form wire:submit.prevent="confirmation()">
                        <div class="form-group mb-1">
                            <label class="modal-label">Tipo de operação <span class="red">*</span></label>
                            <br>
                            <input wire:model="state.tipo" wire:click="changeOperation" value="1" class="radio" type="radio" name="operation"
                                id="op-entrada">
                            <label class="label-op" for="op-entrada">Entrada</label>

                            <input wire:model="state.tipo" wire:click="changeOperation" value="0" class="radio" type="radio" name="operation"
                                id="op-saida">
                            <label class="label-op" for="op-saida">Saída</label>
                            @error('state.tipo')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="desc-op">Descrição <span class="red">*</span></label>
                            <input wire:model.defer="state.descricao" type="text" class="form-control modal-input"
                                id="desc-op" autocomplete="off">
                            @error('state.descricao')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="categoria-op">Categoria <span class="red">*</span></label>

                            @if ($categorias->count())

                                <select style="font-size: 17px;" wire:model.defer="state.categoria" class="form-control modal-input-cat"
                                    id="categoria-op">
                                    <option value="">Selecione uma categoria</option>

                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->descricao }}</option>
                                    @endforeach
                                </select>
                            @else
                            <a href="{{ route('categorias') }}" class="btn btn-new btn-block">+ Nova categoria</a>
                            @endif
                            @error('state.categoria')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="especie-op">Espécie  <span class="red">*</span></label>
                                <select style="font-size: 17px;" wire:model.defer="state.especie" class="form-control modal-input-cat"
                                    id="especie-op">
                                    <option value="">Selecione o tipo de espécie</option>
                                    <option value="1">💵 Dinheiro</option>
                                    <option value="2">💲 Cheque</option>
                                    <option value="3">💰 Moedas</option>
                                    <option value="4">💼 Gaveta/Troco</option>
                                </select>
                            @error('state.especie')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <label class="modal-label" for="total-op">Total da operação <span
                                    class="red">*</span></label>
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input wire:model.defer="state.total" placeholder="0,00" type="text"
                                    class="form-control modal-input total-operation" id="total-op" autocomplete="off">
                            </div>
                            @error('state.total')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                </div>
                <div class="modal-footer py-4">
                    <button wire:loading.attr="disabled" type="button" class="btn btn-cancel"
                        wire:click.prevent="resetNewOperation()">Cancelar</button>
                    <button wire:loading.attr="disabled" type="submit" class="btn btn-send">Adicionar</button>
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
                            Ao clicar em <span class="msg-bold">Confirmar</span>, uma nova operação será realizada e não
                            poderá mais ser excluída do sistema.
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

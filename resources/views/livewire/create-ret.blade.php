<div>
    <!-- Modal Operação-->
    <div class="modal fade" id="operacao" tabindex="-1" aria-labelledby="operacaoLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="operacaoLabel">Nova retirada</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body pt-3 pb-4 px-4">
                    <div class="div-refreshing d-flex flex-row align-items-center justify-content-end m-0 p-0">
                        <div wire:click="refreshOp()" class="refreshing-component d-flex flex-row align-items-center">
                            <div wire:loading.remove wire:target="refreshOp" class="div-icon-refreshed">
                                <i class="fas fa-sync-alt fa-fw mr-1"></i>
                            </div>
                            <div wire:loading wire:target="refreshOp" class="div-icon-refreshed">
                                <i class="fas fa-sync-alt fa-fw mr-1 fa-spin"></i>
                            </div>
                            Atualizar
                        </div>
                    </div>
                    <form wire:submit.prevent="confirmation()">
                        <div class="form-group">
                            <label class="modal-label" for="desc-op">Descrição <span class="red">*</span></label>
                            <input wire:model.defer="state.descricao" type="text" class="form-control modal-input"
                                id="desc-op" autocomplete="off">
                            @error('state.descricao')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="operador-op">Operador <span class="red">*</span></label>
                            @if ($operadores->count())
                            <a style="padding: 3px 14px;" href="{{ route('configuracoes') }}" target="_blank" class="btn btn-new my-1 float-right">+ Novo</a>

                                <select style="font-size: 17px;" wire:model.defer="state.operador" class="form-control modal-input-cat yampay-scroll"
                                    id="operador-op" onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();' @if($is_operator_default == 'disabled') disabled @endif>
                                    <option value="">Selecione um operador</option>

                                    @foreach ($operadores as $operador)
                                    <option value="{{ $operador->id }}">@if($operador->is_default == 1) 🟣 @endif{{ $operador->nome }} @if($operador->is_default == 1) (Padrão)@endif</option>
                                    @endforeach
                                </select>
                            @else
                            <a href="{{ route('configuracoes') }}" target="_blank" class="btn btn-new btn-block">+ Novo operador</a>
                            @endif
                            @error('state.operador')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="especie-op">Espécie  <span class="red">*</span></label>
                                <select style="font-size: 17px;" wire:model="state.especie" class="form-control modal-input-cat yampay-scroll"
                                    id="especie-op" onfocus='this.size=6;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                    <option value="">Selecione o tipo de espécie</option>
                                    <option value="1">💵 Dinheiro</option>
                                    <option value="2">💲 Cheque</option>
                                    <option value="3">💰 Moedas</option>
                                    <option style="margin-bottom: 0px !important;" value="4">💳 Outros (+ Mais opções)</option>
                                </select>
                            @error('state.especie')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        @if (isset($state['especie']) and $state['especie'] == 4)
                            <div class="form-group">
                                <label class="modal-label" for="fp-op">Forma de pagamento  <span style="font-size: 12px;">(opcional)</span></label>
                                <a style="padding: 3px 14px;" href="{{ route('formas-pagamento') }}" target="_blank" class="btn btn-new my-1 float-right">+ Nova FP</a>
                                    <select style="font-size: 17px;" wire:model.defer="state.fp" class="form-control modal-input-cat yampay-scroll"
                                    id="fp-op" onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                    <option value="">Não especificada</option>
                                        @foreach ($formas_de_pag as $single_form_pag)
                                            <option value="{{$single_form_pag->id}}">{{$single_form_pag->descricao}}</option>
                                        @endforeach
                                    </select>
                                @error('state.fp')
                                    <span class="wire-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group mb-0">
                            <label class="modal-label" for="total-op">Total da retirada <span
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
                        wire:click.prevent="resetNewOperation()" data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:target="confirmation" type="submit" class="btn btn-send">Retirar</button>
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
                        retirada?</h5>

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

<div>
    @if(auth()->user()->is_admin === 1)
        <div class="modal fade" id="new-contract" tabindex="-1" aria-labelledby="new-contractLabel" aria-hidden="true"
        wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="new-contractLabel">Novo contrato</h5>
                        <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <form wire:submit.prevent="confirmation()">                     
                            <div class="form-group">
                                <div class="d-flex flex-row align-items-center">
                                    <input type="checkbox" id="avaliacao" wire:click.prevent="avaliacaoContract()" @if($is_test == 'selected') checked @endif>
                                    <label for="avaliacao"></label>
                                    <label style="margin: 16px 12px;" class="modal-label" for="primeiro-pag">Contrato de avaliação gratuita?</label>  
                                </div>                                                          
                            </div>
                            <div class="form-group">
                                <label class="modal-label" for="primeiro-pag">Primeiro pagamento <span class="red">*</span></label>
                                <input style="width: 100%; height: calc(2.25rem + 2px);" wire:model.defer="state.pagamento" type="date" class="form-control modal-input search-relatorio"
                                    id="primeiro-pag" autocomplete="off" @if($disable_inputs == 'selected') disabled @endif> 
                                @error('state.pagamento')
                                    <span class="wire-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="modal-label" for="valor-contract">Valor <span
                                    class="red">*</span>
                                </label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input wire:model.defer="state.valor" placeholder="0,00" type="text"
                                        class="form-control modal-input total-operation" id="valor-contract" autocomplete="off" @if($disable_inputs == 'selected') disabled @endif>
                                </div>
                                @error('state.valor')
                                    <span class="wire-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="modal-label" for="vigencia">Vigência <span style="font-size: 12px; color: #555;">(meses) </span><span class="red">*</span></label>
                                <input wire:model.defer="state.meses" type="number" class="form-control modal-input"
                                    id="vigencia" autocomplete="off" @if($disable_inputs == 'selected') disabled @endif> 
                                @error('state.meses')
                                    <span class="wire-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label class="modal-label" for="comissionado">Comissionado <span style="font-size: 12px; color: #555;">(opcional)</span></label>
                                <div class="div-select-comissionado">
                                    <select wire:model.defer="state.comissionado" style="font-size: 16px;" id="comissionado" class="form-control modal-input-cat yampay-scroll" onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();' @if($disable_inputs == 'selected') disabled @endif>
                                        <option value="no-comissionado">Selecione um comissionado (Nenhum)</option>
                                        @foreach ($comissionados as $comissionado)
                                        <option value="{{$comissionado->id}}">{{$comissionado->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer py-4">
                        <button wire:loading.attr="disabled" type="button" class="btn btn-cancel"
                            wire:click.prevent="resetNewOperation()" data-dismiss="modal">Cancelar</button>
                        <button wire:loading.attr="disabled" type="submit" class="btn btn-send">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmação-->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="confirm-operation-contract" tabindex="-1"
            aria-labelledby="confirm-operation-contractLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title px-3 py-3" id="confirm-operation-contractLabel">Confirmação de cadastro</h5>
                        <button wire:loading.attr="disabled" type="button" class="close px-4" data-dismiss="modal"
                            aria-label="Close" wire:click.prevent="alternate()">
                            <i class="far fa-arrow-left"></i>
                        </button>
                    </div>
                    <div class="modal-body py-4 px-4">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente cadastrar este
                            contrato?</h5>

                        <div class="confirmation-msg text-center mb-3">
                            <p class="m-0 mb-3 px-4">
                                Ao clicar em <span class="msg-bold">Confirmar</span>, um novo contrato será cadastrado para este usuário do sistema.
                            </p>                      
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
    @endif
</div>

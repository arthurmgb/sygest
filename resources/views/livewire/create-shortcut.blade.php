<div>
    <!-- Modal Operação-->
    <div class="modal fade" id="operacao" tabindex="-1" aria-labelledby="operacaoLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="operacaoLabel">Novo link</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <form wire:submit.prevent="save()">
                        
                        <div class="form-group">
                            <label class="modal-label" for="desc-op">Descrição <span class="red">*</span></label>
                            <input wire:model.defer="state.descricao" type="text" class="form-control modal-input"
                                id="desc-op" autocomplete="off"> 
                            @error('state.descricao')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="modal-label" for="url-op">URL <span class="red">*</span></label>
                            <input wire:model.defer="state.url" type="url" class="form-control modal-input"
                                id="url-op" autocomplete="off" placeholder="https://www.exemplo.com" required pattern="https?://.*" title="Insira o protocolo https:// ou http://"> 
                            @error('state.url')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label class="modal-label" for="color-op">Cor (opcional)</label>
                            <input wire:model.defer="state.cor" type="color" name="favcolor" class="form-control modal-input-color"
                                id="color-op" autocomplete="off">                           
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

</div>

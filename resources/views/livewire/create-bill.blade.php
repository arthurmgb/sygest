<div>
    <!-- Modal Cadastro -->
    <div class="modal fade" id="create-item" tabindex="-1" aria-labelledby="createItemLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="createItemLabel">Nova movimentação</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">
                    <form wire:submit.prevent="confirmation()">
                        <div class="form-group">
                            <label class="modal-label">
                                Tipo de conta
                                <span class="red">*</span>
                            </label>

                            <br>

                            <input wire:model="state.tipo" wire:click="changeBillType" value="1" class="radio"
                                type="radio" name="bill-type" id="bill-to-receive">

                            <label class="label-op label-green" for="bill-to-receive">
                                <i class="fad fa-arrow-to-top fa-fw fa-lg mr-1"></i>
                                A receber
                            </label>

                            <input wire:model="state.tipo" wire:click="changeBillType" value="0" class="radio"
                                type="radio" name="bill-type" id="bill-to-pay">

                            <label class="label-op label-red" for="bill-to-pay">
                                A pagar
                                <i class="fad fa-arrow-from-top fa-fw fa-lg ml-1"></i>
                            </label>

                            @error('state.tipo')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="bill-description">
                                Descrição
                                <span class="red">*</span>
                            </label>

                            <input wire:model.defer="state.descricao" type="text" class="form-control modal-input"
                                id="bill-description" autocomplete="off">

                            @error('state.descricao')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="bill-category">
                                Categoria
                                <span class="red">*</span>
                            </label>
                            <div wire:ignore>
                                <select wire:loading.attr="disabled" id="bill-category"
                                    placeholder="Selecione uma categoria">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach ($bill_categories as $bill_category)
                                        <option value="{{ $bill_category->id }}">
                                            {{ $bill_category->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="bill-method">
                                Forma de pagamento
                                <span class="red">*</span>
                            </label>
                            <div wire:ignore>
                                <select wire:loading.attr="disabled" id="bill-method"
                                    placeholder="Selecione uma forma de pagamento">
                                    <option value="">Selecione uma forma de pagamento</option>
                                    @foreach ($bill_methods as $bill_method)
                                        <option value="{{ $bill_method->id }}">
                                            {{ $bill_method->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="bill-total">
                                Total da movimentação
                                <span class="red">*</span>
                            </label>

                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input wire:model.defer="state.total" placeholder="0,00" type="text"
                                    class="form-control modal-input total-operation precos-mask" id="bill-total"
                                    autocomplete="off">
                            </div>

                            @error('state.total')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
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

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente cadastrar esta
                        movimentação?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            Ao clicar em <span class="msg-bold">Confirmar</span>, uma nova movimentação será
                            cadastrada na plataforma.
                        </p>
                        <button type="button" wire:loading.attr="disabled" wire:click.prevent="alternate()"
                            data-dismiss="modal" class="px-4 verify-font">Verificar dados da movimentação</button>
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
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#bill-category').on('change', function(e) {
            var data = $('#bill-category').select2("val");
            @this.set('selectedCategory', data);
        });

        Livewire.on('resetSelectedCategory', function() {
            $('#bill-category').val('').trigger('change');
        });
        Livewire.on('recriarSelect2', function() {
            // ...
        });
    });
    $(document).ready(function() {
        $('#bill-method').on('change', function(e) {
            var data = $('#bill-method').select2("val");
            @this.set('selectedMethod', data);
        });

        Livewire.on('resetSelectedMethod', function() {
            $('#bill-method').val('').trigger('change');
        });
    });
</script>

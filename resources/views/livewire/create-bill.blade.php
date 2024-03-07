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
                            <label class="modal-label" for="bill-date">
                                Data de vencimento
                                <span class="red">*</span>
                            </label>

                            <input min="2000-01-01" max="2200-01-01" wire:model.defer="state.data" type="date"
                                class="form-control modal-input custom-date-input" id="bill-date" autocomplete="off">

                            @error('state.data')
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
                            <label class="modal-label" for="bill-client">
                                Cliente
                                <small>(opcional)</small>
                            </label>
                            <input style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;"
                                placeholder="buscar cliente" type="text" wire:model="bill_client_param"
                                class="form-control modal-input-no-inset border-bottom-0" id="bill-client-param"
                                autocomplete="off">
                            @if ($bill_clients->count())
                                <select
                                    style="border-top: 0 !important; border-top-left-radius: 0 !important; border-top-right-radius: 0 !important;  box-shadow: unset !important;"
                                    wire:loading.attr="disabled" wire:key="bill-clients-select"
                                    wire:target="bill_client_param, changeBillType" wire:model="state.cliente"
                                    class="form-control modal-input-cat yampay-scroll" id="bill-client"
                                    onfocus="this.size=5; this.classList.add('fadeIn'); this.classList.remove('fadeOut');"
                                    onblur="this.size=1; this.classList.remove('fadeIn'); this.classList.add('fadeOut');"
                                    onchange="this.size=1; this.blur(); this.disabled=true">
                                    <option value="">Selecione um cliente</option>
                                    @foreach ($bill_clients as $bill_client)
                                        <option value="{{ $bill_client->id }}">
                                            {{ $bill_client->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <a href="{{ route('clients') }}" class="btn btn-new btn-block btlr-btrr">+ Novo
                                    cliente</a>
                                <small>Nenhum cliente encontrado</small>
                            @endif

                            @error('state.cliente')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="bill-category">
                                Categoria
                                <span class="red">*</span>
                            </label>
                            <input style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;"
                                placeholder="buscar categoria" type="text" wire:model="bill_category_param"
                                class="form-control modal-input-no-inset border-bottom-0" id="bill-category-param"
                                autocomplete="off">
                            @if ($bill_categories->count())
                                <select
                                    style="border-top: 0 !important; border-top-left-radius: 0 !important; border-top-right-radius: 0 !important;  box-shadow: unset !important;"
                                    wire:loading.attr="disabled" wire:key="bill-categories-select"
                                    wire:target="bill_category_param, changeBillType" wire:model="state.categoria"
                                    class="form-control modal-input-cat yampay-scroll" id="bill-category"
                                    onfocus="this.size=5; this.classList.add('fadeIn'); this.classList.remove('fadeOut');"
                                    onblur="this.size=1; this.classList.remove('fadeIn'); this.classList.add('fadeOut');"
                                    onchange="this.size=1; this.blur(); this.disabled=true">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach ($bill_categories as $bill_category)
                                        <option value="{{ $bill_category->id }}">
                                            {{ $bill_category->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <a href="{{ route('categorias') }}" class="btn btn-new btn-block btlr-btrr">+ Nova
                                    categoria</a>
                                <small>Nenhuma categoria encontrada</small>
                            @endif

                            @error('state.categoria')
                                <br>
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="bill-method">
                                Forma de pagamento
                                <span class="red">*</span>
                            </label>
                            <input style="border-bottom-left-radius: 0; border-bottom-right-radius: 0;"
                                placeholder="buscar forma de pagamento" type="text" wire:model="bill_method_param"
                                class="form-control modal-input-no-inset border-bottom-0" id="bill-method-param"
                                autocomplete="off">
                            @if ($bill_methods->count())
                                <select
                                    style="border-top: 0 !important; border-top-left-radius: 0 !important; border-top-right-radius: 0 !important;  box-shadow: unset !important;"
                                    wire:loading.attr="disabled" wire:key="bill-methods-select"
                                    wire:target="bill_method_param, changeBillType" wire:model="state.method"
                                    class="form-control modal-input-cat yampay-scroll" id="bill-method"
                                    onfocus="this.size=5; this.classList.add('fadeIn'); this.classList.remove('fadeOut');"
                                    onblur="this.size=1; this.classList.remove('fadeIn'); this.classList.add('fadeOut');"
                                    onchange="this.size=1; this.blur(); this.disabled=true">
                                    <option value="">Selecione uma forma de pagamento</option>
                                    @foreach ($bill_methods as $bill_method)
                                        <option value="{{ $bill_method->id }}">
                                            {{ $bill_method->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <a href="{{ route('formas-pagamento') }}" class="btn btn-new btn-block btlr-btrr">+
                                    Nova
                                    forma de pagamento</a>
                                <small>Nenhuma forma de pagamento encontrada</small>
                            @endif

                            @error('state.method')
                                <br>
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="modal-label" for="bill-recurrence">
                                Recorrência
                                <span class="red">*</span>
                            </label>

                            <br>

                            {{-- ESCOLHENDO O TIPO DE RECORRÊNCIA --}}
                            <input wire:model="state.recurrence" value="unico" class="radio" type="radio"
                                name="bill-recurrence" id="bill-recurrence-unique">

                            <label class="label-op label-default mb-0" for="bill-recurrence-unique">
                                Único
                            </label>

                            <input wire:model="state.recurrence" value="mensal" class="radio" type="radio"
                                name="bill-recurrence" id="bill-recurrence-monthly">

                            <label class="label-op label-default mb-0" for="bill-recurrence-monthly">
                                Mensal
                            </label>

                            <br>

                            @error('state.recurrence')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group" @if ($state['recurrence'] == 'unico') style="display: none" @endif>
                            {{-- ABRE AS PARCELAS SE FOR RECORRENTE --}}
                            <label class="modal-label" for="bill-parcel">
                                Parcelas
                                <span class="red">*</span>
                            </label>

                            <input wire:model.defer="state.parcels" type="text"
                                class="form-control modal-input qtd-item-two" id="bill-parcel" autocomplete="off">

                            @error('state.parcels')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
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
                        wire:click.prevent="resetData()" data-dismiss="modal">Cancelar</button>
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

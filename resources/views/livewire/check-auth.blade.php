<div>

    <div class="modal" id="modalCheckAuth" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalCheckAuthLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="modalCheckAuthLabel">Bem vindo(a)!</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4 yampay-scroll">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 mb-3">Quem está utilizando a plataforma?
                    </h5>

                    <select wire:model="selectedOperator" style="font-size: 17px;"
                        class="form-control modal-input-cat yampay-scroll" id="operator-check-auth"
                        onfocus="this.size=5; this.classList.add('fadeIn'); this.classList.remove('fadeOut');"
                        onblur="this.size=1; this.classList.remove('fadeIn'); this.classList.add('fadeOut');"
                        onchange="this.size=1; this.blur();">
                        <option value="">Selecione um operador</option>

                        @foreach ($account_operators as $account_operator)
                            <option value="{{ $account_operator->id }}">

                                {{ $account_operator->nome }}

                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>
    </div>


</div>

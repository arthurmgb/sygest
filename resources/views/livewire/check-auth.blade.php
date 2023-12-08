<div>

    <div class="modal modal-check-auth" id="modalCheckAuth" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalCheckAuthLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-check-auth">
            <div class="modal-content modal-custom modal-content-check-auth">
                <div class="modal-header justify-content-center">
                    <h5 style="font-size: 30px !important;" class="modal-title px-3 py-3" id="modalCheckAuthLabel">Bem
                        vindo(a)!</h5>
                </div>
                <div
                    class="modal-body py-4 px-4 yampay-scroll modal-body-check-auth d-flex flex-column align-items-center justify-content-center">

                    <h5 style="font-size: 40px; font-weight: 500;"
                        class="modal-confirmation-msg m-0 text-center px-4 mb-5">
                        Quem está utilizando a Plataforma?
                    </h5>

                    <select wire:loading.attr="disabled" wire:model="selectedOperator" style="font-size: 20px; height: auto; width: 450px;"
                        class="form-control modal-input-cat yampay-scroll mb-3" id="operator-check-auth"
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

                    @if ($showInput == true)
                        <input wire:target="verifyCredentials, updatedSelectedOperator" wire:loading.attr="disabled"
                            wire:model="operatorPass" style="font-size: 20px; height: 44px; width: 450px;"
                            type="text" class="form-control modal-input mb-3" autocomplete="off"
                            placeholder="Digite sua senha...">

                        <button wire:click.prevent="verifyCredentials"
                            style="font-size: 20px; width: 450px; height: 44px;" wire:loading.attr="disabled"
                            type="button" class="btn btn-new">Acessar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

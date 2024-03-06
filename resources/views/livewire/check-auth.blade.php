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
                        class="modal-confirmation-msg m-0 text-center px-4 mb-4">
                        Quem está utilizando a Plataforma?
                    </h5>

                    @if (count($account_operators))
                        <select wire:key="check-auth-select"
                            wire:target="verifyCredentials, updatedSelectedOperator"
                            wire:loading.attr="disabled" wire:model="selectedOperator"
                            style="font-size: 20px; height: auto; width: 450px; max-width: 100%;"
                            class="form-control modal-input-cat yampay-scroll mb-3" id="operator-check-auth"
                            onfocus="this.size=5; this.classList.add('fadeIn'); this.classList.remove('fadeOut');"
                            onblur="this.size=1; this.classList.remove('fadeIn'); this.classList.add('fadeOut'); this.disabled='true'"
                            onchange="this.size=1; this.blur();">
                            <option value="">Selecione um operador</option>

                            @foreach ($account_operators as $account_operator)
                                <option value="{{ $account_operator->id }}">

                                    {{ $account_operator->nome }}

                                </option>
                            @endforeach
                        </select>

                        @if ($showInput == true)
                            <input autofocus wire:keydown.enter="verifyCredentials"
                                wire:target="verifyCredentials, updatedSelectedOperator" wire:loading.attr="disabled"
                                wire:model="operatorPass"
                                style="font-size: 20px; height: 44px; width: 450px; -webkit-text-security: disc;
                        text-security: disc; max-width: 100%;"
                                type="text" class="form-control modal-input" autocomplete="off"
                                placeholder="Digite sua senha...">
                            @error('operatorPass')
                                <span class="wire-error pt-2">{{ $message }}</span>
                            @enderror
                            <button wire:click.prevent="verifyCredentials"
                                style="font-size: 20px; width: 450px; height: 44px; max-width: 100%;"
                                wire:loading.attr="disabled" type="button" class="btn btn-new mt-3">Acessar</button>
                        @endif
                    @else
                        <button wire:click.prevent="generateAdminOperator"
                            style="font-size: 20px; width: 450px; height: 44px; max-width: 100%;"
                            wire:loading.attr="disabled" type="button" class="btn btn-new"><i
                                class="fad fa-user-shield fa-fw mr-2"></i>Gerar
                            operador Gerente</button>
                    @endif



                </div>
            </div>
        </div>
    </div>

</div>

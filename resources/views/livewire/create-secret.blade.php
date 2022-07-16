<div>

    <div class="modal fade" id="operacao" tabindex="-1" aria-labelledby="operacaoLabel" aria-hidden="true"
    wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="operacaoLabel">Nova senha</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

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
                            <label class="modal-label" for="desc-op">Login <span style="font-size: 13px;">(opcional)</span></label>
                            <input wire:model.defer="state.login" type="text" class="form-control modal-input"
                                id="desc-op" autocomplete="off" placeholder="E-mail, usuário, conta..."> 
                            @error('state.login')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label class="modal-label" for="desc-op">Senha <span class="red">*</span></label>
                            <div class="d-flex flex-row align-items-center">
                                <input @if($blur == 'yes') style="-webkit-text-security: disc;" @endif wire:model.defer="state.senha" type="text" class="form-control modal-input" id="desc-op" autocomplete="off">
                                @if($blur == 'yes')
                                    <div wire:click.prevent="toggleBlur()" class="div-copy-secret-pass" data-tooltip="Exibir" data-flow="top">
                                        <i style="color: #0696BD;" class="fad fa-eye fa-fw fa-lg ml-3"></i>
                                    </div>
                                @elseif($blur == 'no')
                                    <div wire:click.prevent="toggleBlur()" class="div-copy-secret-pass" data-tooltip="Ocultar" data-flow="top">
                                        <i style="color: #0696BD;" class="fad fa-eye-slash fa-fw fa-lg ml-3"></i>
                                    </div>
                                @endif 
                            </div>

                            @error('state.senha')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror

                        </div>

                </div>
                <div class="modal-footer py-4">

                    <button wire:loading.attr="disabled" type="button" class="btn btn-cancel"
                        wire:click.prevent="resetNewOperation()" data-dismiss="modal">Cancelar</button>
                    <button wire:key="btn-cad-secret" wire:loading.attr="disabled" wire:target="confirmation" type="submit" class="btn btn-send">Cadastrar</button>

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
                    <h5 class="modal-title px-3 py-3" id="confirm-operationLabel">Confirmação de cadastro</h5>
                    <button wire:loading.attr="disabled" wire:click.prevent="resetOperation()" type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente cadastrar estes dados de senha?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            Ao clicar em <span class="msg-bold">Confirmar</span>, estes dados de senha serão cadastrados na plataforma e ficarão disponíveis para consulta a qualquer momento, desde que você informe corretamente a senha de sua conta.
                        </p>

                        <p class="m-0 mb-3 px-4">
                            <span class="msg-bold">Observação: </span> as informações que você cadastrar estarão sempre protegidas na Cashiers, no entanto, certifique-se sempre de escolher uma senha forte para suas contas pessoais. Nossa equipe nunca solicitará a senha de sua conta na plataforma, guarde-a com segurança para ter acesso a esta ferramenta sempre que precisar consultar uma de suas senhas pessoais.
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

</div>

<x-guest-layout>
    @if(auth()->user()->is_admin === 1)
    <x-jet-authentication-card>

        <div class="primezze-header">
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>
            <h1>Criar uma conta</h1>
            <p>Preencha as informações</p>
        </div>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label class="primezze-label" for="name" value="{{ __('Nome/Empresa') }}" />
                <x-jet-input placeholder="Digite o nome ou a empresa" id="name" class="block mt-1 w-full primezze-input primezze-input" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="off" />
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="email" value="{{ __('E-mail') }}" />
                <x-jet-input placeholder="email@exemplo.com.br" id="email" class="block mt-1 w-full primezze-input" type="email" name="email"
                    :value="old('email')" required autocomplete="off" />
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="documento" value="{{ __('CPF/CNPJ') }}" />
                <x-jet-input id="documento" class="block mt-1 w-full primezze-input" type="text" name="documento"
                    :value="old('documento')" required autocomplete="off" />
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="celular" value="{{ __('Celular') }}" />
                <x-jet-input placeholder="(00) 00000-0000" id="celular" class="block mt-1 w-full primezze-input" type="text" name="celular"
                    :value="old('celular')" required autocomplete="off" />
            </div>

            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <x-jet-label class="primezze-label" for="password" value="{{ __('Senha') }}" />
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="https://www.lastpass.com/pt/features/password-generator" target="_blank">
                        {{ __('Gerador de senhas') }}
                    </a>
                </div>
                <div class="flex items-center justify-between">
                    <x-jet-input placeholder="Digite a senha" id="password" class="block mt-1 w-full primezze-input" type="password" name="password"
                    required autocomplete="off" />
                    <div class="guest-toggle-pass ml-2">
                        <div class="btn-toggle-pass-visib" data-tooltip="Exibir" data-flow="top">
                            <i id="toggler-pass" style="font-family: 'Font Awesome 5 Pro' !important;" class="fad fa-eye fa-fw fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="password_confirmation"
                        value="{{ __('Confirmar Senha') }}" />
                <div class="flex items-center justify-between">
                    <x-jet-input  placeholder="Confirme a senha" id="password_confirmation" class="block mt-1 w-full primezze-input" type="password"
                        name="password_confirmation" required autocomplete="off" />
                    <div class="guest-toggle-pass ml-2">
                        <div class="btn-toggle-pass-visib-2" data-tooltip="Exibir" data-flow="top">
                            <i id="toggler-pass-2" style="font-family: 'Font Awesome 5 Pro' !important;" class="fad fa-eye fa-fw fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms" />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
    'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Terms of Service') . '</a>',
    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Privacy Policy') . '</a>',
]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center mt-4">
                <x-jet-button class="w-full justify-center primezze-btn">
                    {{ __('Criar conta') }}
                </x-jet-button>
            </div>

        </form>
    </x-jet-authentication-card>
    @endif
</x-guest-layout>

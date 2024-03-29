<x-guest-layout>
    <x-jet-authentication-card>

        <div class="primezze-header">
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>
            <h1>Login</h1>
            <p>Digite seu e-mail e senha</p>
        </div>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="cashiers-login-form">
            @csrf

            <div>
                <x-jet-label class="primezze-label" for="email" value="{{ __('E-mail') }}" />
                <x-jet-input placeholder="seuemail@exemplo.com" id="email" class="block mt-1 w-full primezze-input"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="off" />
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="password" value="{{ __('Senha') }}" />
                <div class="flex items-center justify-between">
                    <x-jet-input placeholder="Digite sua senha" id="password" class="block mt-1 w-full primezze-input"
                        type="password" name="password" required autocomplete="off" />
                    <div class="guest-toggle-pass ml-3">
                        <div class="btn-toggle-pass-visib" data-tooltip="Exibir" data-flow="top">
                            <i id="toggler-pass" style="font-family: 'Font Awesome 5 Pro' !important;"
                                class="fad fa-eye fa-fw fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block mt-4">
                <label style="cursor: pointer; user-select: none;" for="remember_me" class="flex items-center">
                    <x-jet-checkbox style="cursor: pointer;" id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar-me') }}</span>
                </label>
            </div>

            <div class="flex items-center mt-4">
                <x-jet-button class="w-full justify-center primezze-btn" id="cashiers-btn-acessar">
                    {{ __('Acessar') }}
                </x-jet-button>
            </div>
        </form>

        <div class="flex items-center justify-center mt-4 ">
            <span style="color: #444;">Ainda não tem uma conta? </span>
        </div>

        <div class="flex items-center justify-center mt-1">
            <a class="create-account"
                href="https://api.whatsapp.com/send?phone=553499169195&text=Ol%C3%A1!%20Tenho%20interesse%20em%20criar%20uma%20conta%20na%20{{ config('app.name') }}!"
                target="_blank">Criar minha conta</a>
        </div>

    </x-jet-authentication-card>
</x-guest-layout>

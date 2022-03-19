<x-guest-layout>
    @if(auth()->user()->is_admin === 1)
    <x-jet-authentication-card>

        <div class="primezze-header">
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>
            <h1>Cadastre-se</h1>
            <p>Complete seu cadastro</p>
        </div>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label class="primezze-label" for="name" value="{{ __('Nome/Empresa') }}" />
                <x-jet-input placeholder="Digite seu nome ou de sua empresa" id="name" class="block mt-1 w-full primezze-input primezze-input" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="off" maxlength="24" />
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="email" value="{{ __('E-mail') }}" />
                <x-jet-input placeholder="exemplo@email.com.br" id="email" class="block mt-1 w-full primezze-input" type="email" name="email"
                    :value="old('email')" required autocomplete="off" />
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="password" value="{{ __('Senha') }}" />
                <x-jet-input placeholder="Digite sua senha" id="password" class="block mt-1 w-full primezze-input" type="password" name="password"
                    required autocomplete="off" />
            </div>

            <div class="mt-4">
                <x-jet-label class="primezze-label" for="password_confirmation"
                    value="{{ __('Confirmar Senha') }}" />
                <x-jet-input  placeholder="Confirme sua senha" id="password_confirmation" class="block mt-1 w-full primezze-input" type="password"
                    name="password_confirmation" required autocomplete="off" />
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
                    {{ __('Cadastrar') }}
                </x-jet-button>
            </div>
            <div class="flex items-center justify-end mt-2">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Já possui cadastro?') }}
                </a>
            </div>

        </form>
    </x-jet-authentication-card>
    @endif
</x-guest-layout>

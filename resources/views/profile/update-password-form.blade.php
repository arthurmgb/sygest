<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Alterar Senha') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Certifique-se de que sua conta está usando uma senha longa e aleatória para permanecer segura.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="senha_atual" value="{{ __('Senha Atual') }}" />
            <x-jet-input id="senha_atual" type="password" class="mt-1 block w-full primezze-input" wire:model.defer="state.senha_atual" autocomplete="off" />
            <x-jet-input-error for="senha_atual" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="password" value="{{ __('Nova Senha') }}" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full primezze-input" wire:model.defer="state.password" autocomplete="off" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="password_confirmation" value="{{ __('Confirmar Senha') }}" />
            <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full primezze-input" wire:model.defer="state.password_confirmation" autocomplete="off" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Atualizado.') }}
        </x-jet-action-message>

        <x-jet-button class="primezze-btn">
            {{ __('Salvar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

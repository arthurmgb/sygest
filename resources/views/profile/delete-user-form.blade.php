<x-jet-action-section>
    <x-slot name="title">
        {{ __('Deletar sua conta') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Deletar sua conta permanentemente.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm f14-666">
            {{ __('Assim que sua conta for excluída, todos os seus recursos, dados e operações serão excluídos permanentemente.') }}
        </div>

        <div class="mt-5">
            <x-jet-danger-button class="primezze-btn2" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Deletar conta') }}
            </x-jet-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Deletar conta') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Tem certeza que deseja deletar sua conta? Depois que sua conta for excluída, todos os seus recursos, dados e operações serão excluídos permanentemente. Digite sua senha para confirmar que deseja excluir permanentemente sua conta.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input style="width: 490px !important;" type="password" class="primezze-input mt-1 block w-3/4"
                                placeholder="{{ __('Digite sua senha') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="deleteUser" autocomplete="off" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button class="primezze-btn2" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Sim, desejo deletar') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>

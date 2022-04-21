<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informações do Perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Atualize as informações do perfil da sua conta e o seu nome de usuário.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label class="primezze-label" for="photo" value="{{ __('Foto de perfil') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2 primezze-btn" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Selecionar foto') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2 primezze-btn2 primezze-b" wire:click="deleteProfilePhoto">
                        {{ __('Remover foto') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="name" value="{{ __('Nome/Empresa') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full primezze-input" wire:model.defer="state.name" autocomplete="off" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="email" value="{{ __('E-mail') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full primezze-input" wire:model.defer="state.email" autocomplete="off" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <!-- CPF/CNPJ -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="documento" value="{{ __('CPF/CNPJ') }}" />
            <x-jet-input placeholder="" id="documento" type="text" class="mt-1 block w-full primezze-input" wire:model.defer="state.documento" autocomplete="off" />
            <x-jet-input-error for="documento" class="mt-2" />
        </div>

        <!-- Cidade -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="cidade" value="{{ __('Cidade') }}" />
            <x-jet-input placeholder="" id="cidade" type="text" class="mt-1 block w-full primezze-input" wire:model.defer="state.cidade" autocomplete="off" />
            <x-jet-input-error for="cidade" class="mt-2" />
        </div>

        <!-- Estado -->
        <div class="col-span-2">
            <x-jet-label class="primezze-label" for="estado" value="{{ __('Estado') }}" />
            <select id="estado" class="mt-1 block modal-input-cat yampay-scroll" wire:model.defer="state.estado" autocomplete="off">
                <option value="">Selecione</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
            <x-jet-input-error for="estado" class="mt-2" />
        </div>

        <!-- Chave PIX -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="pix" value="{{ __('Chave PIX') }}" />
            <x-jet-input placeholder="CPF, e-mail ou celular" id="pix" type="text" class="mt-1 block w-full primezze-input" wire:model.defer="state.chave_pix" autocomplete="off" />
            <x-jet-input-error for="pix" class="mt-2" />
        </div>

        <!-- Banco -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label class="primezze-label" for="banco" value="{{ __('Banco/Instituição') }}" />
            <x-jet-input placeholder="" id="banco" type="text" class="mt-1 block w-full primezze-input" wire:model.defer="state.banco" autocomplete="off" />
            <x-jet-input-error for="banco" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Atualizado.') }}
        </x-jet-action-message>

        <x-jet-button class="primezze-btn" wire:loading.attr="disabled" wire:target="photo">
            {{ __('Salvar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

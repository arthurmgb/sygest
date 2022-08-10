<div>

    @if ($locker == 'locked')
        <div class="page-header d-flex flex-row align-items-center mb-2">
            <h2 class="f-h2">Gerenciador de senhas</h2>
        </div>
    @elseif($locker == 'unlocked')
        <div class="page-header d-flex flex-row align-items-center mb-2">
            <h2 class="f-h2">Minhas senhas</h2>
            <span class="f-span">{{$secrets_ct}} senhas cadastradas</span>
            <div style="user-select: none;" class="ml-auto">
                <a data-toggle="modal" data-target="#operacao" class="btn btn-new mr-1">+ Nova senha</a>
                <button wire:click.prevent="lock()" wire:loading.attr="disabled" class="btn btn-block-gerenciador">Bloquear gerenciador <i class="fad fa-lock-alt fa-fw ml-1"></i></button>
            </div>
        </div>
    @endif

    <div class="block">

        @if ($locker == 'locked')
            <div class="div-locked">

                <div class="card">

                    <div wire:target="render, search, qtd, updatingSearch" wire:loading.remove class="card-body px-0 pb-0">
                        <div style="user-select: none;" class="d-flex flex-column align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="211"
                                height="145">
                                <style>
                                    <![CDATA[
                                    .B {
                                        fill: #fff
                                    }

                                    .C {
                                        stroke-linecap: round
                                    }

                                    .D {
                                        stroke-width: 1.395
                                    }

                                    .E {
                                        stroke: #a4afb7
                                    }

                                    .F {
                                        fill-rule: nonzero
                                    }

                                    .G {
                                        stroke-linejoin: round
                                    }

                                    .H {
                                        fill: #d5dadf
                                    }

                                    ]]>
                                </style>
                                <g fill="none" fill-rule="evenodd">
                                    <path
                                        d="M53.803 136.846h122.8m3.907 0h5.58m-141.207 0h5.58m138.977 0h1.674m-150.696 0h1.674"
                                        class="C D E" />
                                    <path d="M121.264 47.475c6.093 1.704 9.14 3.238 9.14 4.603" stroke="#170040"
                                        class="C D G" />
                                    <path
                                        d="M3.093 132.455l-.3-33.292L1 98.633v-12.7l42.558-4.92 42.558 4.92v12.7l-1.783.53-.3 33.292-40.465 9.003z"
                                        class="D E H" />
                                    <path fill-opacity=".5" fill="#c2cbd2"
                                        d="M1 86.62l42.558-4.92v62.122l-40.465-7.31-.3-37.35L1 98.633z" />
                                    <g class="D E H">
                                        <path d="M3.093 136.513l-.3-37.35 40.775 5.6 40.775-5.6-.3 37.35-40.465 7.607z" />
                                        <path d="M1 98.633V86.41l42.558 5.088 42.558-5.088v12.224l-42.558 6.12z" />
                                    </g>
                                    <path fill-opacity=".5"
                                        d="M83.508 113.56v-13.6l-34.92 4.804zm1.9-26.454l-41.18 5.1.1 11.74 41.08-5.85z"
                                        fill="#c2cbd2" />
                                    <g class="D E">
                                        <path d="M43.558 91.497v52.326" />
                                        <g class="B F">
                                            <path
                                                d="M76.532 65.72c-6.107 5.778-16.427 9.333-18.62 13.24-1.628 2.9-2.144 7.78-1.874 11.144 3.335-.325 4.11-.45 6.436-.838-.273-3.572.4-5.742 1.16-6.798 2.537-3.484 18.037-7.733 18.303-11"
                                                class="C G" />
                                            <path
                                                d="M141.144 29.827L89.04 29.01c-3.54-.056-6.93 1.425-9.295 4.06l-2.888 3.216c-.724.806-1.365 1.684-1.912 2.62-1.976 3.378-2.985 5.908-3.04 7.53-.703 20.954-.858 36.17-.467 45.636.178 4.308.765 8.13 1.76 11.47a16.05 16.05 0 0 0 15.38 11.469h59.993a16.05 16.05 0 0 0 16.046-16.046v-49.83c0-6.943-4.466-13.1-11.066-15.254l-12.41-4.05z" />
                                        </g>
                                    </g>
                                    <rect x="70.332" y="28.22" width="81.73" height="81.882" rx="21.767"
                                        class="B F" />
                                    <g class="D E B F">
                                        <rect x="71.03" y="28.917" width="80.334" height="80.487" rx="16.744" />
                                        <g class="C G">
                                            <use xlink:href="#B" />
                                            <use xlink:href="#B" x="-23.441" />
                                        </g>
                                    </g>
                                    <rect fill-opacity=".7" fill="#e6e9ec" x="75.291" y="32.893" width="71.86"
                                        height="71.86" rx="11.498" class="F" />
                                    <path
                                        d="M97.123 72.242c0 1.8-2.25 3.28-5.023 3.28s-5.023-1.47-5.023-3.28 2.25-3.28 5.023-3.28 5.023 1.47 5.023 3.28m23.44 0c0 1.8 2.25 3.28 5.023 3.28s5.023-1.47 5.023-3.28-2.25-3.28-5.023-3.28-5.023 1.47-5.023 3.28"
                                        class="H" />
                                    <g class="D E">
                                        <path
                                            d="M94.325 70.656c2.986 0 5.733-2.328 5.733-5.877s-2.328-5.654-5.315-5.654-5.5 2.547-5.5 6.095 2.094 5.436 5.08 5.436z"
                                            class="B" />
                                        <path d="M94.08 62.234c-.772 1.904-.772 3.548 0 4.932" class="C" />
                                        <path
                                            d="M123.592 70.656c-2.986 0-5.733-2.328-5.733-5.877s2.328-5.654 5.315-5.654 5.5 2.547 5.5 6.095-2.094 5.436-5.08 5.436z"
                                            class="B" />
                                        <path d="M123.838 62.234c.772 1.904.772 3.548 0 4.932" class="C" />
                                        <g class="B">
                                            <path
                                                d="M172.708 136.447h-7.356l-1.266-2.218-6.018-10.082-.083-.154c-.895-1.75-.653-3.892 1.096-4.788.14-.072.285-.133.434-.184a3.23 3.23 0 0 1 3.919 1.606c.044.088.102.226.173.414l2.072 6.425c-.09-.562-.566-4.083-1.427-10.565a4.38 4.38 0 0 1 3.985-4.737 4.34 4.34 0 0 1 .558-.012l.25.01c2.464.103 4.378 2.184 4.275 4.647-.003.084-.01.167-.018.25l-1.914 14.53c.024.8.697-1.637 2.02-7.308a2.66 2.66 0 0 1 3.782-1.39c1.49.83 1.588 2.23.763 3.724l-5.247 9.83z" />
                                            <path
                                                d="M161.104 130.992c3.01 0 5.462 2.38 5.577 5.362l.003.218h-11.162c.001-3.01 2.382-5.46 5.362-5.576l.22-.004z" />
                                        </g>
                                        <ellipse fill="#a4afb7" cx="108.789" cy="83.823" rx="5.233" ry="6.977" />
                                        <g class="B">
                                            <path
                                                d="M108.8 81.023c2.9 0 4.255-.993 4.06-1.342-.96-1.73-2.422-2.834-4.06-2.834-1.594 0-3.022 1.046-3.982 2.695-.155.267 1.092 1.48 3.982 1.48z" />
                                            <path
                                                d="M158.6 79.778c5.473 3.196 11.174 10.04 14.06 9.766 5.987-.57 6.628-9.173 7.166-17.228.674-10.082 6.255 1.37 9.17-5.638 1.505-3.617-5.528-7.05-9.17-5.5s-4.14 4.532-4.494 7.385c-.233 1.87-1.567 13.905-2.98 13.743-2.796-.32-9.738-10.83-13.75-11.65"
                                                class="C F G" />
                                        </g>
                                        <path
                                            d="M194.848 50.46c4.93 2.962 7.9 7.255 8.917 12.88m-.695-12.957c.56.286 4.166 2.128 4.5 6.606"
                                            class="C" />
                                    </g>
                                    <path d="M85.828 39.033c-2.26 1.377-3.86 3.128-4.802 5.253" stroke="#fff"
                                        stroke-width="3.349" class="C" />
                                    <circle cx="79.408" cy="49.399" r="1.326" class="B" />
                                    <g class="D E">
                                        <g class="C">
                                            <path
                                                d="M96.774 47.475c-6.093 1.704-9.14 3.238-9.14 4.603m34.884-4.603c6.093 1.704 9.14 3.238 9.14 4.603"
                                                class="G" />
                                            <path
                                                d="M23.195 55.836c.46 3.045 2.795 1.956 3.087 1.774 1.88-1.173 3.03-1.663 4.342-.56 2.022 1.7-1.555 4.872.66 6.486 2.658 1.937 3.704-3.687 6.936-1.772S36.7 67.4 42.388 67.9M49.52 2.425c2.207.194 4.164 1.2 4.164 3.22 0 2.44-4.174 2.955-3.376 5.577.957 3.146 4.952-.44 5.836 3.482s-7.248 3.923-1.817 7.837" />
                                        </g>
                                        <g class="B">
                                            <path
                                                d="M47.182 41.33l9.2 2.19a.35.35 0 0 1 .166.586l-7 7a.35.35 0 0 1-.586-.166l-2.19-9.2a.35.35 0 0 1 .42-.42z" />
                                            <circle cx="28.907" cy="32.893" r="4.884" />
                                        </g>
                                    </g>
                                </g>
                                <defs>
                                    <path id="B"
                                        d="M123.276 112.706l.55 18.708h-1.3c-1.432 0-2.593 1.16-2.593 2.593s1.16 2.593 2.593 2.593h4.065a3.49 3.49 0 0 0 3.49-3.49c0-.594-1.432-9.597-1.126-20.405" />
                                </defs>
                            </svg>
                            <h3 style="font-size: 24px;" class="mt-4 no-results">Esta é uma área restrita protegida com criptografia. <i class="fad fa-lock-alt fa-fw"></i></h3>
                            <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                                <h3 style="font-size: 26px;" class="no-results-create mb-3">
                                    Para continuar, digite sua senha. 
                                    <span wire:ignore style="cursor: pointer; font-size: 20px;" class="info-total-cx" id="tt-info" data-html="true" data-toggle="tooltip" title="Para sua segurança, o gerenciador de senhas da <b>Cashiers</b> é bloqueado por senha. Esta ferramente te permite cadastrar senhas pessoais com a segurança da criptografia <b><u>bcrypt</u></b>." data-placement="bottom">
                                        <i class="fa-fw fad fa-info-circle info-ret"></i>
                                    </span>
                                </h3>

                                <div style="width: 100%;" class="d-flex flex-row align-items-center my-3">
                                    <input style="-webkit-text-security: disc;" wire:model.defer="pass" wire:keydown.enter="authenticate()" wire:loading.attr="disabled" type="text" class="form-control modal-input" placeholder="Digite sua senha" autocomplete="new-password" autofocus>
                                    <button wire:click.prevent="authenticate()" wire:loading.attr="disabled" style="white-space: nowrap;" class="btn btn-new ml-2">
                                        Desbloquear <i class="fad fa-lock-open-alt fa-fw ml-1"></i>
                                    </button>
                                </div>
                                
                                <h3 style="font-size: 22px; color: #666;" class="no-results-create my-3">Precisa de ajuda?</h3>
                                <a target="_blank" href="https://api.whatsapp.com/send?phone=5534998395367&text=Ol%C3%A1!%20Preciso%20de%20ajuda%20com%20a%20Plataforma%20Cashiers!" class="ml-2 btn btn-nr"><i class="fad fa-user-headset fa-lg mr-2"></i>Fale conosco</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        @elseif($locker == 'unlocked')
            <div class="div-unlocked">

                @if ($secrets->count())

                <div class="links-box">
                    <div class="row">
                    
                        @foreach ($secrets as $secret)
                            
                            <div class="col-3">
                                
                                <div class="link-container">
                                    
                                    <div class="link-box">
                                        
                                        <div class="d-flex flex-row justify-content-end align-items-center">                                                                             
                                            
                                            <div style="cursor: help !important;" class="div-link mr-auto" data-tooltip="Protegida com criptografia" data-flow="right">
                                                <i style="color: #3b82f6; cursor: help !important;" class="fad fa-lock-alt fa-crud fac-cor"></i>                                        
                                            </div> 
                                            
                                        </div>

                                        <p style="color: #555555; user-select: none;" class="link-desc text-center">{{$secret->descricao}}</p>
                                        
                                        <div class="d-flex flex-row justify-content-end align-items-center mt-3">

                                            <div wire:key="{{'folder-'.$secret->id}}" wire:loading wire:target="openFolder({{$secret->id}})">
                                                <i style="color: #725BC2 !important;" class="fad fa-spinner-third fa-fw fa-crud fac-edit fa-spin"></i>
                                            </div>

                                            <div wire:key="{{'edit-'.$secret->id}}" wire:loading wire:target="editSecret({{$secret->id}})">
                                                <i style="color: #725BC2 !important;" class="fad fa-spinner-third fa-fw fa-crud fac-edit fa-spin"></i>
                                            </div>

                                            <div wire:key="{{'delete-'.$secret->id}}" wire:loading wire:target="deleteSecret({{$secret->id}})">
                                                <i style="color: #725BC2 !important;" class="fad fa-spinner-third fa-fw fa-crud fac-edit fa-spin"></i>
                                            </div>

                                            <div wire:click.prevent="openFolder({{$secret->id}})" data-tooltip="Abrir" data-flow="bottom" class="cbe">
                                                <i style="color: #eab308 !important;" class="fas fa-folder-open fa-fw fa-crud fac-edit"></i>
                                            </div>

                                            <div wire:click.prevent="editSecret({{$secret->id}})" data-tooltip="Editar" data-flow="bottom" class="cbe">
                                                <i class="fad fa-edit fa-fw fa-crud fac-edit"></i>
                                            </div>

                                            <div wire:click.prevent="deleteSecret({{$secret->id}})" data-tooltip="Apagar" data-flow="bottom" class="cba">
                                                <i class="fad fa-trash fa-fw fa-crud fac-del"></i>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                
                            </div>

                        @endforeach
                        
                    </div>
                </div>

                @else

                <div class="card">

                    <div wire:target="render, search, qtd, updatingSearch" wire:loading.remove class="card-body px-0 pb-0">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="211"
                                height="145">
                                <style>
                                    <![CDATA[
                                    .B {
                                        fill: #fff
                                    }

                                    .C {
                                        stroke-linecap: round
                                    }

                                    .D {
                                        stroke-width: 1.395
                                    }

                                    .E {
                                        stroke: #a4afb7
                                    }

                                    .F {
                                        fill-rule: nonzero
                                    }

                                    .G {
                                        stroke-linejoin: round
                                    }

                                    .H {
                                        fill: #d5dadf
                                    }

                                    ]]>
                                </style>
                                <g fill="none" fill-rule="evenodd">
                                    <path
                                        d="M53.803 136.846h122.8m3.907 0h5.58m-141.207 0h5.58m138.977 0h1.674m-150.696 0h1.674"
                                        class="C D E" />
                                    <path d="M121.264 47.475c6.093 1.704 9.14 3.238 9.14 4.603" stroke="#170040"
                                        class="C D G" />
                                    <path
                                        d="M3.093 132.455l-.3-33.292L1 98.633v-12.7l42.558-4.92 42.558 4.92v12.7l-1.783.53-.3 33.292-40.465 9.003z"
                                        class="D E H" />
                                    <path fill-opacity=".5" fill="#c2cbd2"
                                        d="M1 86.62l42.558-4.92v62.122l-40.465-7.31-.3-37.35L1 98.633z" />
                                    <g class="D E H">
                                        <path d="M3.093 136.513l-.3-37.35 40.775 5.6 40.775-5.6-.3 37.35-40.465 7.607z" />
                                        <path d="M1 98.633V86.41l42.558 5.088 42.558-5.088v12.224l-42.558 6.12z" />
                                    </g>
                                    <path fill-opacity=".5"
                                        d="M83.508 113.56v-13.6l-34.92 4.804zm1.9-26.454l-41.18 5.1.1 11.74 41.08-5.85z"
                                        fill="#c2cbd2" />
                                    <g class="D E">
                                        <path d="M43.558 91.497v52.326" />
                                        <g class="B F">
                                            <path
                                                d="M76.532 65.72c-6.107 5.778-16.427 9.333-18.62 13.24-1.628 2.9-2.144 7.78-1.874 11.144 3.335-.325 4.11-.45 6.436-.838-.273-3.572.4-5.742 1.16-6.798 2.537-3.484 18.037-7.733 18.303-11"
                                                class="C G" />
                                            <path
                                                d="M141.144 29.827L89.04 29.01c-3.54-.056-6.93 1.425-9.295 4.06l-2.888 3.216c-.724.806-1.365 1.684-1.912 2.62-1.976 3.378-2.985 5.908-3.04 7.53-.703 20.954-.858 36.17-.467 45.636.178 4.308.765 8.13 1.76 11.47a16.05 16.05 0 0 0 15.38 11.469h59.993a16.05 16.05 0 0 0 16.046-16.046v-49.83c0-6.943-4.466-13.1-11.066-15.254l-12.41-4.05z" />
                                        </g>
                                    </g>
                                    <rect x="70.332" y="28.22" width="81.73" height="81.882" rx="21.767"
                                        class="B F" />
                                    <g class="D E B F">
                                        <rect x="71.03" y="28.917" width="80.334" height="80.487" rx="16.744" />
                                        <g class="C G">
                                            <use xlink:href="#B" />
                                            <use xlink:href="#B" x="-23.441" />
                                        </g>
                                    </g>
                                    <rect fill-opacity=".7" fill="#e6e9ec" x="75.291" y="32.893" width="71.86"
                                        height="71.86" rx="11.498" class="F" />
                                    <path
                                        d="M97.123 72.242c0 1.8-2.25 3.28-5.023 3.28s-5.023-1.47-5.023-3.28 2.25-3.28 5.023-3.28 5.023 1.47 5.023 3.28m23.44 0c0 1.8 2.25 3.28 5.023 3.28s5.023-1.47 5.023-3.28-2.25-3.28-5.023-3.28-5.023 1.47-5.023 3.28"
                                        class="H" />
                                    <g class="D E">
                                        <path
                                            d="M94.325 70.656c2.986 0 5.733-2.328 5.733-5.877s-2.328-5.654-5.315-5.654-5.5 2.547-5.5 6.095 2.094 5.436 5.08 5.436z"
                                            class="B" />
                                        <path d="M94.08 62.234c-.772 1.904-.772 3.548 0 4.932" class="C" />
                                        <path
                                            d="M123.592 70.656c-2.986 0-5.733-2.328-5.733-5.877s2.328-5.654 5.315-5.654 5.5 2.547 5.5 6.095-2.094 5.436-5.08 5.436z"
                                            class="B" />
                                        <path d="M123.838 62.234c.772 1.904.772 3.548 0 4.932" class="C" />
                                        <g class="B">
                                            <path
                                                d="M172.708 136.447h-7.356l-1.266-2.218-6.018-10.082-.083-.154c-.895-1.75-.653-3.892 1.096-4.788.14-.072.285-.133.434-.184a3.23 3.23 0 0 1 3.919 1.606c.044.088.102.226.173.414l2.072 6.425c-.09-.562-.566-4.083-1.427-10.565a4.38 4.38 0 0 1 3.985-4.737 4.34 4.34 0 0 1 .558-.012l.25.01c2.464.103 4.378 2.184 4.275 4.647-.003.084-.01.167-.018.25l-1.914 14.53c.024.8.697-1.637 2.02-7.308a2.66 2.66 0 0 1 3.782-1.39c1.49.83 1.588 2.23.763 3.724l-5.247 9.83z" />
                                            <path
                                                d="M161.104 130.992c3.01 0 5.462 2.38 5.577 5.362l.003.218h-11.162c.001-3.01 2.382-5.46 5.362-5.576l.22-.004z" />
                                        </g>
                                        <ellipse fill="#a4afb7" cx="108.789" cy="83.823" rx="5.233" ry="6.977" />
                                        <g class="B">
                                            <path
                                                d="M108.8 81.023c2.9 0 4.255-.993 4.06-1.342-.96-1.73-2.422-2.834-4.06-2.834-1.594 0-3.022 1.046-3.982 2.695-.155.267 1.092 1.48 3.982 1.48z" />
                                            <path
                                                d="M158.6 79.778c5.473 3.196 11.174 10.04 14.06 9.766 5.987-.57 6.628-9.173 7.166-17.228.674-10.082 6.255 1.37 9.17-5.638 1.505-3.617-5.528-7.05-9.17-5.5s-4.14 4.532-4.494 7.385c-.233 1.87-1.567 13.905-2.98 13.743-2.796-.32-9.738-10.83-13.75-11.65"
                                                class="C F G" />
                                        </g>
                                        <path
                                            d="M194.848 50.46c4.93 2.962 7.9 7.255 8.917 12.88m-.695-12.957c.56.286 4.166 2.128 4.5 6.606"
                                            class="C" />
                                    </g>
                                    <path d="M85.828 39.033c-2.26 1.377-3.86 3.128-4.802 5.253" stroke="#fff"
                                        stroke-width="3.349" class="C" />
                                    <circle cx="79.408" cy="49.399" r="1.326" class="B" />
                                    <g class="D E">
                                        <g class="C">
                                            <path
                                                d="M96.774 47.475c-6.093 1.704-9.14 3.238-9.14 4.603m34.884-4.603c6.093 1.704 9.14 3.238 9.14 4.603"
                                                class="G" />
                                            <path
                                                d="M23.195 55.836c.46 3.045 2.795 1.956 3.087 1.774 1.88-1.173 3.03-1.663 4.342-.56 2.022 1.7-1.555 4.872.66 6.486 2.658 1.937 3.704-3.687 6.936-1.772S36.7 67.4 42.388 67.9M49.52 2.425c2.207.194 4.164 1.2 4.164 3.22 0 2.44-4.174 2.955-3.376 5.577.957 3.146 4.952-.44 5.836 3.482s-7.248 3.923-1.817 7.837" />
                                        </g>
                                        <g class="B">
                                            <path
                                                d="M47.182 41.33l9.2 2.19a.35.35 0 0 1 .166.586l-7 7a.35.35 0 0 1-.586-.166l-2.19-9.2a.35.35 0 0 1 .42-.42z" />
                                            <circle cx="28.907" cy="32.893" r="4.884" />
                                        </g>
                                    </g>
                                </g>
                                <defs>
                                    <path id="B"
                                        d="M123.276 112.706l.55 18.708h-1.3c-1.432 0-2.593 1.16-2.593 2.593s1.16 2.593 2.593 2.593h4.065a3.49 3.49 0 0 0 3.49-3.49c0-.594-1.432-9.597-1.126-20.405" />
                                </defs>
                            </svg>
                            <h3 class="my-4 no-results">Não há senhas a serem exibidas.</h3>
                            <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                                <h3 class="no-results-create mb-3">Comece cadastrando uma</h3>
                                <a data-toggle="modal" data-target="#operacao" class="ml-2 btn btn-nr">+ Nova senha</a>
                            </div>
                        </div>
                    </div>

                </div>

                @endif

            </div>
        @endif

        <div style="user-select: none; padding-bottom: 150px;"
            class="d-flex flex-row align-items-center justify-content-between">
        </div>

    </div>

    <!-- MODAL FOLDER -->

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="folder-secret" tabindex="-1"
    aria-labelledby="folder-secretLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3 text-truncate" id="folder-secretLabel">{{$data_pass->descricao ?? null}}</h5>
                    <button wire:click.prevent="resetOpen()" type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 style="font-size: 24px; word-wrap: break-word;" class="modal-confirmation-msg m-0 text-center px-4 mb-3">
                        Dados de senha de: <span class="text-bold">{{$data_pass->descricao ?? null}}</span>
                    </h5>

                    <div class="confirmation-msg text-center mt-4 mb-0">

                        <div class="row">
                            <div id="data-bank" class="col-12">
                                
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item text-left flex-fill list-secret">
                                        <i style="color: #725BC2;" class="fad fa-user-circle fa-fw mr-2 fa-lg"></i>Login
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill" style="word-break: break-all;">
                                        
                                        <div class="d-flex flex-row align-items-center justify-content-between">
                                            
                                            <span id="login-data-secret">
                                                {{$data_pass->login ?? "Não definido"}}
                                            </span>

                                            @if(isset($data_pass))

                                                @if (!is_null($data_pass->login))

                                                    <div wire:click.prevent="showAlert()" class="div-copy-secret-log copy-login" data-clipboard-target="#login-data-secret" data-tooltip="Copiar" data-flow="right">
                                                        <i style="color: #3b82f6;" class="fad fa-copy fa-fw fa-lg ml-3"></i>
                                                    </div>

                                                @endif 

                                            @endif

                                        </div>

                                    </li>
                                </ul>
                                <ul class="list-group list-group-horizontal mt-2">
                                    <li class="list-group-item text-left flex-fill list-secret">
                                        <i style="color: #725BC2;" class="fad fa-lock-alt fa-fw mr-2 fa-lg"></i>Senha
                                    </li>
                                    <li class="list-group-item text-right list-bank-info flex-fill" style="word-break: break-all;">

                                        <div class="d-flex flex-row align-items-center justify-content-between">

                                            <span id="senha-data-secret" class="@if($blur == 'yes') blur-secret @endif">                                               
                                                {{$data_pass->senha ?? null}}                                                
                                            </span>
                                            
                                            <div class="div-block-secret-pass d-flex flex-row align-items-center">

                                                @if($blur == 'yes')
                                                    <div wire:click.prevent="toggleBlur()" class="div-copy-secret-pass" data-tooltip="Exibir" data-flow="top">
                                                        <i style="color: #0696BD;" class="fad fa-eye fa-fw fa-lg ml-3"></i>
                                                    </div>
                                                @elseif($blur == 'no')
                                                    <div wire:click.prevent="toggleBlur()" class="div-copy-secret-pass" data-tooltip="Ocultar" data-flow="top">
                                                        <i style="color: #0696BD;" class="fad fa-eye-slash fa-fw fa-lg ml-3"></i>
                                                    </div>
                                                @endif                                                                                  

                                                <div wire:click.prevent="showAlert()" class="div-copy-secret-pass copy-senha" data-clipboard-target="#senha-data-secret" data-tooltip="Copiar" data-flow="right">
                                                    <i style="color: #3b82f6;" class="fad fa-copy fa-fw fa-lg ml-2"></i>
                                                </div>

                                            </div>
                                            

                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>

                </div>
                <div class="modal-footer py-4 d-flex flex-row align-items-center justify-content-end">
                    <button wire:click.prevent="resetOpen()" type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL FOLDER -->

    <!-- MODAL DELETE SECRET -->

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="delete-secret" tabindex="-1"
    aria-labelledby="delete-secretLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="delete-secretLabel">Confirmação de apagamento</h5>
                    <button wire:click.prevent="resetDelete()" type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente apagar estes dados de senha?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            <span class="msg-bold">Atenção: </span> esta ação é irreversível, após apagados, <span class="msg-bold">estes dados não poderão ser recuperados.</span> Certifique-se de ter estes dados de senha salvos em outro lugar caso necessite consultá-los futuramente.            
                        </p>
                    </div>

                    <h5 style="font-size: 22px;" class="modal-confirmation-msg m-0 text-center px-4 my-3">Para apagar, digite sua senha.</h5>

                    <div class="div-deleting-pass px-4">
                        <input style="-webkit-text-security: disc;" wire:model.defer="pass_to_delete" wire:keydown.enter="delete()" wire:loading.attr="disabled" type="text" class="form-control modal-input" placeholder="Digite sua senha" autocomplete="new-password">
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button wire:click.prevent="resetDelete()" type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="delete()" type="button"
                        class="btn btn-send">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE SECRET -->

    <!-- MODAL EDIT SECRET -->

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="edit-secret" tabindex="-1" aria-labelledby="edit-secretLabel" aria-hidden="true"
    wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="edit-secretLabel">Editar senha</h5>
                    <button wire:click.prevent="resetEdit()" type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <form wire:submit.prevent="update()">
                        
                        <div class="form-group">
                            <label class="modal-label" for="desc-op">Descrição <span class="red">*</span></label>
                            <input wire:model.defer="data_pass_edit.descricao" type="text" class="form-control modal-input"
                                id="desc-op" autocomplete="off"> 
                            @error('data_pass_edit.descricao')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="modal-label" for="desc-op">Login <span style="font-size: 13px;">(opcional)</span></label>
                            <input wire:model.defer="data_pass_edit.login" type="text" class="form-control modal-input"
                                id="desc-op" autocomplete="off" placeholder="E-mail, usuário, conta..."> 
                            @error('data_pass_edit.login')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label class="modal-label" for="desc-op">Senha <span class="red">*</span></label>
                            <div class="d-flex flex-row align-items-center">
                                <input @if($blur == 'yes') style="-webkit-text-security: disc;" @endif wire:model.defer="data_pass_edit.senha" type="text" class="form-control modal-input" id="desc-op" autocomplete="off">
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

                            @error('data_pass_edit.senha')
                                <span class="wire-error">{{ $message }}</span>
                            @enderror

                        </div>

                </div>
                <div class="modal-footer py-4">

                    <button wire:loading.attr="disabled" type="button" class="btn btn-cancel"
                        wire:click.prevent="resetEdit()" data-dismiss="modal">Cancelar</button>
                    <button wire:key="btn-cad-secret" wire:loading.attr="disabled" wire:target="update" type="submit" class="btn btn-send">Editar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT SECRET -->

    <!-- MODAL CONFIRMAR EDIT SECRET -->

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="confirm-edit-secret" tabindex="-1"
    aria-labelledby="confirm-edit-secretLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="confirm-edit-secretLabel">Confirmação de edição</h5>
                    <button wire:click.prevent="resetEditOnConfirmation()" type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 my-3">Deseja realmente editar estes dados de senha?</h5>

                    <div class="confirmation-msg text-center mb-3">
                        <p class="m-0 mb-3 px-4">
                            <span class="msg-bold">Atenção: </span> esta ação é irreversível, após editados, <span class="msg-bold">estes dados não poderão ser revertidos.</span> Certifique-se de ter estes dados de senha salvos em outro lugar caso necessite recuperá-los futuramente.            
                        </p>
                    </div>

                    <h5 style="font-size: 22px;" class="modal-confirmation-msg m-0 text-center px-4 my-3">Para editar, digite sua senha.</h5>

                    <div class="div-deleting-pass px-4">
                        <input style="-webkit-text-security: disc;" wire:model.defer="pass_to_edit" wire:keydown.enter="finishUpdate()" wire:loading.attr="disabled" type="text" class="form-control modal-input" placeholder="Digite sua senha" autocomplete="new-password">
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button wire:click.prevent="resetEditOnConfirmation()" type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="finishUpdate()" type="button"
                        class="btn btn-send">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CONFIRMAR EDIT SECRET -->

</div>

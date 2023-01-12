<div>
    <div class="d-flex flex-row justify-content-between">
        <h1 class="home-title text-truncate">Olá, {{ Auth::user()->name }}!</h1>

        <div style="position: relative;">

            <img style="object-fit: cover; user-select: none; position: relative;" class="img-user img-circle" src="{{ Auth::user()->profile_photo_url }}">

            {{-- <img class="natal-home-hat" src="{{asset('vendor/adminlte/dist/img/santa-hat.png')}}"> --}}
            
        </div>

    </div>

    <div style="margin-top: -30px;" class="d-flex flex-row align-items-center">

        <div style="position: relative;" class="img-bear">
            {{-- <img class="natal-bear-hat" src="{{asset('vendor/adminlte/dist/img/santa-hat-32.png')}}"> --}}
            <img style="margin-bottom: -20px; user-select: none;" src="{{asset('vendor/adminlte/dist/img/no-results-300.png')}}">
        </div>

        <div class="align-self-middle">
            <p class="initial-msg mb-0">Bem-vindo à <span class="panel-adm">Plataforma Cashiers</span>!</p>
            <p class="initial-msg mb-0">Último login: {{ $last_login }} - há {{ $diferenca }} {{ $tempo }}</p>
        </div>
    </div>

    <div class="modal fade" id="modalHome" tabindex="-1"
        aria-labelledby="modalHomeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="modalHomeLabel">Novidades</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4 yampay-scroll">

                    <div class="confirmation-msg text-center">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 mb-3">Gerenciador de Senhas!</h5>

                        <p style="font-size: 18px;" class="m-0 mb-3 px-4">
                            Chegou o Gerenciador de Senhas pessoais da <span class="msg-bold">Cashiers</span>! Esta ferramenta te permite cadastrar senhas pessoais com a segurança da criptografia <a class="home-link" href="https://pt.wikipedia.org/wiki/Bcrypt" target="_blank"><span class="msg-bold">bcrypt</span></a>. Clique no menu <span class="msg-bold">"Minhas senhas"</span> para conhecer!
                        </p>

                        <span style="font-size: 14px; user-select: none;">Imagem meramente ilustrativa</span>
                        <img style="width: 500px; height: 238px; pointer-events: none; user-drag: none;" class="rounded mx-auto d-block border" src="{{'vendor/adminlte/dist/img/gerenciador-de-senhas.png'}}">

                        <p style="font-size: 18px;" class="m-0 mt-3 px-4 mb-4">
                            As informações que você cadastrar estarão sempre <span class="msg-bold">protegidas na Cashiers</span>, no entanto, certifique-se sempre de escolher uma <span class="msg-bold">senha forte para suas contas pessoais</span>. Nossa equipe <span class="msg-bold">nunca solicitará a senha de sua conta na plataforma</span>, guarde-a com segurança para ter acesso a esta ferramenta sempre que precisar consultar uma de suas senhas pessoais!
                        </p>

                        <hr class="my-3">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 mb-3 mt-4">Você no controle de tudo!</h5>

                        <p style="font-size: 18px;" class="m-0 mb-3 px-4">
                            Agora nossa plataforma conta com uma amigável <span class="msg-bold">interface de notificações</span> para você ficar por dentro de tudo que acontece em sua conta!
                        </p>

                        <span style="font-size: 14px; user-select: none;">Imagem meramente ilustrativa</span>
                        <img style="width: 431px; height: 304px; pointer-events: none; user-drag: none;" class="rounded mx-auto d-block" src="{{'vendor/adminlte/dist/img/novidade1.png'}}">

                        <p style="font-size: 18px;" class="m-0 mt-3 px-4 mb-4">
                            Fique sempre atento às notificações, pois sempre te enviaremos <span class="msg-bold">informações importantes</span> sobre seu plano, mensalidades e comissões. 
                        </p>

                        <hr class="my-3">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 mt-4 mb-3">Confira nosso novo menu!</h5>

                        <p style="font-size: 18px;" class="m-0 my-3 px-4">
                            Na seção <span class="msg-bold">"Minha conta"</span>, você pode acompanhar o andamento de seu plano, visualizar suas mensalidades, realizar pagamentos, ver detalhes de suas comissões e muito mais! 
                        </p>

                        <span style="font-size: 14px; user-select: none;">Imagem meramente ilustrativa</span>
                        <img style="width: 362px; height: 274px; pointer-events: none; user-drag: none;" class="rounded mx-auto d-block mb-4" src="{{'vendor/adminlte/dist/img/novidade2.png'}}">

                        <hr class="my-3">

                        <h5 class="modal-confirmation-msg m-0 text-center px-4 mt-4 mb-3">Sistema de Comissões!</h5>

                        <p style="font-size: 18px;" class="m-0 my-3 px-4">
                            Para ficar por dentro do <span class="msg-bold">sistema de comissões</span> e entender como você pode <span style="color: #16a34a;" class="msg-bold">ganhar dinheiro com a plataforma</span> 🤑, vá até a seção <span class="msg-bold">"Minha conta"</span>, em seguida <span class="msg-bold">> "Minhas comissões"</span>, e clique no botão <span style="color: #725BC2;" class="msg-bold">"Como funciona?"</span>.
                        </p>

                        <span style="font-size: 14px; user-select: none;">Imagem meramente ilustrativa</span>
                        <img style="width: 393px; height: 345px; pointer-events: none; user-drag: none;" class="rounded mx-auto d-block border mb-4" src="{{'vendor/adminlte/dist/img/novidade3.png'}}">
                        
                        <hr class="my-3">

                        <p style="font-size: 18px;" class="m-0 mt-4 px-4">
                            Ficou com alguma dúvida ou quer nos dar alguma sugestão de melhoria?<br><span class="msg-bold">Entre em contato</span>!
                        </p>
                        <a style="font-size: 18px !important;" href="https://api.whatsapp.com/send?phone=5534998395367&amp;text=Ol%C3%A1!%20Quero%20fazer%20uma%20sugestão%20de%20melhoria%20para%20a%20Cashiers!" target="_blank" type="button" class="px-4 verify-font">Fale conosco</a>

                    </div>

                </div>
                <div class="modal-footer py-4 d-flex flex-row align-items-center justify-content-between">
                    <a wire:click.prevent="doNotShowAgain({{auth()->user()->id}})" wire:loading.attr="disabled" style="font-size: 14px !important; cursor: pointer;" class="px-4 verify-font" data-dismiss="modal">Não mostrar novamente</a>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

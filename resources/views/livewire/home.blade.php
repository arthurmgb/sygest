<div>
    <div class="d-flex flex-row justify-content-between">
        <h1 class="home-title">Olá, {{ Auth::user()->name }}!</h1>
        <img style="object-fit: cover;" class="img-user img-circle" src="{{ Auth::user()->profile_photo_url }}">
    </div>

    <div class="initial-div">
        <p class="initial-msg mb-0">Seja bem-vindo ao <span class="panel-adm">Painel Administrativo</span>!</p>
        <p class="initial-msg mb-0">Último acesso: {{ $last_login }} - há {{ $diferenca }} {{ $tempo }}</p>
    </div>
    <div class="modal fade" id="modalHome" tabindex="-1"
        aria-labelledby="modalHomeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title px-3 py-3" id="modalHomeLabel">Apoio à plataforma</h5>
                    <button type="button" class="close px-4" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body py-4 px-4">

                    <h5 class="modal-confirmation-msg m-0 text-center px-4 mb-3">Quer apoiar o crescimento da plataforma?</h5>

                    <div class="confirmation-msg text-center">
                        <p style="font-size: 18px;" class="m-0 mb-3 px-4">
                            Doe <span class="msg-bold">qualquer valor</span> pelo <span class="msg-bold">PIX</span> para ajudar o desenvolvimento da plataforma.
                        </p>
                        <img style="width: 400px; height: 347px;" class="rounded mx-auto d-block" src="{{'vendor/adminlte/dist/img/pix-yampay.png'}}">

                        <button onclick="changePix()" id="btn-pix" data-clipboard-text="00020126890014BR.GOV.BCB.PIX01369a7f6ab8-72bc-4d59-b6a0-23268fb8bd490227Apoio à plataforma - Yampay5204000053039865802BR5924Arthur de Oliveira Silva6009SAO PAULO61080540900062070503***63048D87" style="font-size: 18px;" class="copy-pix mt-3 btn btn-new">Copiar código do QR Code <i class="fa-fw fas fa-clone"></i></button>
                        
                        <p style="font-size: 18px;" class="m-0 mt-3 px-4">
                            Quer nos dar alguma sugestão de melhoria? <span class="msg-bold">Entre em contato</span>!
                        </p>
                        <a style="font-size: 18px !important;" href="https://api.whatsapp.com/send?phone=5534998395367&amp;text=Ol%C3%A1!%20Quero%20fazer%20uma%20sugestão%20de%20melhoria%20para%20a%20Yampay!" target="_blank" type="button" class="px-4 verify-font">Fale conosco</a>
                    </div>

                </div>
                <div class="modal-footer py-4">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Fechar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

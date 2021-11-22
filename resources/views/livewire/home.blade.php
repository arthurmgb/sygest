<div>
    <div class="d-flex flex-row justify-content-between">
        <h1 class="home-title">Olá, {{ Auth::user()->name }}!</h1>
        <img style="object-fit: cover;" class="img-user img-circle" src="{{ Auth::user()->profile_photo_url }}">
    </div>

    <div class="initial-div">
        <p class="initial-msg mb-0">Seja bem-vindo ao <span class="panel-adm">Painel Administrativo</span>!</p>
        <p class="initial-msg mb-0">Último acesso: {{ $last_login }} - há {{ $diferenca }} {{ $tempo }}</p>
    </div>
</div>

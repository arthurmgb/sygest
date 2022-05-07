@if (auth()->user()->is_admin == 1)
<li class="nav-item">
    <a style="color: #D4D4DF;" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="Administrador" class="nav-link pl-1" href="{{route('admin')}}" role="button">
        <i class="fal fa-user-shield fa-lg"></i>
    </a>
</li>
@endif
<li class="nav-item">
    <a style="color: #D4D4DF;" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="Tela cheia" class="nav-link pl-1" data-widget="fullscreen" href="#" role="button">
        <i class="fal fa-expand-arrows-alt fa-lg mt-1"></i>
    </a>
</li>
@livewire('bell')
<li class="nav-item">
    <a style="color: #D4D4DF;" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="Configurações" class="nav-link pl-1" href="{{route('configuracoes')}}" role="button">
        <i class="fal fa-cog fa-lg"></i>
    </a>
</li>
<li class="nav-item mr-2">
    <a style="color: #D4D4DF;" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="Ajuda" class="nav-link pl-1" href="https://api.whatsapp.com/send?phone=5534998395367&text=Ol%C3%A1!%20Preciso%20de%20ajuda%20com%20a%20Plataforma%20Cashiers!" target="_blank" role="button">
        <i class="fal fa-question-circle fa-lg"></i>
    </a>
</li>

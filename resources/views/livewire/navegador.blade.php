<div>

    <div class="page-header d-flex flex-row align-items-center mb-2">
        <h2 class="f-h2">Navegador integrado</h2>
        
        <input wire:keydown.enter="get_url()" wire:model.defer="url" placeholder="Digite a URL do site..." type="url" class="input-yampay ml-3" autocomplete="off" autofocus>
        <a wire:click.prevent="get_url()" class="btn btn-new ml-2">Acessar</a> 
        
        <button wire:click.prevent="reset_url()" class="btn button-google ml-2">Google</button>   

        <div class="ml-2" wire:target="render, get_url, reset_url" wire:loading>
            <i style="color: #725BC2; opacity: 90%;" class="fad fa-spinner-third fa-fw fa-2x fa-spin"></i>
        </div>
    </div>

    <iframe class="nav-iframe" @if ($url) src="{{$url}}" @else src="https://www.google.com/webhp?igu=1" @endif width="100%" height="750px"></iframe>

    <div style="user-select: none; padding-bottom: 25px;"
        class="d-flex flex-row align-items-center justify-content-between">
    </div>


</div>


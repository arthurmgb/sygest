@extends('adminlte::page')

@section('title', 'Página inicial')

@section('content_header')
@stop

@section('content')
    <div class="content-inicial">

        @livewire('home')

        <hr style="border-color: #E5E5E5; width: 97%; margin: 0 auto 0 0;">

        <div class="help-div">
            <h3 class="home-subtitle">Tem dúvidas?</h3>
            <a class="home-link"
                href="https://api.whatsapp.com/send?phone=5534998395367&text=Ol%C3%A1!%20Preciso%20de%20ajuda%20com%20o%20sistema%20financeiro%20da%20Yampay!"
                target="_blank"><i class="fas fa-external-link-alt mr10"></i>Acesse nossa central de ajuda</a>
        </div>
    </div>
@stop

@section('footer')
    <strong>Copyright &copy; {{ date('Y') }} <a class="default-link" href="{{ route('home') }}">Yampay</a>.</strong>
    Todos os direitos reservados.
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">
    <style>
        body {
            overflow: hidden;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/newfont.js') }}"></script>
    @if(auth()->user()->modal_start === 1)
        <script>
            $(document).ready(function(){
                $("#modalHome").modal('show');
            });
        </script>
    @endif
    <script>
        function changePix(){
            var btn = document.getElementById("btn-pix");
            btn.innerHTML = 'Copiado!';
            setTimeout(() => {
                btn.innerHTML = 'Copiar código do QR Code <i class="fa-fw fas fa-clone ml-1"></i>';
            }, 1000);
        }
    </script>
@stop

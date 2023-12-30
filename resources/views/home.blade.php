@extends('adminlte::page')

@section('title', 'Página inicial')

@section('content_header')
@stop

@section('content')
    <div class="content-inicial">

        @livewire('home')

        <hr style="border: 1px solid #C3CAD1; width: 100%; margin: 0 auto 0 0;">

        <div class="help-div">
            <h3 class="home-subtitle">Tem alguma dúvida?</h3>
            <a class="home-link"
                href="https://api.whatsapp.com/send?phone={{ config('app.wpp') }}&text=Ol%C3%A1!%20Preciso%20de%20ajuda%20com%20a%20Plataforma%20{{ config('app.name') }}!"
                target="_blank"><i class="fas fa-external-link-alt mr10"></i>Entre em contato com o suporte</a>
        </div>
    </div>
@stop

@section('footer')

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">

    <style>
        body {
            overflow: hidden;
        }
    </style>

    {{-- <style>
        
        /* NATAL STYLES */
        /* .content-wrapper{
           
            background: linear-gradient(0deg, #f3f4f6e8, #f3f4f6e8), url({{asset('vendor/adminlte/dist/img/santa-bg.jpg')}});

            background-position: center;

            background-repeat: no-repeat;
            
            background-size: cover;
            
        }
        .content-inicial{
            background: url({{asset('vendor/adminlte/dist/img/snow.gif')}});
            background-repeat: repeat;
        } */
    </style> --}}

@stop

@section('js')
    <script src="{{ asset('js/newfont.js') }}"></script>
    @if (auth()->user()->modal_start === 1)
        <script>
            $(document).ready(function() {
                $("#modalHome").modal('show');
            });
        </script>
    @endif
    <script>
        function changePix() {
            var btn = document.getElementById("btn-pix");
            btn.innerHTML = 'Copiado!';
            setTimeout(() => {
                btn.innerHTML = 'Copiar código do QR Code <i class="fa-fw fas fa-clone ml-1"></i>';
            }, 1000);
        }
    </script>
@stop

@extends('adminlte::page')

@section('title', 'Meus contratos')

@section('content_header')
@stop

@section('content')

    <div style="max-width: 1600px !important;" class="uk-container">

        @livewire('user-contrato')

    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
    <style>
        @media print {
    
            body * {
                visibility: hidden;
                margin: 0px !important;
            }

            .modal-footer{
                display: none !important;
            }

            @page {
                margin: 0px !important;
                margin-top: 25px !important;
                padding: 0px !important;
                border: 0 !important;
            }

            #get-recibo, #get-recibo * {
                visibility: visible;
                overflow: visible !important;
            }

            #get-recibo .modal-dialog{
                min-width: 100% !important;
            }

        }
    </style>
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
    <script>
        function changePix(){
            var btn = document.getElementById("btn-pix");
            btn.innerHTML = 'Copiado!';
            setTimeout(() => {
                btn.innerHTML = 'Copiar código do QR Code <i class="fa-fw fas fa-clone ml-1"></i>';
            }, 1000);
        }
    </script>
    <script>
        
        var $col = $('#data-bank');
        var $btn_blur = $('#privacy');

        $btn_blur.click(function(){

            if ($col.hasClass("blur-dados")) {
                $col.removeClass('blur-dados');
            }
            else {
                $col.addClass("blur-dados");
            }

        });

    </script>
    <script>
        window.addEventListener('call-print', event =>{
            window.print();
        })
    </script>
@stop
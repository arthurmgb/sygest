@extends('adminlte::page')

@section('title', 'Minhas comissões')

@section('content_header')
@stop

@section('content')

    <div style="max-width: 1600px !important;" class="uk-container">

        @livewire('user-comissao')

    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
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
        function copyInvite(){
            var btn = document.getElementById("btn-invite");
            btn.innerHTML = 'Copiado!';
            setTimeout(() => {
                btn.innerHTML = 'Copiar link de convite <i class="fa-fw fas fa-clone ml-1"></i>';
            }, 1000);
        }
    </script>
    <script>
        window.addEventListener('call-print', event =>{
            window.print();
        })
    </script>
@stop
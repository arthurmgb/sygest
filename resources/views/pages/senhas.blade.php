@extends('adminlte::page')

@section('title', 'Minhas senhas')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('senha')

    </div>

    @livewire('create-secret')

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <style>
        .toastr-secret{
            font-size: 18px;
            top: 40px;
            left: 80px;
        }
    </style>
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
    
            Livewire.hook('message.processed', (message, component) => {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            })
        });
    </script>
    <script>
         $(document).ready(function(){
                toastr.options = {
                    toastClass: 'toastr-secret',
                    positionClass: "toast-top-center",
                    progressBar: true,
                    timeOut: "500",
                }
        });

            window.addEventListener('secret-copiado', event => {
            toastr.success(event.detail.message);
        });
    </script>
@stop
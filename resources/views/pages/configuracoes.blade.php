@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('configuracao')

    </div>
    
    @livewire('create-operator')

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
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
@stop
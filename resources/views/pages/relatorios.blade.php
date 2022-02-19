@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('relatorio')

    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
    <script>
        window.addEventListener('call-print', event =>{
            window.print();
        })
    </script>
@stop
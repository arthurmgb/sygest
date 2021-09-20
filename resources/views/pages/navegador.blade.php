@extends('adminlte::page')

@section('title', 'Navegador integrado')

@section('content_header')
@stop

@section('content')

    <div style="padding: 0px 25px;" class="navegador-integrado">
        @livewire('navegador')
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
@stop
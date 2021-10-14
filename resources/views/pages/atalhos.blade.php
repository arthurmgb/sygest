@extends('adminlte::page')

@section('title', 'Meus links')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('shortcut')

    </div>

    @livewire('create-shortcut')
    
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
    <style>
        .draggable-mirror{
            width: 278.75px !important;
            box-shadow: none !important;
        }
    </style>
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
@stop
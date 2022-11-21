@extends('adminlte::page')

@section('title', 'Área Administrativa')

@section('content_header')
@stop

@section('content')

    <div @if(auth()->user()->is_admin == 1) style="max-width: 100% !important;" @endif class="uk-container">

        @livewire('admin')

    </div>

    @livewire('create-contract')

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
    <style>
        .pe-none{
            pointer-events: none;
        }
    </style>
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
@stop
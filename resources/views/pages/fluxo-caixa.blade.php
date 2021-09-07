@extends('adminlte::page')

@section('title', 'Fluxo de caixa')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('fluxo-caixa')

    </div>

    @livewire('create-op')

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/newfont.js') }}"></script>
@stop

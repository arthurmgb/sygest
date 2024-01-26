@extends('adminlte::page')

@section('title', 'Grupos')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('product-group')

    </div>

    @livewire('create-product-group')

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/newfont.js') }}"></script>
@stop

@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('produto')

    </div>

    @livewire('create-product')
    
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
@stop
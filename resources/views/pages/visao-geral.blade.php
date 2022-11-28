@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

    <div @if(auth()->user()->table_scroll == 1) style="overflow-x: hidden;" @endif class="uk-container">

        @livewire('visao-geral')

    </div>

    @livewire('create-op')

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">
    <style>

        @media only screen and (max-width: 1250px){
            #mq-col-1{
                width: 50% !important;
                min-width: 50% !important;
                max-width: 50% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }
            #mq-col-2{
                width: 50% !important;
                min-width: 50% !important;
                max-width: 50% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }
        }

        @media only screen and (max-width: 1080px){
            #mq-col-1{
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }
            #mq-col-2{
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }
            #mq-col-3{
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                /* background-color: red; */
            }
        }

    </style>
@stop

@section('js')
    <script src="{{ asset('js/newfont.js') }}"></script>
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

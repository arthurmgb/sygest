@extends('adminlte::page')

@section('title', 'Relatórios')

@section('content_header')
@stop

@section('content')

    <div style="max-width: 1600px !important;" class="uk-container">

        @livewire('relatorio')

    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
    <style>
        @media print {
    
            body * {
                visibility: hidden;
                margin: 0px !important;
            }

            .page-header, .card-topo, .card-topo-2, .card-topo-3, .card-topo-4, .calc-button-imp, .btn-cx-hoje{
                display: none !important;
            }

            @page {
                margin: 0px !important;
                margin-top: 5px !important;
                padding: 0px !important;
                border: 0 !important;
            }

            #printable, #printable * {
                visibility: visible;
            }

        }
    </style>
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
    <script>
        window.addEventListener('call-print', event =>{
            window.print();
        })
    </script>
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
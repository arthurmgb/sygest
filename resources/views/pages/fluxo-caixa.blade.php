@extends('adminlte::page')

@section('title', 'Fluxo de caixa')

@section('content_header')
@stop

@section('content')

    <div @if (auth()->user()->table_scroll == 1) style="overflow-x: hidden;" @endif class="uk-container">

        @livewire('fluxo-caixa')

    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">
    <style>
        @media print {
            .content-wrapper {
                margin: 0 !important;
            }

            html,
            body {
                height: 100vh;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            @page {
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
            }

            .table td,
            .table th {
                background-color: transparent !important;
            }

            .cnf-container {
                background-color: unset !important;
            }

            .cnf-table {
                background-color: none !important;
            }

            .modal-dialog {
                max-width: 100% !important;
                width: 100% !important;
                margin-top: 0 !important;
                height: unset;
            }

            .modal-header {
                display: none;
            }

            .modal-footer {
                display: none;
            }

            .modal {
                position: absolute;
                left: 0;
                top: 0;
                margin: 0 !important;
                padding: 0;
                overflow: visible !important;
                padding-right: 0 !important;
            }

            .printable,
            .printable * {
                visibility: visible;
            }
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/newfont.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })

            Livewire.hook('message.processed', (message, component) => {
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            })
        });
    </script>
    <script>
        // drag table
        let isDragging = false;
        let startX;
        let startScrollLeft;

        function startDragging(e) {

            const isTextSelected = window.getSelection().toString() !== '';

            if (isTextSelected) {
                return;
            }
            isDragging = true;
            startX = e.pageX;
            startScrollLeft = document.querySelector('.js-scrollable-table').scrollLeft;

            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', () => {
                isDragging = false;
                document.removeEventListener('mousemove', handleMouseMove);
            });
        }

        function handleMouseMove(e) {
            if (!isDragging) return;
            const scrollableTable = document.querySelector('.js-scrollable-table');
            const scrollX = startScrollLeft + startX - e.pageX;
            scrollableTable.scrollLeft = scrollX;
        }
    </script>
    <script>
        // IMPRIMIR CNF

        let printCnf = document.querySelector("#print-cnf");

        printCnf.addEventListener("click", () => {
            window.print();
        });
    </script>
@stop

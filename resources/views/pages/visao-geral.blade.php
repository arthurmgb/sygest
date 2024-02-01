@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

    <div @if (auth()->user()->table_scroll == 1) style="overflow-x: hidden;" @endif class="uk-container">

        @livewire('visao-geral')

    </div>

    @livewire('create-op')
    @livewire('create-venda')

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">
    <style>
        @media only screen and (max-width: 1250px) {
            #mq-col-1 {
                width: 50% !important;
                min-width: 50% !important;
                max-width: 50% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }

            #mq-col-2 {
                width: 50% !important;
                min-width: 50% !important;
                max-width: 50% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }
        }

        @media only screen and (max-width: 1080px) {
            #mq-col-1 {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }

            #mq-col-2 {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 10px;
                /* background-color: red; */
            }

            #mq-col-3 {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                /* background-color: red; */
            }
        }

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
                margin: 0;
                padding: 0;
                overflow: visible !important;
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
        let btnNewOp = document.querySelector('#js-new-op');
        let btnNewVenda = document.querySelector('#js-new-venda');
        let modalCadOperation = document.querySelector('#operacao');
        let modalConfirmOp = document.querySelector('#confirm-operation');
        let modalPdv = document.querySelector('#venda');

        var canGo = true,
            delay = 500;

        document.addEventListener('keydown', (e) => {

            if ($(modalConfirmOp).is(":visible")) {
                if (e.keyCode == 112) {
                    e.preventDefault();
                    return;
                }
            }

            if ($(modalPdv).is(":visible")) {
                if (e.keyCode == 112) {
                    e.preventDefault();
                    return;
                }
            }

            if (e.keyCode == 112) {

                e.preventDefault();

                if (canGo) {
                    canGo = false;


                    btnNewOp.click();

                    setTimeout(function() {
                        canGo = true;
                    }, delay)

                } else {
                    return;
                }

            }

            if ($(modalPdv).is(":visible")) {
                if (e.keyCode == 113) {
                    e.preventDefault();
                    return;
                }
            }

            if ($(modalCadOperation).is(":visible")) {
                if (e.keyCode == 113) {
                    e.preventDefault();
                    return;
                }
            }

            if (e.keyCode == 113) {

                e.preventDefault();

                if (canGo) {
                    canGo = false;


                    btnNewVenda.click();

                    setTimeout(function() {
                        canGo = true;
                    }, delay)

                } else {
                    return;
                }

            }

        });

        $('#operacao').on('shown.bs.modal', function(event) {
            $('#desc-op').focus();
        });
        $('#venda').on('show.bs.modal', function(event) {
            $('body').css('overflow', 'hidden');
        });
        $('#venda').on('hide.bs.modal', function(event) {
            $('body').css('overflow', 'auto');
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

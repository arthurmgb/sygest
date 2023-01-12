@extends('adminlte::page')

@section('title', 'Retiradas')

@section('content_header')
@stop

@section('content')

    <div @if(auth()->user()->table_scroll == 1) style="overflow-x: hidden;" @endif class="uk-container">

        @livewire('retirada')

    </div>

    @livewire('create-ret')

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
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
    <script>
        
        let btnNewOp = document.querySelector('#js-new-ret');
        let modalConfirmOp = document.querySelector('#confirm-operation');
        
        var canGo = true,
        delay = 500;
        
        document.addEventListener('keydown', (e) =>{

            if($(modalConfirmOp).is(":visible")){
                if(e.keyCode == 112){
                    e.preventDefault();
                    return;
                }
            }

            if(e.keyCode == 112){

                e.preventDefault();

                if (canGo) {
                    canGo = false;
                    
                    
                    btnNewOp.click();

                    setTimeout(function () {
                        canGo = true;
                    }, delay)

                } else {
                    return;
                }
                
            }

        });

        $('#operacao').on('shown.bs.modal', function (event) {
           $('#desc-op').focus();
        });

    </script>
@stop
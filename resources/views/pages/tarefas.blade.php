@extends('adminlte::page')

@section('title', 'Minhas tarefas')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">
        @livewire('tarefa')
    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor\adminlte\dist\css\preloader.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <style>
        .font-grow{
            font-size: 18px;
        }
        .pe-none{
            pointer-events: none;
        }
    </style>
@stop

@section('js')
    <script src="{{asset('js/newfont.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>

        $(document).ready(function(){
                toastr.options = {
                    toastClass: 'font-grow',
                    positionClass: "toast-bottom-right",
                    progressBar: true,
                    timeOut: "1500",
                }
        });

            window.addEventListener('tarefa-criada', event => {
            toastr.success(event.detail.message);
        });
            window.addEventListener('tarefa-concluida', event => {
            toastr.success(event.detail.message);
        });
            window.addEventListener('tarefa-desmarcada', event => {
            toastr.info(event.detail.message);
        });
            window.addEventListener('tarefa-lixeira', event => {
            toastr.success(event.detail.message);
        });
            window.addEventListener('tarefa-excluida', event => {
            toastr.error(event.detail.message);
        });
            window.addEventListener('tarefa-restaurada', event => {
            toastr.info(event.detail.message);
        });
            window.addEventListener('tarefa-editada', event => {
            toastr.success(event.detail.message);
        });
            window.addEventListener('tarefa-movida', event => {
            toastr.success(event.detail.message);
        });
    
    </script>
@stop
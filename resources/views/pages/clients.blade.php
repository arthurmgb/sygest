@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
@stop

@section('content')

    <div class="uk-container">

        @livewire('client')

    </div>

    @livewire('create-client')

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor\adminlte\dist\css\preloader.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/newfont.js') }}"></script>
    <script>
        // Drag table
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
        // DOCUMENTO MASK
        var options = {
            onKeyPress: function(cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('#documento-item').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }

        $('#documento-item').length > 11 ? $('#documento-item').mask('00.000.000/0000-00', options) : $('#documento-item')
            .mask(
                '000.000.000-00#', options);

        // CELULAR MASK
        var behavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(behavior.apply({}, arguments), options);
                }
            };

        $('#celular-item').mask(behavior, options);

        // DOCUMENTO MASK - EDIÇÃO
        var options = {
            onKeyPress: function(cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('#documento-item-e').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }

        $('#documento-item-e').length > 11 ? $('#documento-item-e').mask('00.000.000/0000-00', options) : $('#documento-item-e')
            .mask(
                '000.000.000-00#', options);

        // CELULAR MASK - EDIÇÃO
        var behavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(behavior.apply({}, arguments), options);
                }
            };

        $('#celular-item-e').mask(behavior, options);
    </script>
@stop

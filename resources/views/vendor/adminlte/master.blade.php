<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('vendor/adminlte/dist/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('vendor/adminlte/dist/favicon/favicon-32x32.png') }}">
    <link rel="manifest" href="{{ asset('vendor/adminlte/dist/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('vendor/adminlte/dist/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <?php
        
        $maintence_cache = App\Models\Maintence::find(1);
        
        $css_version = $maintence_cache->css_cache;
        
        ?>

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900" rel="stylesheet">
        {{-- sygest font --}}
        <style>
            @font-face {
                font-family: 'Norwester';
                src: url('{{ asset('vendor/adminlte/dist/norwester.otf') }}');
            }

            .norwester-font {
                font-family: 'Norwester', sans-serif !important;
                font-smooth: never !important;
                text-rendering: optimizeLegibility !important;
            }
        </style>
        {{-- sygest font --}}
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/my.css?ver=') . $css_version }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/tooltip.css?ver=') . $css_version }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Livewire Styles --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if (config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

</head>

<body class="@yield('classes_body') cashiers-scroll" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/clipboard.min.js') }}"></script>
        <script>
            // Add slideDown animation to Bootstrap dropdown when expanding.
            $('.dropdown').on('show.bs.dropdown', function() {
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
            });

            // Add slideUp animation to Bootstrap dropdown when collapsing.
            $('.dropdown').on('hide.bs.dropdown', function() {
                $(this).find('.dropdown-menu').first().stop(true, true).slideUp(100);
            });

            $('#total-op').mask('#.##0,00', {
                reverse: true
            });
            $('#total-op2').mask('####0.00', {
                reverse: true
            });
            $('#valor-contract').mask('####0,00', {
                reverse: true
            });
            $('.qtd-item').mask('00000');
            $('.qtd-item-two').mask('00');
            $('.precos-mask').mask('#.##0,00', {
                reverse: true
            });

            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            });

            $(document).on('click', '.dropdown-menu', function(e) {
                e.stopPropagation();
            });
        </script>
        <script>
            /* ACC OPERATOR */
            window.addEventListener('unlock-acc-operator', event => {
                $('#modalCheckAuth').modal('hide');
            })

            /* ACC OPERATOR */

            /* Operações */

            window.addEventListener('show-modal', event => {
                $('#operacao').modal('show');
            })
            window.addEventListener('close-modal', event => {
                $('#operacao').modal('hide');
            })
            window.addEventListener('close-confirm-modal', event => {
                $('#confirm-operation').modal('hide');
            })
            window.addEventListener('confirmation-modal', event => {
                $('#confirm-operation').modal('show');
            })

            window.addEventListener('show-cancelar-venda', event => {
                $('#cancelar-venda').modal('show');
            })
            window.addEventListener('hide-cancelar-venda', event => {
                $('#cancelar-venda').modal('hide');
            })

            window.addEventListener('show-pdv-auth', event => {
                $('#autenticacao-pdv').modal('show');
            })
            window.addEventListener('hide-pdv-auth', event => {
                $('#autenticacao-pdv').modal('hide');
            })

            /* Operações */

            /* Edit e Delete */

            window.addEventListener('show-edit-modal', event => {
                $('#editarCat').modal('show');
            })
            window.addEventListener('close-edit-modal', event => {
                $('#editarCat').modal('hide');
            })
            window.addEventListener('close-edit-confirmation-modal', event => {
                $('#edit-confirmation').modal('hide');
            })
            window.addEventListener('show-edit-confirmation-modal', event => {
                $('#edit-confirmation').modal('show');
            })
            window.addEventListener('close-delete-cat-confirmation-modal', event => {
                $('#delete-cat-confirmation').modal('hide');
            })
            window.addEventListener('close-delete-all-confirmation-modal', event => {
                $('#delete-all-confirmation').modal('hide');
            })

            /* Edit e Delete */

            /* Create, Edit e Delete ITENS*/

            window.addEventListener('close-process-item-conf', event => {
                $('#process-this-confirmation').modal('hide');
            })

            window.addEventListener('show-item-modal', event => {
                $('#create-item').modal('show');
            })

            window.addEventListener('close-item-modal', event => {
                $('#create-item').modal('hide');
            })

            window.addEventListener('show-item-confirmation-modal', event => {
                $('#confirm-item-creation').modal('show');
            })

            window.addEventListener('close-item-confirmation-modal', event => {
                $('#confirm-item-creation').modal('hide');
            })

            window.addEventListener('close-delete-item-conf', event => {
                $('#delete-this-confirmation').modal('hide');
            })

            window.addEventListener('show-item-edit-modal', event => {
                $('#edit-this').modal('show');
            })

            window.addEventListener('close-item-edit-modal', event => {
                $('#edit-this').modal('hide');
            })

            window.addEventListener('show-item-edit-confirmation-modal', event => {
                $('#edit-this-confirmation').modal('show');
            })

            window.addEventListener('close-item-edit-confirmation-modal', event => {
                $('#edit-this-confirmation').modal('hide');
            })

            /* Create, Edit e Delete ITENS*/


            /* Rendimento */
            window.addEventListener('close-rendimento', event => {
                $('#rendimento').modal('hide');
            })
            /* Rendimento */

            /* Planos */

            /* Fechar */
            window.addEventListener('fechar-modal-contract', event => {
                $('#showContracts').modal('hide');
            })
            /* Fechar */

            window.addEventListener('show-modal-contract', event => {
                $('#new-contract').modal('show');
            })
            window.addEventListener('close-modal-contract', event => {
                $('#new-contract').modal('hide');
            })
            window.addEventListener('close-confirm-modal-contract', event => {
                $('#confirm-operation-contract').modal('hide');
            })
            window.addEventListener('confirmation-modal-contract', event => {
                $('#confirm-operation-contract').modal('show');
            })

            /* Planos */

            /* Mensalidades Admin */

            window.addEventListener('show-pay-confirmation', event => {
                $('#pay-mensalidade-confirmation').modal('show');
            })
            window.addEventListener('close-pay-confirmation', event => {
                $('#pay-mensalidade-confirmation').modal('hide');
            })
            window.addEventListener('show-estorno-confirmation', event => {
                $('#estorno-mensalidade-confirmation').modal('show');
            })
            window.addEventListener('close-estorno-confirmation', event => {
                $('#estorno-mensalidade-confirmation').modal('hide');
            })
            window.addEventListener('show-vencimento-confirmation', event => {
                $('#vencimento-mensalidade-confirmation').modal('show');
            })
            window.addEventListener('close-vencimento-confirmation', event => {
                $('#vencimento-mensalidade-confirmation').modal('hide');
            })
            window.addEventListener('show-cancelamento-contrato-confirmation', event => {
                $('#cancelamento-contrato').modal('show');
            })
            window.addEventListener('close-cancelamento-contrato-confirmation', event => {
                $('#cancelamento-contrato').modal('hide');
            })
            window.addEventListener('show-exclusao-contrato-confirmation', event => {
                $('#exclusao-contrato').modal('show');
            })
            window.addEventListener('close-exclusao-contrato-confirmation', event => {
                $('#exclusao-contrato').modal('hide');
            })

            /* Mensalidades Admin */

            /*Comissões Admin */

            window.addEventListener('show-comissao-confirmation', event => {
                $('#pay-comissao-confirmation').modal('show');
            })
            window.addEventListener('close-comissao-confirmation', event => {
                $('#pay-comissao-confirmation').modal('hide');
            })

            /*Comissões Admin */

            /*Deletar Usuário */

            window.addEventListener('show-delete-user', event => {
                $('#delete-user-confirmation').modal('show');
            })

            /*Deletar Usuário */

            /* Senhas Open */

            window.addEventListener('open-secret-folder', event => {
                $('#folder-secret').modal('show');
            })

            window.addEventListener('close-secret-folder', event => {
                $('#folder-secret').modal('hide');
            })

            /* Senhas Open */

            /* Senhas DELETE */

            window.addEventListener('delete-secret', event => {
                $('#delete-secret').modal('show');
            })

            window.addEventListener('close-delete-secret', event => {
                $('#delete-secret').modal('hide');
            })

            /* Senhas DELETE */

            /* Senhas EDIT */

            window.addEventListener('edit-secret', event => {
                $('#edit-secret').modal('show');
            })

            window.addEventListener('close-edit-secret', event => {
                $('#edit-secret').modal('hide');
            })

            window.addEventListener('confirm-edit-secret', event => {
                $('#confirm-edit-secret').modal('show');
            })

            window.addEventListener('close-confirm-edit-secret', event => {
                $('#confirm-edit-secret').modal('hide');
            })



            /* Senhas EDIT */
        </script>
        <script>
            // Relatorios 

            window.addEventListener('scroll_to_conf', event => {

                document.getElementById('subtotal-result').scrollIntoView();

            })

            // Admin

            window.addEventListener('close-admin-dropdown', event => {

                $('#dpd-ntf').dropdown('hide');

            })

            window.addEventListener('open-adm-edit-operation', event => {

                $('#adm-operacao').modal('show');
                $('#total-op').mask('#.##0,00', {
                    reverse: true
                });

            })

            window.addEventListener('close-adm-edit-operation', event => {

                $('#adm-operacao').modal('hide');

            })

            window.addEventListener('open-adm-edit-retirada', event => {

                $('#adm-retirada').modal('show');
                $('#total-op').mask('#.##0,00', {
                    reverse: true
                });

            })

            window.addEventListener('close-adm-edit-retirada', event => {

                $('#adm-retirada').modal('hide');

            })
        </script>
        <script>
            new ClipboardJS('.result-to-copy');
            new ClipboardJS('.copy-pix', {
                container: document.getElementById('modalHome')
            });
            new ClipboardJS('.copy-invite', {
                container: document.getElementById('como-funciona')
            });
            new ClipboardJS('.copy-pix-150', {
                container: document.getElementById('fp-pix')
            });

            new ClipboardJS('.copy-login', {
                container: document.getElementById('folder-secret')
            });

            new ClipboardJS('.copy-senha', {
                container: document.getElementById('folder-secret')
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#prod-select').select2({
                    dropdownParent: $('#venda')
                });
            });
            $(document).ready(function() {
                $('#pdv-fp-select').select2({
                    dropdownParent: $('#venda')
                });
            });
            $(document).ready(function() {
                $('#group-select').select2({
                    dropdownParent: $('#create-item .modal-body')
                });
            });
            $(document).ready(function() {
                $('#group-select-edit').select2({
                    dropdownParent: $('#edit-this .modal-body')
                });
            });
        </script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Livewire Script --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
    {{-- Custom Scripts --}}
    @yield('adminlte_js')

    <script>
        Livewire.on('refresh-alert', () => {
            alert('Novas informações foram encontradas. A página será atualizada.');
            location.reload();
        })
        Livewire.on('alert', function(message) {
            Swal.fire(
                'Tudo pronto!',
                message,
                'success'
            )
        })
        Livewire.on('alert-error', function(message) {
            Swal.fire(
                'Operação recusada!',
                message,
                'error'
            )
        })
        Livewire.on('error-operator', function(message) {
            Swal.fire(
                'Atenção!',
                message,
                'warning'
            )
        })
        Livewire.on('error-pagamento', function(message) {
            Swal.fire(
                'Pagamento recusado!',
                message,
                'error'
            )
        })
        Livewire.on('alert-locked', function(message) {
            Swal.fire(
                'Acesso negado!',
                message,
                'error'
            )
        })
        Livewire.on('alert-unlocked', function(message) {
            Swal.fire(
                'Acesso liberado!',
                message,
                'success'
            )
        })
        Livewire.on('alert-blocked', function(message) {
            Swal.fire(
                'Tudo pronto!',
                message,
                'success'
            )
        })
        Livewire.on('denied', function(message) {
            Swal.fire(
                'Negado!',
                message,
                'error'
            )
        })
    </script>

</body>

</html>

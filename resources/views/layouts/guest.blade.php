<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $titulo }} · {{ config('app.name') }}</title>

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('vendor/adminlte/dist/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('vendor/adminlte/dist/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('vendor/adminlte/dist/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('vendor/adminlte/dist/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('vendor/adminlte/dist/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900" rel="stylesheet">

    <?php
    
    $maintence_cache = App\Models\Maintence::find(1);
    
    $css_version = $maintence_cache->css_cache;
    
    ?>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') . '?ver=' . $css_version }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css?ver=') . $css_version }}">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/tooltip.css?ver=') . $css_version }}">
    <style>
        /* TOGGLE PASS VISIBILITY */

        .btn-toggle-pass-visib i {
            cursor: pointer;
            color: #725BC2;
        }

        .btn-toggle-pass-visib-2 i {
            cursor: pointer;
            color: #725BC2;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    <script>
        const cashiers_login_form = document.querySelector("#cashiers-login-form");

        const cashiers_btn_acessar = document.querySelector("#cashiers-btn-acessar");

        cashiers_login_form.onsubmit = () => {

            cashiers_btn_acessar.disabled = true;

        }
    </script>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        var options = {
            onKeyPress: function(cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('#documento').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }

        $('#documento').length > 11 ? $('#documento').mask('00.000.000/0000-00', options) : $('#documento').mask(
            '000.000.000-00#', options);
    </script>
    <script>
        var behavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(behavior.apply({}, arguments), options);
                }
            };

        $('#celular').mask(behavior, options);
    </script>
    <script>
        var passToggler = document.querySelector('.btn-toggle-pass-visib');
        var iconToggler = document.querySelector('#toggler-pass');
        var password = document.querySelector('#password');

        var confirm_passToggler = document.querySelector('.btn-toggle-pass-visib-2');
        var confirm_iconToggler = document.querySelector('#toggler-pass-2');
        var confirm_password = document.querySelector('#password_confirmation');

        passToggler.addEventListener('click', () => {

            if (iconToggler.classList.contains('fa-eye')) {
                password.type = 'text';
                iconToggler.classList.remove("fa-eye");
                iconToggler.classList.add("fa-eye-slash");
                passToggler.setAttribute("data-tooltip", "Ocultar");

            } else {
                password.type = 'password';
                iconToggler.classList.remove("fa-eye-slash");
                iconToggler.classList.add("fa-eye");
                passToggler.setAttribute("data-tooltip", "Exibir");
            }

        });

        confirm_passToggler.addEventListener('click', () => {

            if (confirm_iconToggler.classList.contains('fa-eye')) {
                confirm_password.type = 'text';
                confirm_iconToggler.classList.remove("fa-eye");
                confirm_iconToggler.classList.add("fa-eye-slash");
                confirm_passToggler.setAttribute("data-tooltip", "Ocultar");

            } else {
                confirm_password.type = 'password';
                confirm_iconToggler.classList.remove("fa-eye-slash");
                confirm_iconToggler.classList.add("fa-eye");
                confirm_passToggler.setAttribute("data-tooltip", "Exibir");

            }

        });
    </script>
</body>

</html>

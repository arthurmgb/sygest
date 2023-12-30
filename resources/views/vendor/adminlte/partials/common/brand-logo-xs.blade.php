@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
    @php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
    @php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

<a style="background-color: #fff; padding: 6.5px; border-bottom: 1px solid #dee2e6 !important;"
    href="{{ $dashboard_url }}"
    @if ($layoutHelper->isLayoutTopnavEnabled()) class="navbar-brand {{ config('adminlte.classes_brand') }}"
    @else
        class="brand-link main-topic {{ config('adminlte.classes_brand') }} d-flex align-items-center justify-content-start" @endif>

    {{-- Small brand logo --}}
    <img style="margin-right: 10px; width: 32px; height: 35.5px; max-height: 35.5px;"
        src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
        alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
        class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }} mt-0">

    {{-- Brand text --}}
    <span style="font-size: 28px !important; position: relative;"
        class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
        {{-- <img class="natal-logo-hat" src="{{asset('vendor/adminlte/dist/img/santa-hat-32.png')}}"> --}}
        <span class="norwester-font"
            style="letter-spacing: 3px; background: linear-gradient(90deg, #F472B6, #622F91); -webkit-background-clip: text; color: transparent; font-weight: 700;">
            SYGEST
        </span>
    </span>

</a>

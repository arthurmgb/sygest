@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

<a style="background-color: #fff; padding: 10.5px; border-bottom: 1px solid #dee2e6 !important;" href="{{ $dashboard_url }}"
    @if($layoutHelper->isLayoutTopnavEnabled())
        class="navbar-brand {{ config('adminlte.classes_brand') }}"
    @else
        class="brand-link main-topic {{ config('adminlte.classes_brand') }}"
    @endif>

    {{-- Small brand logo --}}
    <img style="margin-top: 0px; width: 32px; height: 32px; max-height: 32px;" src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
         class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }}">
    
    {{-- Brand text --}}
    <span style="font-size: 24px !important;" class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
        <span class="text-uppercase" style="color: #352B73; font-weight: 600; letter-spacing: 1px;">Ca<span style="color: #f472b6;">$</span>hiers</span>
    </span>

</a>

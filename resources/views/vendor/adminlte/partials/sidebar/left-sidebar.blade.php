<aside style="background-color: #fff; box-shadow: 3px 0px 15px -13px rgba(0,0,0,0.3);" class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <a href="{{route('profile.show')}}">
            <div class="user-panel mt-2 pb-3 mb-1 d-flex border-0">
                <div class="image">
                <img class="bg-img" style="width: 45px !important; object-fit: cover;" src="{{Auth::user()->profile_photo_url}}">
                </div>
                <div class="my-auto ml-1">
                <span style="font-size: 15px; font-weight: 500; color: #333333; max-width: 160px;" class="d-block text-truncate">{{Auth::user()->name}}</span>
                </div>
            </div>
        </a>
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>

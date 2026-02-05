<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link mb-3" target="_blank">
            <img src="{{ asset('assets/img/logo/simtaru2.png') }}" alt="" width="200">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @if (Auth::user()->role == 'superadmin')
            <li class="menu-item {!! request()->routeIs('dashboard') ? 'active' : '' !!}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <div data-i18n="Analytics">Dashboard Utama</div>
                </a>
            </li>
        @endif

        @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin-pelanggaran')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pelanggaran</span>
            </li>
            <!-- Dashboard -->
            <li class="menu-item {!! request()->routeIs('pelanggaran.dashboard') ? 'active' : '' !!}">
                <a href="{{ route('pelanggaran.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>   
        @endif

        @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin-pelanggaran')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Layanan</span>
            </li>
            <li class="menu-item {!! request()->routeIs('pelanggaran.index', 'pelanggaran.create', 'pelanggaran.edit', 'pelanggaran.detail') ? 'active' : '' !!}">
                <a href="{{ route('pelanggaran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bell"></i>
                    <div data-i18n="Analytics">Pelanggaran</div>
                </a>
            </li>
        @endif
    </ul>
</aside>

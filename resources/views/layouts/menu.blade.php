<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link mb-3">
            <img src="{{ asset('assets/img/logo/simtaru2.png') }}" alt="" width="200">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {!! request()->routeIs('dashboard') ? 'active' : '' !!}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {!! request()->routeIs('registrasi.*') ? 'active' : '' !!}">
            <a href="{{ route('registrasi.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-edit"></i>
                <div data-i18n="Analytics">Registrasi</div>
            </a>
        </li>

        <li
            class="menu-item {{ request()->routeIs('permohonan.*') || request()->routeIs('skrk.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Permohonan">Permohonan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {!! request()->routeIs('permohonan.*') ? 'active' : '' !!}">
                    <a href="{{ route('permohonan.index') }}" class="menu-link">
                        <div data-i18n="Analytics">Semua Permohonan</div>
                    </a>
                </li>
                <li class="menu-item {!! request()->routeIs('skrk.*') ? 'active' : '' !!}">
                    <a href="{{ route('skrk.index') }}" class="menu-link">
                        <div data-i18n="Text Divider">SKRK</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Text Divider">KKPR Berusaha</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Text Divider">KKPR Non Berusaha</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Text Divider">ITR</div>
                    </a>
                </li>
            </ul>
        </li>



        @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
            <li class="menu-item {!! request()->routeIs('disposisi.*') ? 'active' : '' !!}">
                <a href="{{ route('disposisi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Analytics">Disposisi</div>
                </a>
            </li>

            <li class="menu-item {!! request()->routeIs('layanan.*') ? 'active' : '' !!}">
                <a href="{{ route('layanan.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-folder-open'></i>
                    <div data-i18n="Analytics">Layanan</div>
                </a>
            </li>
        @endif


        @if (Auth::user()->role == 'superadmin')
            <li class="menu-item {!! request()->routeIs('users.*') ? 'active' : '' !!}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Analytics">Users</div>
                </a>
            </li>
        @endif
    </ul>
</aside>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Client dashboard') | Chapu CV</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    @livewireStyles
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
    <script>var defaultThemeMode = 'light'; var themeMode = localStorage.getItem('data-bs-theme') || defaultThemeMode; document.documentElement.setAttribute('data-bs-theme', themeMode);</script>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <aside id="kt_aside" class="aside aside-default aside-hoverable" data-kt-drawer="true"
                data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
                <div class="aside-logo flex-column-auto px-9 pt-9 pb-5" id="kt_aside_logo">
                    <a href="{{ route('dashboard') }}"><img alt="Chapu CV"
                            src="{{ asset('assets/media/logos/logo-default.svg') }}"
                            class="max-h-50px logo-default theme-light-show"><img alt="Chapu CV"
                            src="{{ asset('assets/media/logos/logo-default-dark.svg') }}"
                            class="max-h-50px logo-default theme-dark-show"><img alt="Chapu CV"
                            src="{{ asset('assets/media/logos/logo-minimize.svg') }}"
                            class="max-h-50px logo-minimize"></a>
                </div>
                <div class="aside-menu flex-column-fluid ps-3 pe-1">
                    <div class="menu menu-column menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-active-bg menu-state-primary fw-semibold fs-6 my-5 mt-lg-2"
                        id="kt_aside_menu">
                        <div class="hover-scroll-y mx-4" data-kt-scroll="true" data-kt-scroll-height="auto">
                            <div class="menu-item"><a
                                    class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}"><span class="menu-icon"><i
                                            class="ki-duotone ki-element-11 fs-2"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i></span><span
                                        class="menu-title">Overview</span></a></div>
                            <div class="menu-item pt-5">
                                <div class="menu-content"><span class="fw-bold text-muted text-uppercase fs-7">My
                                        CV</span></div>
                            </div>
                            <div class="menu-item"><a class="menu-link" href="#editor"><span class="menu-icon"><i
                                            class="ki-duotone ki-notepad-edit fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span class="menu-title">CV
                                        editor</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="#sections"><span class="menu-icon"><i
                                            class="ki-duotone ki-book-open fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span class="menu-title">CV
                                        sections</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="#experience"><span class="menu-icon"><i
                                            class="ki-duotone ki-briefcase fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span
                                        class="menu-title">Experience</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="#education"><span class="menu-icon"><i
                                            class="ki-duotone ki-teacher fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span
                                        class="menu-title">Education</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="#skills"><span class="menu-icon"><i
                                            class="ki-duotone ki-star fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span
                                        class="menu-title">Skills</span></a></div>
                            <div class="menu-item pt-5">
                                <div class="menu-content"><span class="fw-bold text-muted text-uppercase fs-7">Share
                                        &amp; insights</span></div>
                            </div>
                            <div class="menu-item"><a class="menu-link" href="#templates"><span class="menu-icon"><i
                                            class="ki-duotone ki-design-1 fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span
                                        class="menu-title">Templates</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="#qr-codes"><span class="menu-icon"><i
                                            class="ki-duotone ki-scan-barcode fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span class="menu-title">QR
                                        codes</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="#analytics"><span class="menu-icon"><i
                                            class="ki-duotone ki-chart-simple fs-2"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span></i></span><span
                                        class="menu-title">Analytics</span></a></div>
                            <div class="menu-item pt-5">
                                <div class="menu-content"><span
                                        class="fw-bold text-muted text-uppercase fs-7">Account</span></div>
                            </div>
                            <div class="menu-item"><a class="menu-link" href="{{ route('profile.show') }}"><span
                                        class="menu-icon"><i class="ki-duotone ki-user fs-2"><span
                                                class="path1"></span><span class="path2"></span></i></span><span
                                        class="menu-title">My profile</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="#settings"><span class="menu-icon"><i
                                            class="ki-duotone ki-setting-2 fs-2"><span class="path1"></span><span
                                                class="path2"></span></i></span><span
                                        class="menu-title">Settings</span></a></div>
                            <div class="menu-item">
                                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"
                                        class="menu-link border-0 bg-transparent w-100 text-start"><span
                                            class="menu-icon"><i class="ki-duotone ki-exit-right fs-2"><span
                                                    class="path1"></span><span class="path2"></span></i></span><span
                                            class="menu-title">Sign out</span></button></form>
                            </div>
                        </div>
                    </div>
                    <div class="aside-footer flex-column-auto px-6 pb-5">
                        <div class="card bg-light-primary">
                            <div class="card-body p-5">
                                <div class="fw-bold text-gray-800 mb-2">Profile strength</div>
                                <div class="progress h-6px mb-3">
                                    <div class="progress-bar bg-primary" style="width: 78%"></div>
                                </div><span class="text-gray-600 fs-8">Add one project to reach 100%.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <header id="kt_header" class="header">
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center d-lg-none">
                                <div class="btn btn-icon btn-active-color-primary ms-n2 me-1" id="kt_aside_toggle"><i
                                        class="ki-duotone ki-abstract-14 fs-1"><span class="path1"></span><span
                                            class="path2"></span></i></div>
                            </div>
                            <div class="btn btn-icon w-auto ps-0 btn-active-color-primary d-none d-lg-inline-flex me-5"
                                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                                data-kt-toggle-name="aside-minimize"><i
                                    class="ki-duotone ki-black-left-line fs-1 rotate-180"><span
                                        class="path1"></span><span class="path2"></span></i></div>
                            <h1 class="d-none d-md-block fs-3 fw-bold text-gray-800 mb-0">
                                {{ $heading ?? 'My CV workspace' }}
                            </h1>
                        </div>
                        <div id="kt_header_search" class="header-search d-flex align-items-center flex-grow-1 mx-5 d-none d-md-flex w-lg-300px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start"><form data-kt-search-element="form" class="d-block w-100 position-relative" role="search" autocomplete="off"><i class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"><span class="path1"></span><span class="path2"></span></i><input type="search" class="search-input form-control form-control-solid ps-13" name="search" placeholder="Search your CV workspace" data-kt-search-element="input" aria-label="Search your CV workspace"></form></div>
                        <div class="d-flex align-items-center gap-4"><a href="{{ url('/') }}" class="btn btn-light-primary fw-bold d-none d-sm-inline">View public profile</a><button type="button" class="btn btn-icon btn-active-light-primary position-relative" aria-label="Notifications"><i class="ki-duotone ki-notification-on fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i><span class="bullet bullet-dot bg-danger position-absolute top-0 end-0"></span></button><div id="kt_header_user_menu_toggle" class="d-flex align-items-center ms-2 ms-lg-3"><div class="cursor-pointer symbol symbol-35px symbol-lg-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->profile_photo_url }}"></div><div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true"><div class="menu-item px-3"><div class="menu-content d-flex align-items-center px-3"><div class="symbol symbol-50px me-5"><img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->profile_photo_url }}"></div><div class="d-flex flex-column"><span class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }} <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Client</span></span><span class="fw-semibold text-muted fs-7">{{ Auth::user()->email }}</span></div></div></div><div class="separator my-2"></div><div class="menu-item px-5"><a href="{{ route('profile.show') }}" class="menu-link px-5">My profile</a></div><div class="menu-item px-5"><a href="{{ url('/') }}" class="menu-link px-5">View public profile</a></div><div class="separator my-2"></div><div class="menu-item px-5"><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="menu-link px-5 border-0 bg-transparent w-100 text-start">Sign out</button></form></div></div></div></div>
                    </div>
                </header>
                <main class="content d-flex flex-column flex-column-fluid">
                    <div class="container-fluid">@yield('content')</div>
                </main>
                <footer class="footer py-4 d-flex flex-lg-column">
                    <div
                        class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <span class="text-gray-500 fw-semibold">Chapu CV</span><span class="text-gray-400">Professional
                            profiles made simple.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    @livewireScripts
</body>

</html>
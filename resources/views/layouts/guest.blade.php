<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Guest dashboard') | Chapu CV</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled bg-light">
    <div class="d-flex flex-column flex-root min-vh-100">
        <header id="kt_header" class="header bg-white border-bottom">
            <div class="container-fluid d-flex align-items-center justify-content-between py-3">
                <a href="{{ route('dashboard') }}"
                    class="d-flex align-items-center text-dark text-decoration-none"><span
                        class="symbol symbol-40px me-3"><span
                            class="symbol-label bg-primary text-white fw-bold fs-4">C</span></span><span
                        class="fs-2 fw-bold">Chapu<span class="text-primary">.</span></span></a>
                <div id="kt_header_search" class="header-search d-flex align-items-center flex-grow-1 mx-5 d-none d-md-flex w-lg-300px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start"><form data-kt-search-element="form" class="d-block w-100 position-relative" role="search" autocomplete="off"><i class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"><span class="path1"></span><span class="path2"></span></i><input type="search" class="search-input form-control form-control-solid ps-13" name="search" placeholder="Search public CV profiles" data-kt-search-element="input" aria-label="Search public CV profiles"></form></div>
                <div class="d-flex align-items-center gap-4"><a href="{{ url('/') }}" class="btn btn-light-primary fw-bold d-none d-sm-inline">Explore profiles</a><button type="button" class="btn btn-icon btn-active-light-primary position-relative" aria-label="Notifications"><i class="ki-duotone ki-notification-on fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></button><div id="kt_header_user_menu_toggle" class="d-flex align-items-center ms-2 ms-lg-3"><div class="cursor-pointer symbol symbol-35px symbol-lg-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->profile_photo_url }}"></div><div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true"><div class="menu-item px-3"><div class="menu-content d-flex align-items-center px-3"><div class="symbol symbol-50px me-5"><img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->profile_photo_url }}"></div><div class="d-flex flex-column"><span class="fw-bold fs-5">{{ Auth::user()->name }}</span><span class="fw-semibold text-muted fs-7">{{ Auth::user()->email }}</span></div></div></div><div class="separator my-2"></div><div class="menu-item px-5"><a href="{{ route('profile.show') }}" class="menu-link px-5">My profile</a></div><div class="separator my-2"></div><div class="menu-item px-5"><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="menu-link px-5 border-0 bg-transparent w-100 text-start">Sign out</button></form></div></div></div></div>
            </div>
        </header>
        <main class="container-xxl py-10 py-lg-15 flex-grow-1">@yield('content')</main>
        <footer class="bg-white border-top">
            <div class="container-xxl py-6 text-gray-500">Chapu CV · Professional profiles made simple.</div>
        </footer>
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>

</html>
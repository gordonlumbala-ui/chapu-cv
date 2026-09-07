<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in | Chapu CV</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
</head>

<body class="auth-bg">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid min-vh-100">
            <div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px position-xl-relative">
                <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                    <div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
                        <a href="{{ url('/') }}" class="py-2 py-lg-20"><img alt="Chapu CV"
                                src="{{ asset('assets/media/logos/logo-ellipse.svg') }}" class="h-60px h-lg-70px"></a>
                        <h1 class="d-none d-lg-block fw-bold text-white fs-2qx pb-5 pb-md-10">Your professional story,
                            ready.</h1>
                        <p class="d-none d-lg-block fw-semibold fs-2 text-white">Build your CV, publish your
                            profile,<br>and share it with one simple scan.</p>
                    </div>
                    <div class="d-none d-lg-block d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                        style="background-image: url({{ asset('assets/media/illustrations/sigma-1/17.png') }})"></div>
                </div>
            </div>
            <div class="d-flex flex-column flex-lg-row-fluid py-10 bg-white">
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                        <form class="form w-100" method="POST" action="{{ route('login') }}">
                            @csrf
                            <x-validation-errors class="mb-5 text-danger" />
                            @session('status')
                            <div class="alert alert-success mb-5">{{ $value }}</div>@endsession
                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Sign in to Chapu CV</h1>
                                <div class="text-gray-400 fw-semibold fs-4">New here? @if (Route::has('register'))<a
                                    href="{{ route('register') }}" class="link-primary fw-bold">Create an
                                account</a>@endif</div>
                            </div>
                            <div class="fv-row mb-8"><label for="email"
                                    class="form-label fs-6 fw-bold text-dark">Email</label><input id="email"
                                    class="form-control form-control-lg form-control-solid" type="email" name="email"
                                    value="{{ old('email') }}" autocomplete="username" required autofocus></div>
                            <div class="fv-row mb-8">
                                <div class="d-flex flex-stack mb-2"><label for="password"
                                        class="form-label fw-bold text-dark fs-6 mb-0">Password</label>@if (Route::has('password.request'))<a
                                            href="{{ route('password.request') }}" class="link-primary fs-6 fw-bold">Forgot
                                        password?</a>@endif</div><input id="password"
                                    class="form-control form-control-lg form-control-solid" type="password"
                                    name="password" autocomplete="current-password" required>
                            </div>
                            <label class="form-check form-check-custom form-check-solid mb-8"><input
                                    class="form-check-input" type="checkbox" name="remember"><span
                                    class="form-check-label fw-semibold text-gray-600">Remember me</span></label>
                            <button type="submit" class="btn btn-lg btn-primary w-100"><span
                                    class="indicator-label">Sign in</span></button>
                        </form>
                    </div>
                </div>
                <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0"><a href="{{ url('/') }}"
                        class="text-muted text-hover-primary px-2">Back to Chapu CV</a></div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>

</html>
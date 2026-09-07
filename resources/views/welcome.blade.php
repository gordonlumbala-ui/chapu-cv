<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chapu CV | Professional profiles made simple</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    <style>
        .chapu-hero {
            background: linear-gradient(135deg, #f8faff 0%, #eef5ff 58%, #fff8e6 100%);
        }

        .chapu-grid {
            background-image: linear-gradient(rgba(54, 153, 255, .08) 1px, transparent 1px), linear-gradient(90deg, rgba(54, 153, 255, .08) 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>
</head>

<body class="bg-body">
    <header class="app-header bg-white border-bottom">
        <div class="container-xxl d-flex align-items-center justify-content-between py-5">
            <a href="{{ url('/') }}"
                class="d-flex align-items-center text-dark text-hover-primary text-decoration-none">
                <span class="symbol symbol-40px me-3"><span
                        class="symbol-label bg-primary text-white fw-bold fs-4">C</span></span>
                <span class="fs-2 fw-bold">Chapu<span class="text-primary">.</span></span>
            </a>
            <nav class="d-flex align-items-center gap-4">
                <a href="#features" class="text-gray-600 text-hover-primary fw-semibold d-none d-md-inline">Features</a>
                <a href="#how-it-works" class="text-gray-600 text-hover-primary fw-semibold d-none d-md-inline">How it
                    works</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-light-primary fw-bold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 text-hover-primary fw-semibold">Sign in</a>
                    @if (Route::has('register'))<a href="{{ route('register') }}" class="btn btn-primary fw-bold">Create
                    your CV</a>@endif
                @endauth
            </nav>
        </div>
    </header>
    <main>
        <section class="chapu-hero chapu-grid position-relative overflow-hidden">
            <div class="container-xxl py-20 py-lg-25">
                <div class="row align-items-center gy-12">
                    <div class="col-lg-6">
                        <span class="badge badge-light-primary fs-7 fw-bold px-4 py-3 mb-6">YOUR PROFESSIONAL STORY,
                            READY TO SHARE</span>
                        <h1 class="display-3 fw-bold text-gray-900 lh-1 mb-6">Build a CV that opens the right doors.
                        </h1>
                        <p class="fs-3 text-gray-600 lh-lg mb-8">Create a polished CV, publish your professional
                            profile, and share it anywhere with one memorable QR code.</p>
                        <div class="d-flex flex-wrap gap-4">
                            @if (Route::has('register'))<a href="{{ route('register') }}"
                                class="btn btn-primary btn-lg fw-bold px-8">Start building free <i
                                    class="ki-duotone ki-arrow-right fs-2 ms-2"><span class="path1"></span><span
                            class="path2"></span></i></a>@endif
                            <a href="#how-it-works" class="btn btn-light btn-lg fw-bold px-8">See how it works</a>
                        </div>
                        <div class="d-flex align-items-center mt-10 text-gray-500 fw-semibold"><span
                                class="symbol-group symbol-hover me-4"><span
                                    class="symbol symbol-35px symbol-circle"><span
                                        class="symbol-label bg-light-primary text-primary fw-bold">A</span></span><span
                                    class="symbol symbol-35px symbol-circle"><span
                                        class="symbol-label bg-light-warning text-warning fw-bold">M</span></span><span
                                    class="symbol symbol-35px symbol-circle"><span
                                        class="symbol-label bg-light-success text-success fw-bold">K</span></span></span>Trusted
                            by professionals building their next chapter.</div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto mw-600px">
                            <div class="card shadow-lg border-0 rotate-2 bg-primary overflow-hidden">
                                <div class="card-body p-5 p-lg-8">
                                    <div class="d-flex align-items-center justify-content-between mb-8">
                                        <div>
                                            <div class="h-10px w-150px bg-dark rounded mb-3"></div>
                                            <div class="h-8px w-100px bg-white opacity-50 rounded"></div>
                                        </div><span class="symbol symbol-60px"><span
                                                class="symbol-label bg-warning text-dark fw-bold fs-2">C</span></span>
                                    </div>
                                    <div class="bg-white rounded p-6">
                                        <div class="h-10px w-200px bg-primary rounded mb-3"></div>
                                        <div class="h-8px w-300px bg-light rounded mb-8"></div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="h-8px bg-light rounded mb-3"></div>
                                                <div class="h-8px bg-light rounded mb-3"></div>
                                                <div class="h-8px bg-light rounded mb-8"></div>
                                                <div class="h-10px w-100px bg-warning rounded mb-4"></div>
                                                <div class="h-8px bg-light rounded mb-3"></div>
                                                <div class="h-8px bg-light rounded"></div>
                                            </div>
                                            <div class="col-4">
                                                <div
                                                    class="symbol symbol-100px bg-white border-4 border-dark rounded p-4 mx-auto">
                                                    <div class="w-100 h-100 bg-dark opacity-75"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator my-7"></div>
                                        <div class="d-flex justify-content-between text-gray-500 fs-8 fw-bold">
                                            <span>chapu.me/your-name</span><span>Available online</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="card shadow-sm border-0 position-absolute bottom-0 start-0 translate-middle-y ms-n5">
                                <div class="card-body d-flex align-items-center p-5"><span
                                        class="symbol symbol-45px me-4"><span
                                            class="symbol-label bg-light-success text-success fs-2">↗</span></span>
                                    <div>
                                        <div class="fs-2 fw-bold text-gray-900">1,284</div>
                                        <div class="text-gray-500 fs-8 fw-bold">PROFILE VIEWS</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="how-it-works" class="bg-white border-bottom">
            <div class="container-xxl py-15">
                <div class="row g-8">
                    <div class="col-md-4"><span class="badge badge-light-primary fs-3 fw-bold mb-5">01</span>
                        <h3 class="fs-2 fw-bold text-gray-900">Shape your story</h3>
                        <p class="text-gray-600 fs-5">Add your experience, skills, projects, and the details that make
                            your work yours.</p>
                    </div>
                    <div class="col-md-4"><span class="badge badge-light-warning fs-3 fw-bold mb-5">02</span>
                        <h3 class="fs-2 fw-bold text-gray-900">Choose your look</h3>
                        <p class="text-gray-600 fs-5">Start with a thoughtful CV template and make it feel like you in a
                            few minutes.</p>
                    </div>
                    <div class="col-md-4"><span class="badge badge-light-success fs-3 fw-bold mb-5">03</span>
                        <h3 class="fs-2 fw-bold text-gray-900">Share everywhere</h3>
                        <p class="text-gray-600 fs-5">Use your public profile or QR code on your card, email signature,
                            and applications.</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="features" class="container-xxl py-20">
            <div class="text-center mb-12"><span class="text-primary fw-bold text-uppercase fs-7">Everything in one
                    place</span>
                <h2 class="fs-1 fw-bold text-gray-900 mt-3">A home for the work you want people to remember.</h2>
            </div>
            <div class="row g-6">
                <div class="col-md-4">
                    <div class="card card-flush h-100 bg-light-primary">
                        <div class="card-body p-8"><i class="ki-duotone ki-scan-barcode fs-3x text-primary"><span
                                    class="path1"></span><span class="path2"></span></i>
                            <h3 class="fs-2 fw-bold mt-8">QR-ready sharing</h3>
                            <p class="text-gray-600 fs-5">Turn your professional profile into a simple scan that works
                                everywhere.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-flush h-100 bg-light-warning">
                        <div class="card-body p-8"><i class="ki-duotone ki-notepad-edit fs-3x text-warning"><span
                                    class="path1"></span><span class="path2"></span></i>
                            <h3 class="fs-2 fw-bold mt-8">Easy to keep current</h3>
                            <p class="text-gray-600 fs-5">Your latest role, project, or certification is always one edit
                                away.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-flush h-100 bg-light-success">
                        <div class="card-body p-8"><i class="ki-duotone ki-chart-simple fs-3x text-success"><span
                                    class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            <h3 class="fs-2 fw-bold mt-8">Know what works</h3>
                            <p class="text-gray-600 fs-5">See profile views and QR scans so you know where your story
                                travels.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-white border-top">
        <div class="container-xxl py-8 d-flex justify-content-between text-gray-500"><strong
                class="text-gray-900 fs-3">Chapu<span class="text-primary">.</span></strong><span>Professional profiles
                made simple.</span></div>
    </footer>
</body>

</html>
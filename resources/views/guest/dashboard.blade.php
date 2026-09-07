@extends('layouts.guest')

@section('title', 'Guest dashboard')

@section('content')
    <div class="mw-700px mx-auto text-center"><span class="symbol symbol-75px mb-8"><span
                class="symbol-label bg-light-primary text-primary fs-1">i</span></span>
        <h1 class="fs-1 fw-bold text-gray-900 mb-4">Welcome to Chapu CV</h1>
        <p class="text-gray-500 fs-3 lh-lg mb-10">You are signed in as a guest. Explore public CV profiles or create a
            client account to build and share your own professional profile.</p>
        <div class="d-flex justify-content-center flex-wrap gap-4"><a href="{{ url('/') }}"
                class="btn btn-primary btn-lg fw-bold">Explore Chapu CV</a>@if (Route::has('register'))<a
                    href="{{ route('register') }}" class="btn btn-light-primary btn-lg fw-bold">Create a client
                account</a>@endif</div>
    </div>
    <div class="row g-6 mt-15">
        <div class="col-md-4">
            <div class="card card-flush h-100">
                <div class="card-body p-7 text-center"><i class="ki-duotone ki-profile-user fs-3x text-primary"><span
                            class="path1"></span><span class="path2"></span></i>
                    <h3 class="fs-2 fw-bold mt-6">Discover profiles</h3>
                    <p class="text-gray-500 fs-5">View professional stories shared publicly.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-flush h-100">
                <div class="card-body p-7 text-center"><i class="ki-duotone ki-scan-barcode fs-3x text-warning"><span
                            class="path1"></span><span class="path2"></span></i>
                    <h3 class="fs-2 fw-bold mt-6">Scan a QR code</h3>
                    <p class="text-gray-500 fs-5">Open a Chapu CV profile from any supported QR code.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-flush h-100">
                <div class="card-body p-7 text-center"><i class="ki-duotone ki-rocket fs-3x text-success"><span
                            class="path1"></span><span class="path2"></span></i>
                    <h3 class="fs-2 fw-bold mt-6">Build your own</h3>
                    <p class="text-gray-500 fs-5">Upgrade to a client account whenever you are ready.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.client')

@section('title', 'My dashboard')

@section('content')
    <div class="d-flex flex-wrap flex-stack mb-10">
        <div>
            <span class="badge badge-light-primary fw-bold mb-3">CLIENT WORKSPACE</span>
            <h1 class="fs-1 fw-bold text-gray-900 mb-2">Welcome, {{ Auth::user()->name }}</h1>
            <p class="text-gray-500 fs-4 mb-0">Build, update, and share your professional profile.</p>
        </div>
        <a href="#editor" class="btn btn-primary btn-lg fw-bold"><i class="ki-duotone ki-notepad-edit fs-2"><span
                    class="path1"></span><span class="path2"></span></i> Edit my CV</a>
    </div>
    <div class="row g-6 mb-8">
        <div class="col-md-6 col-xl-4">
            <div class="card card-flush h-100">
                <div class="card-body p-8"><span class="symbol symbol-50px mb-6"><span
                            class="symbol-label bg-light-primary text-primary fs-2">✎</span></span>
                    <h2 class="fs-2 fw-bold text-gray-900">My CV</h2>
                    <p class="text-gray-500 fs-5">Keep your experience, education, skills, and projects current.</p><a
                        href="#editor" class="btn btn-light-primary fw-bold mt-4">Open editor &rarr;</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card card-flush h-100">
                <div class="card-body p-8"><span class="symbol symbol-50px mb-6"><span
                            class="symbol-label bg-light-warning text-warning fs-2">⌗</span></span>
                    <h2 class="fs-2 fw-bold text-gray-900">Share with QR</h2>
                    <p class="text-gray-500 fs-5">Create a QR code for your business card, email, or applications.</p><a
                        href="#qr-codes" class="btn btn-light-warning fw-bold mt-4">Manage QR codes &rarr;</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card card-flush h-100">
                <div class="card-body p-8"><span class="symbol symbol-50px mb-6"><span
                            class="symbol-label bg-light-success text-success fs-2">↗</span></span>
                    <h2 class="fs-2 fw-bold text-gray-900">Profile insights</h2>
                    <p class="text-gray-500 fs-5">See how often people view and discover your professional profile.</p><a
                        href="#analytics" class="btn btn-light-success fw-bold mt-4">View analytics &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-flush">
        <div class="card-body p-8 d-flex flex-wrap align-items-center justify-content-between gap-5">
            <div>
                <h3 class="fs-2 fw-bold text-gray-900 mb-2">Your public profile is ready to share</h3>
                <p class="text-gray-500 fs-5 mb-0">Send your profile link to recruiters and collaborators.</p>
            </div><a href="{{ url('/') }}" class="btn btn-primary fw-bold">View public profile <i
                    class="ki-duotone ki-arrow-up-right fs-2"><span class="path1"></span><span class="path2"></span></i></a>
        </div>
    </div>
@endsection
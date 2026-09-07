@extends('layouts.admin'){{ asse }}

@section('content')
    <div class="d-flex flex-wrap flex-stack mb-8">
        <div>
            <span class="badge badge-light-primary fw-bold mb-3">ADMINISTRATION</span>
            <h2 class="fs-2 fw-bold text-gray-900 mb-2">Platform overview</h2>
            <span class="text-gray-500 fw-semibold">Manage users, CV content, sharing, and platform health.</span>
        </div>
        <a href="#users" class="btn btn-primary fw-bold">Manage users</a>
    </div>
    <div class="row g-6">
        <div class="col-md-6 col-xl-3"><a href="#users" class="card card-flush h-100 text-hover-primary">
                <div class="card-body p-6"><span class="symbol symbol-45px mb-5"><span
                            class="symbol-label bg-light-primary text-primary fs-2">◎</span></span>
                    <div class="fs-2 fw-bold text-gray-900">{{ \App\Models\User::count() }}</div>
                    <div class="text-gray-500 fw-semibold mt-1">Registered users</div><span
                        class="text-primary fw-bold fs-7 mt-4 d-inline-block">Manage users &rarr;</span>
                </div>
            </a></div>
        <div class="col-md-6 col-xl-3"><a href="#users" class="card card-flush h-100 text-hover-primary">
                <div class="card-body p-6"><span class="symbol symbol-45px mb-5"><span
                            class="symbol-label bg-light-success text-success fs-2">✓</span></span>
                    <div class="fs-2 fw-bold text-gray-900">{{ \App\Models\User::where('is_active', true)->count() }}</div>
                    <div class="text-gray-500 fw-semibold mt-1">Active accounts</div><span
                        class="text-primary fw-bold fs-7 mt-4 d-inline-block">Review status &rarr;</span>
                </div>
            </a></div>
        <div class="col-md-6 col-xl-3"><a href="#roles" class="card card-flush h-100 text-hover-primary">
                <div class="card-body p-6"><span class="symbol symbol-45px mb-5"><span
                            class="symbol-label bg-light-warning text-warning fs-2">★</span></span>
                    <div class="fs-2 fw-bold text-gray-900">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
                    <div class="text-gray-500 fw-semibold mt-1">Administrators</div><span
                        class="text-primary fw-bold fs-7 mt-4 d-inline-block">Review access &rarr;</span>
                </div>
            </a></div>
        <div class="col-md-6 col-xl-3"><a href="#reports" class="card card-flush h-100 text-hover-primary">
                <div class="card-body p-6"><span class="symbol symbol-45px mb-5"><span
                            class="symbol-label bg-light-info text-info fs-2">↗</span></span>
                    <div class="fs-2 fw-bold text-gray-900">Platform</div>
                    <div class="text-gray-500 fw-semibold mt-1">Reports and audit log</div><span
                        class="text-primary fw-bold fs-7 mt-4 d-inline-block">Open reports &rarr;</span>
                </div>
            </a></div>
    </div>
@endsection
<x-admin-layout>
    <div class="d-flex flex-wrap flex-stack mb-8">
        <div>
            <h2 class="fs-2 fw-bold text-gray-900 mb-2">Good morning, {{ Auth::user()->name }}</h2><span
                class="text-gray-500 fw-semibold">Here is what is happening with your professional profile.</span>
        </div><a href="#cv-editor" class="btn btn-primary fw-bold"><i class="ki-duotone ki-notepad-edit fs-2"><span
                    class="path1"></span><span class="path2"></span></i> Edit CV</a>
    </div>
    <div class="row g-6 mb-8">
        <div class="col-md-6 col-xl-3">
            <div class="card card-flush h-100">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center justify-content-between"><span
                            class="text-gray-500 fw-semibold">Profile views</span><span
                            class="badge badge-light-success">+18.4%</span></div>
                    <div class="fs-1 fw-bold text-gray-900 mt-4">1,284</div><span class="text-gray-400 fs-7">Compared to
                        last 7 days</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-flush h-100">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center justify-content-between"><span
                            class="text-gray-500 fw-semibold">QR scans</span><span
                            class="badge badge-light-warning">This week</span></div>
                    <div class="fs-1 fw-bold text-gray-900 mt-4">42</div><span class="text-gray-400 fs-7">18 from your
                        business card</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-flush h-100">
                <div class="card-body p-6">
                    <div class="d-flex align-items-center justify-content-between"><span
                            class="text-gray-500 fw-semibold">CV completeness</span><span
                            class="text-primary fw-bold">78%</span></div>
                    <div class="progress h-7px mt-6 mb-3">
                        <div class="progress-bar bg-primary" style="width: 78%"></div>
                    </div><span class="text-gray-400 fs-7">Add one project to improve it</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-flush h-100 bg-primary">
                <div class="card-body p-6"><span class="text-white opacity-75 fw-semibold">Public profile</span>
                    <div class="text-white fs-3 fw-bold mt-4">chapu.me/{{ Str::slug(Auth::user()->name) }}</div><a
                        href="{{ url('/') }}"
                        class="text-white text-hover-warning fw-bold fs-7 mt-4 d-inline-block">View profile <i
                            class="ki-duotone ki-arrow-up-right fs-4"><span class="path1"></span><span
                                class="path2"></span></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-6">
        <div class="col-xl-8">
            <div class="card card-flush h-100">
                <div class="card-header pt-7">
                    <h3 class="card-title align-items-start flex-column"><span
                            class="card-label fw-bold text-gray-900">Recent activity</span><span
                            class="text-gray-500 mt-1 fw-semibold fs-7">Your latest profile events</span></h3><a
                        href="#analytics" class="btn btn-sm btn-light-primary fw-bold">View analytics</a>
                </div>
                <div class="card-body pt-4">
                    <div class="d-flex align-items-center border-bottom border-gray-200 py-5"><span
                            class="symbol symbol-40px me-4"><span
                                class="symbol-label bg-light-warning text-warning fs-2">⌗</span></span>
                        <div class="flex-grow-1"><span class="text-gray-900 fw-bold d-block">QR code scanned</span><span
                                class="text-gray-500 fs-7">Business card · 24 minutes ago</span></div><span
                            class="text-gray-400 fs-7">Nairobi, KE</span>
                    </div>
                    <div class="d-flex align-items-center border-bottom border-gray-200 py-5"><span
                            class="symbol symbol-40px me-4"><span
                                class="symbol-label bg-light-success text-success fs-2">↗</span></span>
                        <div class="flex-grow-1"><span class="text-gray-900 fw-bold d-block">Profile viewed</span><span
                                class="text-gray-500 fs-7">Recruiter link · 2 hours ago</span></div><span
                            class="text-gray-400 fs-7">Remote</span>
                    </div>
                    <div class="d-flex align-items-center py-5"><span class="symbol symbol-40px me-4"><span
                                class="symbol-label bg-light-primary text-primary fs-2">✎</span></span>
                        <div class="flex-grow-1"><span class="text-gray-900 fw-bold d-block">CV updated</span><span
                                class="text-gray-500 fs-7">Added a new project · Yesterday</span></div><span
                            class="badge badge-light">Draft</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card card-flush h-100">
                <div class="card-header pt-7">
                    <h3 class="card-title fw-bold text-gray-900">Quick actions</h3>
                </div>
                <div class="card-body pt-2"><a href="#cv-editor"
                        class="d-flex align-items-center border-bottom border-gray-200 py-5 text-hover-primary"><span
                            class="symbol symbol-40px me-4"><span
                                class="symbol-label bg-light-primary text-primary">✎</span></span><span
                            class="fw-bold text-gray-800">Edit CV</span><i
                            class="ki-duotone ki-arrow-right ms-auto fs-2"><span class="path1"></span><span
                                class="path2"></span></i></a><a href="#qr-codes"
                        class="d-flex align-items-center border-bottom border-gray-200 py-5 text-hover-primary"><span
                            class="symbol symbol-40px me-4"><span
                                class="symbol-label bg-light-warning text-warning">⌗</span></span><span
                            class="fw-bold text-gray-800">Create QR code</span><i
                            class="ki-duotone ki-arrow-right ms-auto fs-2"><span class="path1"></span><span
                                class="path2"></span></i></a><a href="#templates"
                        class="d-flex align-items-center py-5 text-hover-primary"><span
                            class="symbol symbol-40px me-4"><span
                                class="symbol-label bg-light-success text-success">▦</span></span><span
                            class="fw-bold text-gray-800">Browse templates</span><i
                            class="ki-duotone ki-arrow-right ms-auto fs-2"><span class="path1"></span><span
                                class="path2"></span></i></a></div>
            </div>
        </div>
    </div>
    @if (Auth::user()->role === 'admin')
        <div class="separator separator-dashed my-10"></div>
        <div class="d-flex flex-wrap flex-stack mb-6">
            <div>
                <h3 class="fs-2 fw-bold text-gray-900 mb-2">Administration</h3>
                <span class="text-gray-500 fw-semibold">Keep the Chapu CV platform healthy and secure.</span>
            </div>
            <span class="badge badge-light-primary fs-7 fw-bold">Admin access</span>
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
                        <div class="fs-2 fw-bold text-gray-900">{{ \App\Models\User::where('is_active', true)->count() }}
                        </div>
                        <div class="text-gray-500 fw-semibold mt-1">Active accounts</div><span
                            class="text-primary fw-bold fs-7 mt-4 d-inline-block">Review status &rarr;</span>
                    </div>
                </a></div>
            <div class="col-md-6 col-xl-3"><a href="#roles" class="card card-flush h-100 text-hover-primary">
                    <div class="card-body p-6"><span class="symbol symbol-45px mb-5"><span
                                class="symbol-label bg-light-warning text-warning fs-2">★</span></span>
                        <div class="fs-2 fw-bold text-gray-900">{{ \App\Models\User::where('role', 'admin')->count() }}
                        </div>
                        <div class="text-gray-500 fw-semibold mt-1">Administrators</div><span
                            class="text-primary fw-bold fs-7 mt-4 d-inline-block">Review access &rarr;</span>
                    </div>
                </a></div>
            <div class="col-md-6 col-xl-3"><a href="#reports" class="card card-flush h-100 text-hover-primary">
                    <div class="card-body p-6"><span class="symbol symbol-45px mb-5"><span
                                class="symbol-label bg-light-info text-info fs-2">↗</span></span>
                        <div class="fs-2 fw-bold text-gray-900">Platform</div>
                        <div class="text-gray-500 fw-semibold mt-1">Reports &amp; audit log</div><span
                            class="text-primary fw-bold fs-7 mt-4 d-inline-block">Open reports &rarr;</span>
                    </div>
                </a></div>
        </div>
    @endif
</x-admin-layout>
@php
    $profileLayout = match (strtolower((string) Auth::user()->role)) {
        'admin' => 'layouts.admin',
        'client' => 'layouts.client',
        default => 'layouts.guest',
    };
@endphp

@extends($profileLayout)

@section('title', 'My profile')

@section('content')
    <div class="d-flex flex-wrap flex-stack mb-8">
        <div>
            <span class="badge badge-light-primary fw-bold mb-3">ACCOUNT</span>
            <h1 class="fs-2 fw-bold text-gray-900 mb-2">My profile</h1>
            <p class="text-gray-500 fw-semibold mb-0">Manage your Chapu CV identity, security, and account preferences.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-light-primary fw-bold">Back to dashboard</a>
    </div>

    <div class="row g-6 mb-8">
        <div class="col-xl-4">
            <div class="card card-flush h-100">
                <div class="card-body p-8">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-75px symbol-circle me-5">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                        </div>
                        <div>
                            <h2 class="fs-2 fw-bold text-gray-900 mb-1">{{ Auth::user()->name }}</h2>
                            <span
                                class="badge badge-light-{{ Auth::user()->role === 'admin' ? 'primary' : 'success' }} text-uppercase">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                    <div class="separator mb-6"></div>
                    <div class="d-flex align-items-center mb-5"><i class="ki-duotone ki-sms fs-2 text-primary me-4"><span
                                class="path1"></span><span class="path2"></span></i><span
                            class="text-gray-600 fw-semibold">{{ Auth::user()->email }}</span></div>
                    <div class="d-flex align-items-center"><i class="ki-duotone ki-verify fs-2 text-success me-4"><span
                                class="path1"></span><span class="path2"></span></i><span
                            class="text-gray-600 fw-semibold">{{ Auth::user()->hasVerifiedEmail() ? 'Email verified' : 'Email verification pending' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card card-flush h-100">
                <div class="card-header pt-7">
                    <h3 class="card-title flex-column align-items-start"><span
                            class="card-label fw-bold text-gray-900">Profile information</span><span
                            class="text-gray-500 mt-1 fw-semibold fs-7">Update the identity shown across your Chapu CV
                            account.</span></h3>
                </div>
                <div class="card-body pt-4">
                    @if (session('status'))
                        <div class="alert alert-success d-flex align-items-center mb-6">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger mb-6">
                            <ul class="mb-0">@foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-6">
                            <div class="col-12"><label for="photo" class="form-label fw-bold text-gray-700">Profile
                                    photo</label><input id="photo" name="photo" type="file"
                                    accept="image/jpeg,image/png,image/webp" class="form-control form-control-solid">
                                <div class="form-text">JPG, PNG, or WEBP up to 2 MB.</div>
                            </div>
                            <div class="col-md-6"><label for="name" class="form-label fw-bold text-gray-700">Full
                                    name</label><input id="name" name="name" value="{{ old('name', $user->name) }}"
                                    type="text" class="form-control form-control-solid" required autocomplete="name"></div>
                            <div class="col-md-6"><label for="email" class="form-label fw-bold text-gray-700">Email
                                    address</label><input id="email" name="email" value="{{ old('email', $user->email) }}"
                                    type="email" class="form-control form-control-solid" required autocomplete="email">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-7"><button type="submit"
                                class="btn btn-primary fw-bold">Save profile</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-6">
        <div class="col-xl-6">
            <div class="card card-flush h-100">
                <div class="card-header pt-7">
                    <h3 class="card-title flex-column align-items-start"><span
                            class="card-label fw-bold text-gray-900">Password</span><span
                            class="text-gray-500 mt-1 fw-semibold fs-7">Keep your account secure with a strong
                            password.</span></h3>
                </div>
                <div class="card-body pt-4">
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    @livewire('profile.update-password-form') @endif</div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card card-flush h-100">
                <div class="card-header pt-7">
                    <h3 class="card-title flex-column align-items-start"><span
                            class="card-label fw-bold text-gray-900">Two-factor authentication</span><span
                            class="text-gray-500 mt-1 fw-semibold fs-7">Add an extra layer of protection to your
                            account.</span></h3>
                </div>
                <div class="card-body pt-4">@if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                @livewire('profile.two-factor-authentication-form') @else <p class="text-gray-500 mb-0">Two-factor
                    authentication is not enabled for this account.</p> @endif</div>
            </div>
        </div>
    </div>

    <div class="card card-flush mt-6">
        <div class="card-header pt-7">
            <h3 class="card-title flex-column align-items-start"><span class="card-label fw-bold text-gray-900">Account
                    sessions</span><span class="text-gray-500 mt-1 fw-semibold fs-7">Review and sign out of other active
                    browser sessions.</span></h3>
        </div>
        <div class="card-body pt-4">@livewire('profile.logout-other-browser-sessions-form')</div>
    </div>

    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
        <div class="card card-flush mt-6 border border-danger">
            <div class="card-header pt-7">
                <h3 class="card-title flex-column align-items-start"><span class="card-label fw-bold text-danger">Delete
                        account</span><span class="text-gray-500 mt-1 fw-semibold fs-7">Permanently remove your Chapu CV account
                        and associated data.</span></h3>
            </div>
            <div class="card-body pt-4">@livewire('profile.delete-user-form')</div>
        </div>
    @endif
@endsection
@extends('header.index')

@section('extratitle')
    Register
@endsection

@push('styles')
    <link href="{{ URL::to('/') }}/css/register.css?ver=1.3.0" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid-custom">
        <div class="row vh-100- bg-white">
            <!-- Left Panel -->
            <div class="col-md-6 left-panel">
                <div>
                    <img src="{{ asset('img/main-logo.png') }}" alt="">
                </div>
                <p class="mt-4 text-center">
                    Open a FREE investor account and unlock exclusive benefits for your personal, private, and secure
                    investing journey.
                </p>
            </div>
            <!-- Right Panel -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="form-container w-100">
                    <h2 class="mb-4">Create your account</h2>
                    <!-- Tabs -->
                    <ul class="nav nav-tabs justify-content-center tabs mb-3 w-100" id="formTabs" role="tablist">
                        <li class="nav-item w-50">
                            <a class="nav-link active" id="individual-tab" data-bs-toggle="tab" href="#individualForm"
                                role="tab" aria-controls="individualForm" aria-selected="true">
                                Individual/Personal
                            </a>
                        </li>
                        <li class="nav-item w-50">
                            <a class="nav-link" id="organization-tab" data-bs-toggle="tab" href="#organizationForm"
                                role="tab" aria-controls="organizationForm" aria-selected="false">
                                Company/Institution
                            </a>
                        </li>
                    </ul>
                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Individual Form -->
                        <div class="tab-pane fade show active" id="individualForm" role="tabpanel"
                            aria-labelledby="individual-tab">
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="individual">
                                <div class="mb-3 mt-4">
                                    <label for="individualName" class="form-label">Name*</label>
                                    <input type="text" id="individualName" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter your name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="individualEmail" class="form-label">Email*</label>
                                    <input type="email" id="individualEmail" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter your email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- confirm_email --}}
                                <div class="mb-3">
                                    <label for="individualConfirmEmail" class="form-label">Confirm Email*</label>
                                    <input type="email" id="individualConfirmEmail" name="confirm_email"
                                        class="form-control @error('confirm_email') is-invalid @enderror"
                                        placeholder="Confirm your email" value="{{ old('confirm_email') }}" required>
                                    @error('confirm_email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="individualPassword" class="form-label">Password*</label>
                                    <input type="password" id="individualPassword" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter your password" required>
                                    @error('password')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="individualConfirmPassword" class="form-label">Confirm Password*</label>
                                    <input type="password" id="individualConfirmPassword" name="password_confirmation"
                                        class="form-control" placeholder="Confirm your password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Sign Up</button>
                                </div>
                                <p class="form-text mt-3">
                                    Already have an account? <a href="javascript:void(0)" title="Login"
                                        data-bs-toggle="modal" data-bs-target="#loginModal" class="text-decoration-none">Log
                                        in</a>
                                </p>
                            </form>
                        </div>
                        <!-- Organization Form -->
                        <div class="tab-pane fade" id="organizationForm" role="tabpanel" aria-labelledby="organization-tab">
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="organization">
                                <div class="mb-3 mt-4">
                                    <label for="organizationName" class="form-label">Company Name*</label>
                                    <input type="text" id="organizationName" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter your company name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="organizationEmail" class="form-label">Email*</label>
                                    <input type="email" id="organizationEmail" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter your company email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="individualConfirmEmail" class="form-label">Confirm Email*</label>
                                    <input type="email" id="individualConfirmEmail" name="confirm_email"
                                        class="form-control @error('confirm_email') is-invalid @enderror"
                                        placeholder="Confirm your email" value="{{ old('confirm_email') }}" required>
                                    @error('confirm_email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="organizationPassword" class="form-label">Password*</label>
                                    <input type="password" id="organizationPassword" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter your password" required>
                                    @error('password')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="organizationConfirmPassword" class="form-label">Confirm Password*</label>
                                    <input type="password" id="organizationConfirmPassword" name="password_confirmation"
                                        class="form-control" placeholder="Confirm your password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Sign Up</button>
                                </div>
                                <p class="form-text mt-3">
                                    Already have an account? <a href="javascript:void(0)" title="Login"
                                        data-bs-toggle="modal" data-bs-target="#loginModal"
                                        class="text-decoration-none">Log in</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var oldType = '{{ old('type') }}';

        if (oldType != '') {
            if (oldType == 'organization') {
                $('#organization-tab').addClass('active');
                $('#organizationForm').addClass('show active');
                $('#individual-tab').removeClass('active');
                $('#individualForm').removeClass('show active');
            }
        }
    </script>
@endpush

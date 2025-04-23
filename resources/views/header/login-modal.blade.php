<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 p-0">
                <h5 class="modal-title" id="loginModalLabel">Welcome back!</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body p-0 mt-3">
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request()->fullUrl() }}">
                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" placeholder="Enter your email">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter your password">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex col-lg-12">
                        <div class="form-check col-lg-6">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
    
                        <div class="ms-auto col-lg-6 text-lg-end">
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3" id="login-button">Login</button>
                </form>

                <div class="text-center mt-3">
                    <span class="text-muted">Don't have an account?</span> <a href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

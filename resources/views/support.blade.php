@extends('header.index')

@section('extratitle')
    Support
@endsection

@push('styles')
    <link href="{{ URL::to('/') }}/css/contact.css?ver=1.3.0" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.5/sweetalert2.all.min.js"
        integrity="sha512-m4zOGknNg3h+mK09EizkXi9Nf7B3zwsN9ow+YkYIPZoA6iX2vSzLezg4FnW0Q6Z1CPaJdwgUFQ3WSAUC4E/5Hg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@section('content')
    <div class="container-fluid-custom py-2">
        <div class="head">
            <h2 class="mb-4">
                Support
            </h2>
            <p class="mb-5">
                Need help? Our dedicated support team is here to assist you with any questions or concerns you may have
            </p>
        </div>
        <div class="row vh-100- bg-white reverse">
            <!-- Left Panel -->
            <div class="col-md-6 left-panel">
                <h2 class="mb-4">
                    Contact
                </h2>
                <p class="mb-5">
                    Phone: 1-844-504-4653
                    <br>
                    <br>
                    Address: 3rd Floor - 55 Dundas St East Toronto, Ontario M5B-1C6
                    <br>
                    <br>
                    Hours: Monday - Friday / 9am - 6pm
                </p>

                @include('map', ['height' => 300])
            </div>
            <!-- Right Panel -->
            <div class="col-md-6 d-flex align-items-center px-0">
                <div class="form-container w-100">
                    <h2 class="mb-4">Hi, how can we help you today?</h2>
                    <!-- Tabs -->
                    <!-- Tab Content -->
                    <div>
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="mb-3 mt-4">
                                <label for="individualName" class="form-label">Name*</label>
                                <input type="text" id="individualName" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="individualEmail" class="form-label">Email*</label>
                                <input type="email" id="individualEmail" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- message --}}
                            <div class="mb-4">
                                <label for="individualMessage" class="form-label">Message*</label>
                                <textarea id="individualMessage" name="message" rows="5"
                                    class="form-control @error('message') is-invalid @enderror" placeholder="Enter your message" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="cf-turnstile" data-sitekey="{{ config('services.cloudflare.turnstile_site_key') }}">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <p class="form-text">
            Check our <a href="{{ route('faq') }}">Frequently Asked Questions</a> for more information!
        </p>
    </div>
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.5/sweetalert2.min.js"
        integrity="sha512-JCDnPKShC1tVU4pNu5mhCEt6KWmHf0XPojB0OILRMkr89Eq9BHeBP+54oUlsmj8R5oWqmJstG1QoY6HkkKeUAg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if (Session::has('message'))
        <script type="text/javascript">
            // function massge() {
            // console.log('massge');

            Swal.fire({
                title: 'Success!',
                text: '{{ Session::get('message') }}',
                icon: 'success',
                showConfirmButton: false,
            });
            // }
            // window.onload = massge;
        </script>
    @endif
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback" defer></script>
@endpush

@extends('voyager::master')

@section('page_title', 'Send Promo Code Email to Users')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h1>Send Promo Code Email to Users</h1>
            <form action="{{ route('admin.promo-codes.send-email') }}" method="POST">
                @csrf
                <div class="row">
                    {{-- select 2 search users multiple --}}
                    <div class="form-group col-lg-12">
                        <label for="users">Users</label>
                        <select name="users[]" id="users" class="form-control" multiple required>
                        </select>
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="promo_code_id">Promo Code</label>
                        <select name="promo_code_id" id="promo_code_id" class="form-control" required>
                            <option value="">Select Promo Code</option>
                            @foreach ($promoCodes as $promoCode)
                                <option value="{{ $promoCode->id }}">{{ $promoCode->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Send Email</button>
            </form>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            $('#users').select2({
                placeholder: 'Select Users', // Placeholder text
                minimumInputLength: 2, // Start searching after 2 characters
                closeOnSelect: false, // Prevent dropdown from closing on selection
                ajax: {
                    url: '{{ route('admin.ajax-users') }}', // Route for fetching data
                    dataType: 'json',
                    delay: 250, // Delay for better performance
                    data: function(params) {
                        return {
                            search: params.term, // Search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data, // Data must have `id` and `text`
                        };
                    },
                    cache: true,
                },
            });
        });
    </script>
@endpush

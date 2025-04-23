@extends('header.index')

@push('styles')
    <link href="{{ URL::to('/') }}/css/registration-form.css?ver=1.2.0" rel="stylesheet">
@endpush

@section('content')
    <div class="title-page-1 text-center" style="display: block !important;">Complete Registration</div>
    <div id="msg" class="alert invisible" role="alert">
        Error
    </div>
    <form id="complete-registration-form" method="post" action="{{ route('saveprofile') }}">
        @csrf
        <div class="row main-cont"
            style='background-image: {{ url('/img/new/form-bg.png') }} background-repeat: no-repeat;background-size:contain;'>
            <div class="col-12 col-md-5 offset-md-1 extra-margin-top">
                <div class="form-group">
                    <input type="text" class="form-control makeup-input" id="fname" name="fname"
                        placeholder="First Name" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control makeup-input" id="lname" name="lname"
                        placeholder="Last Name" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control makeup-input" id="city" name="city" placeholder="City"
                        required />
                </div>
                <div class="form-group">
                    <select id="province_id" name="province_id" class="form-control makeup-input" required>
                        <option value="" disabled selected>Province</option>
                        @foreach ($provinces as $province)
                            <option value={{ $province->id }}>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-5 extra-margin-top">
                <div class="form-group">
                    <input type="text" class="form-control makeup-input" id="address_line1" name="address_line1"
                        placeholder="Address" name="address" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control makeup-input" id="postcode" name="postcode"
                        placeholder="Postal Code" required />
                </div>
                <div class="form-group">
                    <input type="number" class="form-control makeup-input" id="phone" name="phone"
                        placeholder="Phone Number" required />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control makeup-input" id="email" placeholder="Email"
                        value="<?= $user->email ?>" disabled>
                </div>
                <button type="submit" id="submit" class="btn makeup-btn-dark-green">Save</button>
            </div>
        </div>
    </form>
@endsection

@extends('voyager::master')

@section('page_title', 'Edit Scrap Commission Prices')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h3>Edit Scrap Commission Prices (%)</h3>
        <form action="{{ route('admin.scrap-metals-commission.update') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="gold">Gold</label>
                    <input type="number" name="gold" id="gold" class="form-control" placeholder="Enter Gold Commission"
                        value="{{ old('gold', $commission['gold']) }}" required>
                        @if ($errors->has('gold'))
                        <span class="text-danger">{{ $errors->first('gold') }}</span>
                        @endif
                </div>

                <div class="form-group col-lg-3">
                    <label for="silver">Silver</label>
                    <input type="number" name="silver" id="silver" class="form-control" placeholder="Enter Silver Commission"
                        value="{{ old('silver', $commission['silver']) }}" required>
                        @if ($errors->has('silver'))
                        <span class="text-danger">{{ $errors->first('silver') }}</span>
                        @endif
                </div>

                <div class="form-group col-lg-3">
                    <label for="platinum">Platinum</label>
                    <input type="number" name="platinum" id="platinum" class="form-control" placeholder="Enter Platinum Commission"
                        value="{{ old('platinum', $commission['platinum']) }}" required>
                        @if ($errors->has('platinum'))
                        <span class="text-danger">{{ $errors->first('platinum') }}</span>
                        @endif
                </div>

                <div class="form-group col-lg-3">
                    <label for="palladium">Palladium</label>
                    <input type="number" name="palladium" id="palladium" class="form-control" placeholder="Enter Palladium Commission"
                        value="{{ old('palladium', $commission['palladium']) }}" required>
                        @if ($errors->has('palladium'))
                        <span class="text-danger">{{ $errors->first('palladium') }}</span>
                        @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</div>
@endsection

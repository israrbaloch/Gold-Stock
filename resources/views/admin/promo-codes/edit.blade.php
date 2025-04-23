@extends('voyager::master')

@section('page_title', 'Edit Promo Code')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h1>Edit Promo Code</h1>
        <form action="{{ route('admin.promo-codes.update', $promoCode->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="code">Promo Code</label>
                    <input type="text" name="code" id="code" class="form-control" placeholder="Enter Promo Code" value="{{ old('code', $promoCode->code) }}" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="discount_type">Discount Type</label>
                    <select name="discount_type" id="discount_type" class="form-control" required>
                        <option value="percentage" {{ $promoCode->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="flat" {{ $promoCode->discount_type == 'flat' ? 'selected' : '' }}>Flat</option>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="discount">Discount Value</label>
                    <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter Discount Value" value="{{ old('discount', $promoCode->discount) }}" required>
                    <small id="discount-help" class="form-text text-muted">
                        For percentage, enter a value between 0 and 100. For flat, enter a fixed amount.
                    </small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="valid_from">Valid From</label>
                    <input type="date" name="valid_from" id="valid_from" class="form-control" value="{{ old('valid_from', $promoCode->valid_from->toDateString()) }}" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="valid_until">Valid Until</label>
                    <input type="date" name="valid_until" id="valid_until" class="form-control" value="{{ old('valid_until', $promoCode->valid_until->toDateString()) }}" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="is_active">Active</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1" {{ $promoCode->is_active == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $promoCode->is_active == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Promo Code</button>
            <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
@endsection

@extends('voyager::master')

@section('page_title', 'Create Promo Code')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h1>Create Promo Code</h1>
        <form action="{{ route('admin.promo-codes.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="code">Promo Code</label>
                    <input type="text" name="code" id="code" class="form-control" placeholder="Enter Promo Code" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="discount_type">Discount Type</label>
                    <select name="discount_type" id="discount_type" class="form-control" required>
                        <option value="percentage">Percentage</option>
                        <option value="flat">Flat</option>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="discount">Discount Value</label>
                    <input type="number" name="discount" id="discount" class="form-control" placeholder="Enter Discount Value" required>
                    <small id="discount-help" class="form-text text-muted">
                        For percentage, enter a value between 0 and 100. For flat, enter a fixed amount.
                    </small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="valid_from">Valid From</label>
                    <input type="date" name="valid_from" id="valid_from" class="form-control" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="valid_until">Valid Until</label>
                    <input type="date" name="valid_until" id="valid_until" class="form-control" required>
                </div>
                <div class="form-group col-lg-4">
                    <label for="is_active">Active</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Promo Code</button>
            <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
@endsection

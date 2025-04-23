@extends('voyager::master')

@section('page_title', 'Promo Codes')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <h1 class="page-title">
                    <i class="voyager-dollar"></i>
                    Promo Codes
                </h1>
                <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-success btn-add-new">
                    <i class="voyager-plus"></i> <span>Add New</span>
                </a>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Discount Type</th>
                            <th>Discount Value</th>
                            <th>Valid From</th>
                            <th>Valid Until</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promoCodes as $promoCode)
                            <tr>
                                <td>{{ $promoCode->id }}</td>
                                <td>{{ $promoCode->code }}</td>
                                <td>{{ $promoCode->discount_type }}</td>
                                <td>
                                    @if ($promoCode->discount_type === 'percentage')
                                        {{ $promoCode->discount }}%
                                    @else
                                        ${{ $promoCode->discount }}
                                    @endif
                                </td>
                                <td>{{ $promoCode->valid_from }}</td>
                                <td>{{ $promoCode->valid_until }}</td>
                                <td>{{ $promoCode->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.promo-codes.edit', $promoCode) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.promo-codes.destroy', $promoCode) }}" method="POST"
                                        style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this promo code?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No promo codes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $promoCodes->links() }}
        </div>
    </div>
@endsection

@extends('voyager::master')

@section('content')
    <div class="container">
        <h2>Home Page Banners</h2>
        <div class="voyager-buttons">
            <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
                Create New Banner
            </a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                <tr>
                    <td>{{ $banner->position }}</td>
                    <td>{{ $banner->title }}</td>
                    <td><img src="{{ asset('storage/' . $banner->image) }}" width="100"></td>
                    <td>
                        {{ $banner->start_date ? \Carbon\Carbon::parse($banner->start_date)->format('d M Y') : '---' }}
                        to
                        {{ $banner->end_date ? \Carbon\Carbon::parse($banner->end_date)->format('d M Y') : '---' }}
                    </td>                    
                    <td>{{ $banner->status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Delete this banner?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $banners->links() }}
    </div>
@endsection

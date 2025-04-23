@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>List of Blogs</h1>
        <div class="voyager-buttons">
            <a href="{{ route('admin.blogs.create.view') }}" class="btn btn-success">Create</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    {{-- <th>Description</th> --}}
                    {{-- <th>URL</th> --}}
                    {{-- <th>Image</th> --}}
                    <th class="text-center">Disabled</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>
                            <a href="{{ route('admin.blogs.update.view', $blog->id) }}">{{ $blog->id }}</a>
                        </td>
                        <td>{{ $blog->title }}</td>
                        {{-- <td>{{ $blog->description }}</td> --}}
                        {{-- <td>{{ $blog->url }}</td> --}}
                        {{-- <td><img src="{{ $blog->image }}" alt="Image" style="width: 100px; height: auto;"></td> --}}
                        {{-- <td>{{ $blog->image }}</td> --}}
                        <td class="text-center"><input type="checkbox" {{ $blog->disabled ? 'checked' : '' }} disabled></td>
                        <td>{{ $blog->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $blogs->links() }}
    </div>
@endsection

@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>List of News</h1>
        <div class="voyager-buttons">
            <a href="{{ route('admin.news.create.view') }}" class="btn btn-success">Create</a>
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
                @foreach ($news as $new)
                    <tr>
                        <td>
                            <a href="{{ route('admin.news.update.view', $new->id) }}">{{ $new->id }}</a>
                        </td>
                        <td>{{ $new->title }}</td>
                        {{-- <td>{{ $new->description }}</td> --}}
                        {{-- <td>{{ $new->url }}</td> --}}
                        {{-- <td><img src="{{ $new->image }}" alt="Image" style="width: 100px; height: auto;"></td> --}}
                        {{-- <td>{{ $new->image }}</td> --}}
                        <td class="text-center"><input type="checkbox" {{ $new->disabled ? 'checked' : '' }} disabled></td>
                        <td>{{ $new->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $news->links() }}
    </div>
@endsection

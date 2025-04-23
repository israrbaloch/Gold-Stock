@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>List of Schedulers</h1>
        <div class="voyager-buttons">
            <a href="{{ route('admin.mails.scheduler.create.view') }}" class="btn btn-success">Create</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Scheduled At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedulers as $scheduler)
                    <tr>
                        <td>
                            <a
                                href="{{ route('admin.mails.scheduler.update.view', $scheduler->id) }}">{{ $scheduler->id }}</a>
                        </td>
                        <td>{{ $scheduler->template->subject }}</td>
                        <td>{{ $scheduler->type }}</td>
                        <td>{{ $scheduler->status }}</td>
                        <td>{{ $scheduler->scheduled_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

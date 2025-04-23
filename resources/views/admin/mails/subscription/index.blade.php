@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>List of Subscriptions</h1>
        <div class="voyager-buttons">
            <a href="{{ route('admin.mails.subscription.create.view') }}" class="btn btn-success">Create</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptionLists as $subscriptionList)
                    <tr>
                        <td>
                            <a
                                href="{{ route('admin.mails.subscription.update', $subscriptionList->id) }}">{{ $subscriptionList->id }}</a>
                        </td>
                        <td>{{ $subscriptionList->name }}</td>
                        <td>{{ $subscriptionList->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

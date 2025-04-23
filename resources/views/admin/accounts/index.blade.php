@extends('voyager::master')

@section('content')
<div class="container-fluid">
    <h1>Accounts</h1>
    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary">Create Account</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->user_id }}</td>
                    <td>{{ $account->number }}</td>
                    <td>
                        <a href="{{ route('admin.accounts.show', $account->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('admin.accounts.edit', $account->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $accounts->links() }}
</div>
@endsection

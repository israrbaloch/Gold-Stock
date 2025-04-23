@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Update Subscription List</h1>

        <form id="form">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required maxlength="120"
                    value="{{ $subscriptionList->name }}">
            </div>

            {{-- Users --}}
            <div class="form-group" id="specific_users_container">
                <label for="search_users">Users</label>
                <input type="text" name="search_users" id="search_users" class="form-control">
                <div class="buttons-container" data-buttons-container="search_users"></div>
                <div class="buttons-container" data-buttons-container="users_selected">
                    <table class="table table-hover dataTable no-footer">
                        <thead>
                            <tr role="row">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($subscriptionList->users as $index => $user)
                                <tr role="row" data-user-id="{{ $user->id }}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="onRemoveUser({{ $user->id }})">
                                            <i class="voyager-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="buttons-container">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

            <div id="errors-container" style="display: none">
                <hr>
                <div id="errors">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        const updateMode = true;
        const listId = {{ $subscriptionList->id }};
    </script>
    <script type="text/javascript" src="{{ asset('js/voyager-subscription.js') }}"></script>
@endsection


@section('css')
    <style>
        .buttons-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
            gap: 0.5rem
        }

        .buttons-container button {
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection

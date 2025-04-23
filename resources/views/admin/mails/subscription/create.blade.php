@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Create Subscription List</h1>

        <form id="form">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required maxlength="120">
            </div>

            <div class="form-group" id="specific_users_container">
                <label for="search_users">Users</label>
                <input type="text" name="search_users" id="search_users" class="form-control" data-depends-on="name">
                <div class="buttons-container" data-buttons-container="search_users"></div>

                <table class="table table-hover dataTable no-footer">
                    <thead>
                        <tr role="row">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row">
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="buttons-container">
                <button type="submit" class="btn btn-primary" data-depends-on="name">
                    Create
                </button>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/voyager-common.js') }}"></script>
    <script>
        const updateMode = false;
    </script>
    <script type="text/javascript" src="{{ asset('js/voyager-subscription.js') }}"></script>
@endsection

@section('css')
    <style>
        .buttons-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
            gap: 0.5rem;
        }

        .buttons-container button {
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection

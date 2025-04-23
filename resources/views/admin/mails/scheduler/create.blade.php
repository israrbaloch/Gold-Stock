@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Create Scheduler</h1>

        <form id="form">
            @csrf
            <div class="form-group">
                <label for="template_id">Template</label>
                <select name="template_id" id="template_id" class="form-control" required>
                    <option value="">Select Template</option>
                    @foreach ($mailTemplates as $index => $mailTemplate)
                        <option value="{{ $mailTemplate->id }}">
                            {{ $mailTemplate->subject }} -
                            {{ $mailTemplate->subscription ? $mailTemplate->subscription : 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="scheduled_at">Scheduled At</label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control" required
                    min="{{ now()->format('Y-m-d\TH:i') }}" data-depends-on="template_id">
                <small class="form-text text-muted">Time less than 10 mins, will be added.</small>
            </div>

            {{-- Type --}}
            <div class="form-group">
                <label for="type">Type</label>
                <div class="checkbox-group-container">
                    <div class="form-check d-flex">
                        <input type="radio" name="type" id="all_users" value="all" class="form-check-input"
                            data-depends-on="scheduled_at">
                        <label for="all_users" class="form-check-label">All Users</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" name="type" id="business_users" value="business" class="form-check-input"
                            data-depends-on="scheduled_at">
                        <label for="business_users" class="form-check-label">Business Users</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" name="type" id="specific_users" value="specific" class="form-check-input"
                            data-depends-on="scheduled_at">
                        <label for="specific_users" class="form-check-label">Specific Users</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" name="type" id="subscription_list" value="list" class="form-check-input"
                            data-depends-on="scheduled_at">
                        <label for="subscription_list" class="form-check-label">Subcription Lists</label>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <div class="form-group" style="display: none;" id="specific_users_container">
                <label for="search_users">Users</label>
                <input type="text" name="search_users" id="search_users" class="form-control">
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

            {{-- Subscription List --}}
            <div class="form-group" style="display: none;" id="subscription_list_container">
                <label for="subscription_id">Subscription List</label>
                <select name="subscription_id" id="subscription" class="form-control">
                    <option value="">Select Subscription List</option>
                    @foreach ($subscriptionLists as $index => $subscriptionList)
                        <option value="{{ $subscriptionList->id }}">{{ $subscriptionList->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="buttons-container">
                <button type="submit" class="btn btn-primary" data-depends-on="type">
                    Create
                </button>
            </div>

            <div id="errors-container" style="display: none">
                <hr>
                <div id="errors">
                </div>
            </div>

            {{-- Preview Users --}}
            <div class="form-group" style="display: none;" id="preview_users_container">
                <label for="search_users">Mails</label>
                <div class="buttons-container" data-buttons-container="preview_users">
                    <table class="table table-hover dataTable no-footer">
                        <thead>
                            <tr role="row">
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="preview_users_body">

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/voyager-common.js') }}"></script>
    <script>
        const updateMode = false;
    </script>
    <script type="text/javascript" src="{{ asset('js/voyager-scheduler.js') }}"></script>
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

        .checkbox-group-container {
            display: flex;
            gap: 0.5rem;
        }

        .checkbox-group-container label {
            user-select: none;
        }
    </style>
@endsection

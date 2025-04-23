@extends('voyager::master')


@php
    $expired = false;
    if (strtotime($scheduler->scheduled_at) < strtotime(date('Y-m-d H:i:s'))) {
        $expired = true;
    }
@endphp

@section('content')
    <div class="container">
        <h1>Update Scheduler</h1>

        <form id="form">
            @csrf
            <div class="form-group">
                <label for="template_id">Template</label>
                <select name="template_id" id="template_id" class="form-control" required {{ $expired ? 'disabled' : '' }}>
                    @foreach ($mailTemplates as $index => $mailTemplate)
                        <option value="{{ $mailTemplate->id }}"
                            {{ $mailTemplate->id == $scheduler->template_id ? 'selected' : '' }}>
                            {{ $mailTemplate->subject }} -
                            {{ $mailTemplate->subscription ? $mailTemplate->subscription : 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="scheduled_at">Scheduled At</label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control"
                    value="{{ $scheduler->scheduled_at }}" required {{ $expired ? 'disabled' : '' }}
                    min="{{ now()->format('Y-m-d\TH:i') }}">
                <small class="form-text text-muted">Time less than 10 mins, will be added.</small>
            </div>

            {{-- Type --}}
            <div class="form-group">
                <label for="type">Type</label>
                <div class="checkbox-group-container">
                    <div class="form-check d-flex">
                        <input type="radio" onclick="onTypeChange()" name="type" id="all_users" value="all"
                            class="form-check-input" {{ $scheduler->type == 'all' ? 'checked' : '' }}
                            {{ $expired ? 'disabled' : '' }}>
                        <label for="all_users" class="form-check-label">All Users</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" onclick="onTypeChange()" name="type" id="business_users" value="business"
                            class="form-check-input" {{ $scheduler->type == 'business' ? 'checked' : '' }}
                            {{ $expired ? 'disabled' : '' }}>
                        <label for="business_users" class="form-check-label">Business Users</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" onclick="onTypeChange()" name="type" id="specific_users" value="specific"
                            class="form-check-input" {{ $scheduler->type == 'specific' ? 'checked' : '' }}
                            {{ $expired ? 'disabled' : '' }}>
                        <label for="specific_users" class="form-check-label">Specific Users</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" onclick="onTypeChange()" name="type" id="subscription_list" value="list"
                            class="form-check-input" {{ $scheduler->type == 'list' ? 'checked' : '' }}
                            {{ $expired ? 'disabled' : '' }}>
                        <label for="subscription_list" class="form-check-label">Subcription Lists</label>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <div class="form-group" {{ $scheduler->type !== 'specific' ? 'style=display:none;' : '' }}
                id="specific_users_container">
                <label for="search_users">Users</label>
                @if (!$expired)
                    <input type="text" name="search_users" id="search_users" class="form-control">
                    <div class="buttons-container" data-buttons-container="search_users"></div>
                @endif
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

                            @foreach ($selectedUsers as $index => $selectedUser)
                                <tr role="row" data-user-id="{{ $selectedUser->user->id }}">
                                    <td>{{ $selectedUser->user->name }}</td>
                                    <td>{{ $selectedUser->user->email }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="onRemoveUser({{ $selectedUser->user->id }})"
                                            {{ $expired ? 'disabled' : '' }}>
                                            <i class="voyager-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Subscription List --}}
            <div class="form-group" {{ $scheduler->type !== 'list' ? 'style=display:none;' : '' }}
                id="subscription_list_container">
                <label for="subscription_id">Subscription List</label>
                <select name="subscription_id" id="subscription" class="form-control" {{ $expired ? 'disabled' : '' }}>
                    <option value="">Select Subscription List</option>
                    @foreach ($subscriptionLists as $index => $subscriptionList)
                        <option value="{{ $subscriptionList->id }}"
                            {{ $subscriptionList->id == $scheduler->subscription_id ? 'selected' : '' }}>
                            {{ $subscriptionList->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="buttons-container">
                <button type="submit" class="btn btn-primary">Update</button>
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
    <script>
        const updateMode = true;
        const schedulerId = {{ $scheduler->id }};
    </script>
    <script type="text/javascript" src="{{ asset('js/voyager-scheduler.js') }}"></script>
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

        .checkbox-group-container {
            display: flex;
            gap: 0.5rem;
        }

        .checkbox-group-container label {
            user-select: none;
        }
    </style>
@endsection

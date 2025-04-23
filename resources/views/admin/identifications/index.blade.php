@extends('voyager::master')

@section('content')
    <div class="page-content">

        <div class="container-fluid">
            <div class="d-flex mt-3">
                <h4 class="heading">Identifications</h4>
                {{-- Fileter Verified and not verified --}}
                <div class="ml-auto">
                    <form action="{{ url()->current() }}" method="GET" class="form-inline">
                        <div class="form-group row">
                            {{-- <label for="verified" class="col-sm-2 col-form-label">Verified</label> --}}
                            <div class="col-sm-10 m-0">
                                <select name="verified" id="verified" class="form-control">
                                    <option value="">All</option>
                                    <option value="1" {{ request()->verified == 1 ? 'selected' : '' }}>Verified
                                    </option>
                                    <option value="0" {{ request()->verified == '0' ? 'selected' : '' }}>Not Verified
                                    </option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
            {{-- <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary">Create Account</a> --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>
                            Document
                        </th>
                        <th>
                            Status
                        </th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($identifications as $identification)
                        <tr>
                            <td>{{ $identification->id }}</td>
                            <td>{{ $identification->user_id }}</td>
                            <td>{{ $identification->user->name }}</td>
                            <td>
                                <a href="{{ $identification->file }}" target="_blank">
                                    View Document
                                </a>
                            </td>
                            {{-- verified --}}
                            <td>
                                @if ($identification->verified)
                                    <span class="badge badge-success">Verified</span>
                                @else
                                    <span class="badge badge-danger">Not Verified</span>
                                @endif
                            <td>{{ $identification->updated_at }}</td>
                            <td>
                                {{-- Approve or decline --}}
                                <form action="{{ route('admin.identifications.approve', $identification->id) }}"
                                    method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to approve this identification?');">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                                <form action="{{ route('admin.identifications.reject', $identification->id) }}"
                                    method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to reject this identification?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No identifications found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $identifications->links() }}
        </div>
    </div>
@endsection

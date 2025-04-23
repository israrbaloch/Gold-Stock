@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>List of Mail Templates</h1>
        <div class="voyager-buttons">
            <a href="{{ route('admin.mails.create.view') }}" class="btn btn-success">Create</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Template</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mailTemplates as $mailTemplate)
                    <tr>
                        <td>
                            <a href="{{ route('admin.mails.update.view', $mailTemplate->id) }}">{{ $mailTemplate->id }}</a>
                        </td>
                        <td>{{ $mailTemplate->subject }}</td>
                        <td>
                            @foreach ($mailTemplatesNames as $mailTemplatesName)
                                @if ($mailTemplatesName['template'] == $mailTemplate->template)
                                    {{ $mailTemplatesName['name'] }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $mailTemplate->created_at }}</td>
                        <td>{{ $mailTemplate->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

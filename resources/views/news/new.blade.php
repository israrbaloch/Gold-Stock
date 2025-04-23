@extends('header.index')

@section('extratitle')
    {{ strip_tags($new->title) }}
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#shareButton').click(function() {
                navigator.clipboard.writeText('{{ url('/news/' . $new->id) }}')
                    .catch(err => console.error('Could not copy text: ', err));
            });
        });
    </script>
@endpush

@section('content')
    <div class="page-container container new-container">

        <img class="header-image" src="{{ asset('storage/' . $new->image) }}" alt="{{ strip_tags($new->title) }}">

        <h1>{{ strip_tags($new->title) }}</h1>

        <p class="date">{{ \Carbon\Carbon::parse($new->date)->format('d/m/Y') }}</p>

        <hr>

        <div class="content">{!! $new->description !!}</div>

        <br>
        <hr>
        <br>

        <button id="shareButton">
            <img src="{{ asset('img/icons/share.svg') }}" alt="">
            Share
        </button>

    </div>
@endsection

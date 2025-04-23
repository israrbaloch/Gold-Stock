@extends('header.index')

@section('extratitle')
    {{ strip_tags($blog->title) }}
@endsection

@push('scripts')
    <script>
        function copyUrl(slug) {
            navigator.clipboard.writeText('{{ route('blog') }}' + '/' + slug)
                .catch(err => console.error('Could not copy text: ', err));
        }
    </script>
@endpush

@section('content')
    <div class="page-container container blog-container">

        <img class="header-image" src="{{ asset('storage/' . $blog->image) }}" alt="{{ strip_tags($blog->title) }}">

        <h1>{{ strip_tags($blog->title) }}</h1>

        <p class="date">{{ \Carbon\Carbon::parse($blog->date)->format('d/m/Y') }}</p>

        <hr>

        <div class="content">{!! $blog->description !!}</div>

        <br>
        <hr>
        <br>

        <button id="shareButton" onclick="copyUrl('{{ $blog->slug }}')">
            <img src="{{ asset('img/icons/share.svg') }}" alt="">
            Share
        </button>

    </div>
@endsection

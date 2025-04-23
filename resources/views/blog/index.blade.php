@extends('header.index')

@section('extratitle')
    Blogs
@endsection

@php
    $prev_img = 0;
@endphp

@push('styles')
    <link href="{{ URL::to('/') }}/css/style-new.css?ver=1.2.0" rel="stylesheet">
@endpush

@section('content')
    <div class="page-container container blogs-container">

        @if (count($blogs) != 0)
            <h1 class="text-center">Exploring the Art of Gold Refinement</h1>
            <div class="list-container">
                @foreach ($blogs as $i => $blog)
                    <a class="blog-container" href="/blog/{{ $blog->slug }}">
                        <div class="col-12">
                            <div class="img-container">
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ strip_tags($blog->title) }}">
                            </div>
                        </div>
                        <div class="content">
                            <h2 class="blog-title text-bold">
                                {{ $blog->title }}
                            </h2>
                            @if (strlen($blog->description))
                                <p class="">
                                    @php
                                        $text = strip_tags($blog->description);

                                        $text_only_spaces = preg_replace('/\s+/', ' ', $text);

                                        // truncates the text
                                        $text_truncated =
                                            strlen($text) > 180
                                                ? mb_substr(
                                                    $text_only_spaces,
                                                    0,
                                                    mb_strpos($text_only_spaces, ' ', 180),
                                                )
                                                : $text;

                                        // prevents last word truncation
                                        $desc =
                                            strlen($text) > 180
                                                ? trim(
                                                        mb_substr($text_truncated, 0, mb_strrpos($text_truncated, ' ')),
                                                    ) . '...'
                                                : $text;
                                        echo $desc;
                                    @endphp
                                </p>
                            @else
                                <br>
                                <br>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="no-available">
                <span>No blogs Available</span>
            </div>
        @endif

    </div>
@endsection

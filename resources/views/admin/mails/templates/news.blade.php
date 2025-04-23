@extends('admin.mails.components.base')


@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mail.css') }}">
@endsection

@php
    if (!function_exists('truncateText')) {
        function truncateText($text)
        {
            $text = strip_tags($text);

            $text_only_spaces = preg_replace('/\s+/', ' ', $text);

            // truncates the text
            $text_truncated =
                strlen($text) > 600 ? mb_substr($text_only_spaces, 0, mb_strpos($text_only_spaces, ' ', 600)) : $text;

            // prevents last word truncation
            $desc =
                strlen($text) > 600
                    ? trim(mb_substr($text_truncated, 0, mb_strrpos($text_truncated, ' '))) . '...'
                    : $text;
            return $desc;
        }
    }
@endphp


@section('content')
    <div class="mail-container">
        <div class="news-container">
            <h1>
                Recent News
            </h1>
            @if (isset($news1))
                <table style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h2><a href="{{ url('news/' . $news1->slug) }}">{{ $news1->title }}</a></h2>
                            <p>{{ truncateText($news1->description) }}</p>
                        </td>
                        <td>
                            <a href="{{ url('news/' . $news1->slug) }}"><img
                                    src="{{ asset('storage/' . $news1->image) }}"></a>
                        </td>
                    </tr>
                </table>
                <hr>
            @endif
            @if (isset($news2))
                <table style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h2><a href="{{ url('news/' . $news2->slug) }}">{{ $news2->title }}</a></h2>
                            <p>{{ truncateText($news2->description) }}</p>
                        </td>
                        <td>
                            <a href="{{ url('news/' . $news2->slug) }}"><img
                                    src="{{ asset('storage/' . $news2->image) }}"></a>
                        </td>
                    </tr>
                </table>
                <hr>
            @endif
            @if (isset($news3))
                <table style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h2><a href="{{ url('news/' . $news3->slug) }}">{{ $news3->title }}</a></h2>
                            <p>{{ truncateText($news3->description) }}</p>
                        </td>
                        <td>
                            <a href="{{ url('news/' . $news3->slug) }}"><img
                                    src="{{ asset('storage/' . $news3->image) }}"></a>
                        </td>
                    </tr>
                </table>
                <hr>
            @endif
        </div>
    </div>
@endsection

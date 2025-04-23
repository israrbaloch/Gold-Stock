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
        <div class="blogs-container">
            <h1>
                Read our latest blog posts here:
            </h1>
            @if (isset($blog1))
                <table style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h2><a href="{{ url('blog/' . $blog1->slug) }}">{{ $blog1->title }}</a></h2>
                            <p>{{ truncateText($blog1->description) }}</p>
                        </td>
                        <td>
                            <a href="{{ url('blog/' . $blog1->slug) }}"><img
                                    src="{{ asset('storage/' . $blog1->image) }}"></a>
                        </td>
                    </tr>
                </table>
                <hr>
            @endif
            @if (isset($blog2))
                <table style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h2><a href="{{ url('blog/' . $blog2->slug) }}">{{ $blog2->title }}</a></h2>
                            <p>{{ truncateText($blog2->description) }}</p>
                        </td>
                        <td>
                            <a href="{{ url('blog/' . $blog2->slug) }}"><img
                                    src="{{ asset('storage/' . $blog2->image) }}"></a>
                        </td>
                    </tr>
                </table>
                <hr>
            @endif
            @if (isset($blog3))
                <table style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <h2><a href="{{ url('blog/' . $blog3->slug) }}">{{ $blog3->title }}</a></h2>
                            <p>{{ truncateText($blog3->description) }}</p>
                        </td>
                        <td>
                            <a href="{{ url('blog/' . $blog3->slug) }}"><img
                                    src="{{ asset('storage/' . $blog3->image) }}"></a>
                        </td>
                    </tr>
                </table>
                <hr>
            @endif
        </div>
    </div>
@endsection

@extends('admin.mails.components.base')


@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mail.css') }}">
@endsection


@section('content')
    <div class="mail-container">
        <h1>
            @if (isset($title))
                {{ $title }}
            @endif
        </h1>
        <div class="product-container">
            @if (isset($product))
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 33%;">
                            @php
                                $imagesData = json_decode($product->images);
                                $image = $imagesData[0];
                                $image = asset('/storage/' . str_replace('\\', '/', $image));
                            @endphp
                            <img src="{{ $image }}" style="width: 100%; transform: rotate(-10deg);">
                        </td>
                    </tr>
                </table>
            @endif
            @if (isset($product2))
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 33%;">
                            @php
                                $imagesData = json_decode($product2->images);
                                $image = $imagesData[0];
                                $image = asset('/storage/' . str_replace('\\', '/', $image));
                            @endphp
                            <img src="{{ $image }}" style="width: 100%;">
                        </td>
                    </tr>
                </table>
            @endif
            @if (isset($product3))
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 33%;">
                            @php
                                $imagesData = json_decode($product3->images);
                                $image = $imagesData[0];
                                $image = asset('/storage/' . str_replace('\\', '/', $image));
                            @endphp
                            <img src="{{ $image }}" style="width: 100%; transform: rotate(10deg);">
                        </td>
                    </tr>
                </table>
            @endif
        </div>

        @if (isset($description))
            <p>
                {{ $description }}
            </p>
        @endif

        <br>

        @if (isset($product))
            @include('admin.mails.components.button', [
                'route' => 'shop',
                'text' => 'Go to shop',
            ])
        @endif
    </div>
@endsection

@extends('header.index')
@push('styles')
    <link href="{{ URL::to('/') }}/css/withdrawal.css?ver=1.2.0" rel="stylesheet">
@endpush



@section('content')
    <br>
    <div class="page-container container">
        <div class="title-page-1" style="display: block;">Select Metal to Convert to Physical</div>
        <div class="coins-container" style="margin-top: 20px;">
            @foreach ($metals as $metal)
                <div class="coin-container" data-code="<?= $metal['name'] ?>" data-name="<?= $metal['name'] ?>">
                    <a href="/convert-to-physical?metal=<?= $metal['name'] ?>" data-id="<?= $metal['id'] ?>">
                        <?= $metal['name'] ?> <span class="coin-name"></span>
                    </a>
                </div>
            @endforeach
            <div class="gray-bar"></div>
        </div>
        <br>
    </div>
@endsection

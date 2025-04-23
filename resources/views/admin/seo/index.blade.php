@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>List of Routes</h1>

        {{-- Search Input --}}
        <input type="text" id="search" class="form-control" placeholder="Search...">

        <br>

        {{-- Routes Table --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Route</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Keywords</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($routes as $route)
                    @php
                        $seo = $seos->where('uri', $route->uri)->first();
                        $title = '';
                        $description = '';
                        $keywords = '';
                        if ($seo) {
                            $title = $seo->title;
                            $description = $seo->description;
                            if (strlen($title) > 40) {
                                $title = substr($title, 0, 40) . '...';
                            }
                            if (strlen($description) > 40) {
                                $description = substr($description, 0, 40) . '...';
                            }
                            $keywords = $seo->keywords->implode('value', ', ');
                            if (strlen($keywords) > 40) {
                                $keywords = substr($keywords, 0, 40) . '...';
                            }
                        }
                    @endphp
                    <tr data-uri="{{ $route->uri }}">
                        <td>
                            <a href="{{ route('voyager.seos.edit.uri') }}?uri={{ urlencode($route->uri) }}">
                                {{ $route->uri }}
                            </a>
                        </td>
                        <td>
                            @if ($seo)
                                {{ $title }}
                            @endif
                        </td>
                        <td>
                            @if ($seo)
                                {{ $description }}
                            @endif
                        </td>
                        <td>
                            @if ($seo)
                                {{ $keywords }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection


@section('javascript')
    <script>
        $(function() {
            $('#search').on('keyup', function() {
                let value = $(this).val().toString().toLowerCase();
                // display to those rows that match the search query
                let trs = $('table tbody tr')
                trs.each(function(index, tr) {
                    let uri = $(tr).data('uri').toString().toLowerCase();
                    if (uri.includes(value)) {
                        $(tr).show();
                    } else {
                        $(tr).hide();
                    }
                });
            });
        });
    </script>
@endsection

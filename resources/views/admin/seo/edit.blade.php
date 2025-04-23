@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Update Route</h1>

        <form method="POST" enctype="multipart/form-data" action="{{ route('voyager.seos.store') }}">
            @csrf
            <input type="hidden" name="uri" value="{{ $uri }}">

            <div class="form-group">
                <label for="route">Route</label>
                <input type="text" name="route" id="route" class="form-control" required value="{{ $uri }}"
                    maxlength="120" disabled>
            </div>

            {{-- Title --}}
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $seo->title }}"
                    placeholder="Gold Stock Canada - Bullion Dealer & Refiner">
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" maxlength="160"
                    value="{{ $seo->description }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>

            <hr>

            {{-- Keywords --}}
            <div class="form-group">
                <div>
                    <label for="keywords">Add Keyword</label>
                    <input type="text" name="keywords" id="keywords" class="form-control">
                    <small>Can be splitted as key1, key2, key3...</small>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" onclick="onAddKeywords()">Add Keywords</button>
                    <button type="button" class="btn btn-danger float-right" onclick="onRemoveAllKeywords()">
                        Remove All
                    </button>
                </div>
            </div>

            <hr>

            {{-- Search Input --}}
            <input type="text" id="search" class="form-control" placeholder="Search...">

            <br>

            {{-- Keywords Table --}}
            <table class="table table-hover dataTable no-footer">
                <thead>
                    <tr role="row">
                        <th>Keyword</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seo->keywords as $keyword)
                        <tr role="row" data-keyword-id="{{ $keyword->id }}" data-keyword-value="{{ $keyword->value }}">
                            <td>{{ $keyword->value }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="onRemoveKeyword({{ $keyword->id }})">
                                    <i class="voyager-x"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </form>
    </div>
@endsection

@section('javascript')
    <script>
        $(function() {
            $('#search').on('keyup', function() {
                let value = $(this).val().toString().toLowerCase();
                // display to those rows that match the search query
                let trs = $(`[data-keyword-value]`);
                trs.each(function(index, tr) {
                    let keyword = $(tr).data('keyword-value').toString().toLowerCase();
                    if (keyword.includes(value)) {
                        $(tr).show();
                        console.log(keyword);
                    } else {
                        $(tr).hide();
                    }
                });
            });
        });
    </script>

    <script>
        function onAddKeywords() {
            // get keyword
            const keywords = document.getElementById('keywords').value;

            // check if keywords is empty
            if (!keywords) {
                return;
            }

            // remove white spaces
            keywords.trim();

            // split keywords
            const keywordsArray = keywords.split(',').filter(keyword => keyword.trim() !== '');



            // make post request
            $.ajax({
                url: '/admin/keywords',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    keywords: keywordsArray,
                    uri: '{{ $uri }}'
                },
                success: function(response) {
                    if (response.success) {
                        // add keywords to table from response.added 
                        const table = document.querySelector('.table tbody');
                        response.added.forEach(keyword => {
                            const tr = document.createElement('tr');
                            tr.dataset.keywordId = keyword.id;
                            tr.dataset.keywordValue = keyword.value;

                            const td1 = document.createElement('td');
                            td1.textContent = keyword.value;
                            tr.appendChild(td1);

                            const td2 = document.createElement('td');
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.className = 'btn btn-danger btn-sm';
                            button.onclick = function() {
                                onRemoveKeyword(
                                    keyword.id
                                );
                            };

                            const i = document.createElement('i');
                            i.className = 'voyager-x';
                            button.appendChild(i);
                            td2.appendChild(button);

                            tr.appendChild(td2);
                            table.appendChild(tr);
                        });

                        // clear input
                        document.getElementById('keywords').value = '';
                    }
                }
            });
        }

        function onRemoveKeyword(id) {
            // make delete request
            $.ajax({
                url: `/admin/keywords/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // remove keyword from table
                        const tr = document.querySelector(`tr[data-keyword-id="${id}"]`);
                        tr.remove();
                    }
                }
            });
        }

        function onRemoveAllKeywords() {
            // make confirm dialog
            const isConfirmed = confirm('Are you sure you want to remove all keywords?');
            if (!isConfirmed) {
                return;
            }

            // make delete request
            $.ajax({
                url: '/admin/keywords/all',
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    uri: '{{ $uri }}'
                },
                success: function(response) {
                    if (response.success) {
                        // remove all keywords from table
                        const trs = document.querySelectorAll(`tr[data-keyword-id]`);
                        trs.forEach(tr => {
                            tr.remove();
                        });
                    }
                }
            });
        }
    </script>
@endsection

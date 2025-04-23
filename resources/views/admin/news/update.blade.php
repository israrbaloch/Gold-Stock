divdiv
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Update New Data</h1>

        <form action="{{ route('admin.news.update', $new->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required value="{{ $new->title }}" maxlength="120">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">
                    {{ $new->description }}
                </textarea>
            </div>
            {{-- <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" class="form-control" value="{{ $new->author }}">
            </div> --}}
            <div class="form-group">
                <label for="date">Date</label>

                @php
                    $date = \Carbon\Carbon::parse($new->date)->format('d/m/Y H:i');
                @endphp

                <input type="text" class="form-control datepicker" name="date" id="date"
                    value="{{ $date }}" required>
            </div>

            <div class="form-group">
                <label for="disabled">Is Disabled</label>
                <input type="checkbox" id="disabled" name="disabled" value="1"
                    @if ($new->disabled) checked @endif>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                <img class="header-image" id="image-preview" src="{{ asset('storage/' . $new->image) }}"
                    alt="Current image">
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                // editor.setData(`{!! $new->description !!}`);
            })
            .catch(error => {
                console.error(error);
            });

        // on image selected parse to base64
        document.querySelector('#image').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.querySelector('#image-preview');
                img.src = URL.createObjectURL(this.files[0]);
            }
        });

        $('#date').datetimepicker({
            format: 'DD/MM/YYYY hh:mm'
        });
    </script>
@endsection


@section('css')
    <style>
        .header-image {
            width: 100%;
            height: 500px;
            margin-top: 2rem;
            margin-bottom: 2rem;
            object-fit: cover;
        }
    </style>
@endsection

<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Create New</h1>

        <form action="{{ route('admin.news.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required maxlength="120">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>
            {{-- <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" class="form-control">
            </div> --}}
            <div class="form-group">
                <label for="date">Date</label>
                <input type="text" class="form-control datepicker" name="date" id="date" required>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*" required>
                <img class="header-image" id="image-preview">
            </div>

            <span>This is disabled by default, to avoid publish content without confirm, update the disabled value</span>
            <div class="buttons-container">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
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

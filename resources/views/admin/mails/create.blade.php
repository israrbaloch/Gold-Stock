@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Create Mail Template</h1>

        <form id="form">
            @csrf
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" required maxlength="120">
            </div>

            {{-- Type --}}
            <div class="form-group">
                <label for="type">Type</label>
                <div class="checkbox-group-container">
                    <div class="form-check d-flex">
                        <input type="radio" name="subscription" id="news" value="news" class="form-check-input"
                            required data-depends-on="subject">
                        <label for="news" class="form-check-label">News</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" name="subscription" id="blogs" value="blogs" class="form-check-input"
                            required data-depends-on="subject">
                        <label for="blogs" class="form-check-label">Blogs</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" name="subscription" id="promo" value="promo" class="form-check-input"
                            required data-depends-on="subject">
                        <label for="promo" class="form-check-label">Promotional</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="template">Template</label>
                <select name="template" id="template" class="form-control" required data-depends-on="subscription">
                    <option value="" selected disabled hidden>Select Template</option>
                    @foreach ($templates as $index => $template)
                        <option value="{{ $index }}">{{ $template->_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="properties-container">
            </div>
            <hr>
            <div class="preview-container">
            </div>
            <hr>
            <div class="buttons-container">
                <button type="submit" class="btn btn-primary" data-depends-on="template">
                    Create
                </button>
            </div>

            <div id="errors-container" style="display: none">
                <hr>
                <div id="errors">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/voyager-common.js') }}"></script>
    <script>
        const mailTemplates = @json($templates);
        const mailTemplatesProperties = @json($templateProperties);
        const updateMode = false;
    </script>
    <script type="text/javascript" src="{{ asset('js/voyager-mails.js') }}"></script>
@endsection

@section('css')
    <style>
        .input-container {
            display: flex;
            gap: 0px 0.5rem
        }

        .buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0px 0.5rem
        }

        .checkbox-group-container {
            display: flex;
            gap: 0.5rem;
        }

        .checkbox-group-container label {
            user-select: none;
        }
    </style>
@endsection

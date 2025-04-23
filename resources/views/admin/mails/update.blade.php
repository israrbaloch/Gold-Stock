@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>Update Mail Template</h1>

        <form id="form" onsubmit="onSubmit()">
            @csrf
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" required maxlength="120"
                    value="{{ $mailTemplate->subject }}">
            </div>
            <div class="form-group">
                <label for="subscription">Type</label>
                <div class="checkbox-group-container">
                    <div class="form-check d-flex">
                        <input type="radio" onclick="onTypeChange()" name="subscription" id="news" value="news"
                            class="form-check-input" {{ $mailTemplate->subscription == 'news' ? 'checked' : '' }}>
                        <label for="news" class="form-check-label">News</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" onclick="onTypeChange()" name="subscription" id="blogs" value="blogs"
                            class="form-check-input" {{ $mailTemplate->subscription == 'blogs' ? 'checked' : '' }}>
                        <label for="blogs" class="form-check-label">Blogs</label>
                    </div>
                    <div class="form-check d-flex">
                        <input type="radio" onclick="onTypeChange()" name="subscription" id="promo_users_subscribed"
                            value="promo" class="form-check-input"
                            {{ $mailTemplate->subscription == 'promo' ? 'checked' : '' }}>
                        <label for="promo_users_subscribed" class="form-check-label">Promotional</label>
                    </div>
                </div>
            </div>
            <div class="properties-container">
            </div>
            <hr>
            <div class="preview-container">
            </div>
            <hr>
            <div class="buttons-container">
                <button type="submit" class="btn btn-primary">Update</button>
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
    <script>
        const mailTemplate = @json($mailTemplate);
        const mailTemplateProperties = @json($mailTemplateProperties);
        const updateMode = true;
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

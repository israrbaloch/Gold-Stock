@extends('voyager::master')

@section('page_title', isset($dataTypeContent->id) ? 'Edit Banner' : 'Create Banner')

@section('content')
    <div class="page-content">
        <div class="container">
            @include('components.flash_alerts')
            <form method="POST"
                action="@if (isset($dataTypeContent->id)) {{ route('admin.banners.update', $dataTypeContent->id) }} @else {{ route('admin.banners.store') }} @endif"
                enctype="multipart/form-data">
                @csrf
                @if (isset($dataTypeContent->id))
                    @method('PUT')
                @endif

                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            @if (isset($dataTypeContent->id))
                                Edit Banner
                            @else
                                Create Banner
                            @endif
                        </h3>
                    </div>

                    <div class="panel-body">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $dataTypeContent->title ?? '') }}" required>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control">{{ old('description', $dataTypeContent->description ?? '') }}</textarea>
                        </div>

                        <!-- Banner Type -->
                        <div class="form-group">
                            <label for="type">Banner Type</label>
                            <select name="type" class="form-control">
                                <option value="image" @if (old('type', $dataTypeContent->type ?? 'image') == 'image') selected @endif>Image</option>
                                <option value="text" @if (old('type', $dataTypeContent->type ?? 'image') == 'text') selected @endif>Text</option>
                                <option value="both" @if (old('type', $dataTypeContent->type ?? 'image') == 'both') selected @endif>Both</option>
                            </select>
                        </div>


                        <!-- Image -->
                        <div class="form-group">
                            <label for="image">Banner Image</label>
                            @if (isset($dataTypeContent->image))
                                <img src="{{ Voyager::image($dataTypeContent->image) }}" width="200"
                                    style="margin-bottom:10px;">
                            @endif
                            <input type="file" name="image" class="form-control">
                        </div>

                        {{-- mobile_image --}}
                        <div class="form-group">
                            <label for="mobile_image">Mobile Banner Image</label>
                            @if(isset($dataTypeContent->mobile_image))
                                <img src="{{ Voyager::image($dataTypeContent->mobile_image) }}" width="200" style="margin-bottom:10px;">
                            @endif
                            <input type="file" name="mobile_image" class="form-control">
                        </div>

                        <!-- Button Text -->
                        <div class="form-group">
                            <label for="button_text">Button Text</label>
                            <input type="text" name="button_text" class="form-control"
                                value="{{ old('button_text', $dataTypeContent->button_text ?? '') }}">
                        </div>

                        <!-- Button Link -->
                        <div class="form-group">
                            <label for="button_link">Button Link</label>
                            <input type="url" name="button_link" class="form-control"
                                value="{{ old('button_link', $dataTypeContent->button_link ?? '') }}">
                        </div>

                        <!-- Start Date -->
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="datetime-local" name="start_date" class="form-control"
                                value="{{ old('start_date', isset($dataTypeContent->start_date) ? date('Y-m-d\TH:i', strtotime($dataTypeContent->start_date)) : '') }}">
                        </div>

                        <!-- End Date -->
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="datetime-local" name="end_date" class="form-control"
                                value="{{ old('end_date', isset($dataTypeContent->end_date) ? date('Y-m-d\TH:i', strtotime($dataTypeContent->end_date)) : '') }}">
                        </div>

                        <!-- Position -->
                        <div class="form-group">
                            <label for="position">Position (Sorting Order)</label>
                            <input type="number" name="position" class="form-control"
                                value="{{ old('position', $dataTypeContent->position ?? 0) }}" required>
                        </div>

                        <!-- Alignment -->
                        <div class="form-group">
                            <label for="alignment">Text Alignment</label>
                            <select name="alignment" class="form-control">
                                <option value="left" @if (old('alignment', $dataTypeContent->alignment ?? 'center') == 'left') selected @endif>Left</option>
                                <option value="center" @if (old('alignment', $dataTypeContent->alignment ?? 'center') == 'center') selected @endif>Center</option>
                                <option value="right" @if (old('alignment', $dataTypeContent->alignment ?? 'center') == 'right') selected @endif>Right</option>
                            </select>
                        </div>


                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" @if (isset($dataTypeContent->status) && $dataTypeContent->status == '1') selected @endif>Active</option>
                                <option value="0" @if (isset($dataTypeContent->status) && $dataTypeContent->status == '0') selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <button type="submit"
                            class="btn btn-primary">{{ isset($dataTypeContent->id) ? 'Update' : 'Create' }}</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

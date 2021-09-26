@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add new post</h2>
        <div class="lead">
            Add new post.
        </div>

        <div class="container mt-4">

            <form method="POST" id="save-content-form" data-action="{{ route('posts.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input value="{{ old('title') }}" 
                        type="text" 
                        class="form-control" 
                        name="title" 
                        placeholder="Title" required>

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input value="{{ old('description') }}" 
                        type="text" 
                        class="form-control" 
                        name="description" 
                        placeholder="Description" required>

                    @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <textarea class="form-control"
                        id="tinymce">{{ old('body') }}</textarea>

                    @if ($errors->has('body'))
                        <span class="text-danger text-left">{{ $errors->first('body') }}</span>
                    @endif
                </div>
                

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('posts.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea#tinymce',
            height: 600
        });

        $(document).ready(function() {

            var formId = '#save-content-form';

            $(formId).on('submit', function(e) {
                e.preventDefault();

                var data = $(formId).serializeArray();
                data.push({name: 'body', value: tinyMCE.get('tinymce').getContent()});

                $.ajax({
                    type: 'POST',
                    url: $(formId).attr('data-action'),
                    data: data,
                    success: function (response, textStatus, xhr) {
                        window.location=response.redirectTo;
                    },
                    complete: function (xhr) {
                        
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        var response = XMLHttpRequest;

                    }
                }); 
            });
        });
    </script>
@endsection
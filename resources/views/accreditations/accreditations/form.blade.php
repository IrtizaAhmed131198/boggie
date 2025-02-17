<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('title', 'Title') !!}
                {!! Form::text(
                    'title',
                    null,
                    '' == 'required' ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea(
                    'description',
                    null,
                    '' == 'required'
                        ? ['class' => 'form-control', 'id' => 'summary-ckeditor', 'required' => 'required']
                        : ['class' => 'form-control'],
                ) !!}
            </div>
        </div>

            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('image', 'Image') !!}
                    <input class="form-control dropify" name="image" type="file" id="image"
                        @if ($accreditation->image != '') data-default-file="{{ asset($accreditation->image) }}"
            @else
                required @endif
                        value="{{ asset($accreditation->image) }}">

                </div>
            </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('link', 'Link') !!}
            {!! Form::text(
                'link',
                null,
                '' == 'required' ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'],
            ) !!}
        </div>
    </div>
    <div class="form-actions text-right pb-0">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Dropify plugin
            $('.dropify').dropify();
        });
    </script>

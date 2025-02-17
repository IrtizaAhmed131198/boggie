<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('chapter_id', 'Chapter') !!}
                <select name="chapter_id" class="form-control" id="chapter_id" required>
                    <option value="" disabled> Select Chapter </option>
                    @php
                    $chapters = App\Chapter::where('course_id', '!=', 0)->get();
                    @endphp
                    @foreach($chapters as $val)
                        <option value="{{ $val->id }}" {{ $val->id == $content->chapter_id ? 'selected' : '' }}>{{ $val->chapter_title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('content_title', 'Content Title') !!}
                {!! Form::text('content_title', null, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('content_type', 'Content Type') !!}
                {!! Form::select('content_type', ['link' => 'Link', 'video' => 'Video', 'document' => 'Document'], $content->content_type, ['class' => 'form-control', 'required' => 'required', 'id' => 'content_type']) !!}
            </div>
        </div>

        <div class="col-md-12" id="file-upload-section" style="{{ $content->content_type == 'link' ? 'display: none;' : '' }}">
            <div class="form-group">
                {!! Form::label('content_file', 'Upload File') !!}
                {!! Form::file('content_file', ['class' => 'form-control']) !!}
                @if($content->content_file)
                    <input type="hidden" name="existing_file" value="{{ $content->content_file }}">
                @endif
            </div>
        </div>

        <div class="col-md-12" id="link-input-section" style="{{ $content->content_type == 'link' ? '' : 'display: none;' }}">
            <div class="form-group">
                {!! Form::label('content_link', 'Content Link') !!}
                {!! Form::text('content_link', null, ['class' => 'form-control', 'placeholder' => 'Enter a valid link', 'pattern' => 'https?://.+', 'title' => 'Enter a valid URL']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-actions text-right pb-0">
	{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
<div class="form-group row justify-content-center left_css col-md-12 {{ $errors->has('name') ? 'has-error' : ''}}">

    <div class="col-md-12">

        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

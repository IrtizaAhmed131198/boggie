<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::Label('course_id', 'Select Course:') !!}
                <select name="course_id" class="form-control" id="course_id">
                    <option value="" disabled> Select Course </option>
                    @foreach($course as $val)
                        <option value="{{ $val->id }}" {{ $val->id == $chapter->id ? 'selected' : '' }}>{{ $val->product_title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            	{!! Form::label('chapter_title', 'Chapter Title') !!}
            	{!! Form::text('chapter_title', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            </div>
        </div>
        {{-- <div class="col-md-12">
            <div class="form-group">
            	{!! Form::label('chapter_number', 'Chapter Number') !!}
            	{!! Form::text('chapter_number', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            </div>
        </div> --}}
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

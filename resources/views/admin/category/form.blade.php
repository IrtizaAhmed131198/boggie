<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
            	{!! Form::label('name', 'Name') !!}
            	{!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::Label('course_id', 'Select Course:') !!}
                <select name="type" class="form-control">
                    <option value="" disabled> Select Type </option>
                    <option value="course">Course</option>
                    <option value="other">Other</option>
                </select>
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

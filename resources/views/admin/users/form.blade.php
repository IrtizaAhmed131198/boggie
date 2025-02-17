<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', $users->name ?? '', ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', $users->email ?? '', ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirm Password') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <label>Who Are You?</label>
            <select name="certified" class="form-control" value="{{ old('certified') }}" id="" required="">
                {{-- <option value="">{{$users->certified}}</option> --}}
                <option value="">--Select--</option>
                <option value="paramedic" {!! $users->certified == 'paramedic' ? 'selected' : '' !!}>Paramedic</option>
                <option value="emts" {!! $users->certified == 'emts' ? 'selected' : '' !!}>EMTs</option>
                <option value="first_responder" {!! $users->certified == 'first_responder' ? 'selected' : '' !!}>First-Responder</option>
            </select>
            @if ($errors->has('certified'))
                <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('certified') }}</small>
            @endif
        </div>

    </div>
</div>

<div class="form-actions text-right pb-0">
    {!! Form::submit(str_contains(\Request::getRequestUri(), 'create') ? 'Create' : 'Update', ['class' => 'btn btn-primary']) !!}
</div>

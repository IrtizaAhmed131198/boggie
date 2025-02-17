<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="iframe">link</label>
                <textarea id="iframe" name="link" class="form-control" rows="4" required>{{ $youtube->link }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="form-group text-right pb-0">
    {!! Form::submit(str_contains(\Request::getRequestUri(), 'create') ? 'Create' : 'Update', ['class' => 'btn btn-primary']) !!}

</div>

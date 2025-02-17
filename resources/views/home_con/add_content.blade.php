<!-- @extends('layouts.main')

@section('content')

<form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>

@endsection -->
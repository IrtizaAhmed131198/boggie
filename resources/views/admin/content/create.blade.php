@extends('layouts.app')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Content</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Content</li>
                    <li class="breadcrumb-item active">Create New Content</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
            <a class="btn btn-info mb-1" href="{{ url('/admin/content') }}">Back</a>
        </div>
    </div>
</div>

<div class="content-body">
  <section id="basic-form-layouts">
      <div class="row match-height">
          <div class="col-md-7">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title" id="basic-layout-form">Edit Content #{{ $page->id }}</h4>
                      <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                      <div class="heading-elements">
                          <ul class="list-inline mb-0">
                              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                              <li><a data-action="close"><i class="ft-x"></i></a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="card-content collapse show">
                        <div class="card-body">
                            {!! Form::open(['url' => '/admin/content', 'files' => true]) !!}

                            @include ('admin.content.form')

                            {!! Form::close() !!}
                        </div>
                  </div>
              </div>
          </div>
          <div class="col-md-5">
              <div class="card">
                  <div class="card-header">
                      <h4 class="card-title" id="basic-layout-colored-form-control">Information</h4>
                      <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                      <div class="heading-elements">
                          <ul class="list-inline mb-0">
                              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                              <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                              <li><a data-action="close"><i class="ft-x"></i></a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="card-content collapse show">
                      <div class="card-body">
                          <div class="card-text">
                              @if ($errors->any())
                              <ul>
                                @foreach ($errors->all() as $error)
                                  <li class="alert alert-danger">
                                      {{ $error }}
                                  </li>
                                @endforeach
                              </ul>
                              @endif
                              @if(Session::has('message'))
                              <ul>
                                  <li class="alert alert-success">
                                      {{ Session::get('message') }}
                                  </li>
                              </ul>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
@endsection

@push('js')
    <script>
        document.getElementById('content_type').addEventListener('change', function() {
            var contentType = this.value;
            var fileSection = document.getElementById('file-upload-section');
            var linkSection = document.getElementById('link-input-section');

            if (contentType === 'link') {
                fileSection.style.display = 'none';
                linkSection.style.display = 'block';
            } else {
                fileSection.style.display = 'block';
                linkSection.style.display = 'none';
            }
        });

        // Trigger change event on page load to set initial visibility
        document.getElementById('content_type').dispatchEvent(new Event('change'));
    </script>
@endpush

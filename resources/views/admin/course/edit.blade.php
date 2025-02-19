@extends('layouts.app')
@push('before-css')
    <link rel="stylesheet" href="{{asset('plugins/vendors/dropify/dist/css/dropify.min.css')}}">
@endpush
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Pages Content</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Course</li>
                    <li class="breadcrumb-item active">Edit Course</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
            <a class="btn btn-info mb-1" href="{{ url('/admin/course') }}">Back</a>
        </div>
    </div>
</div>

<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Edit Page #{{ $page->id }}</h4>
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
                            {!! Form::model($product, [
                                'method' => 'PATCH',
                                'enctype' => 'multipart/form-data',
                                'url' => ['/admin/course', $product->id],
                                'files' => true
                            ]) !!}

                            @include ('admin.course.form', ['submitButtonText' => 'Update'])

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
<script src="{{asset('js/jquery.repeater.min.js')}}"></script>

  <script src="{{asset('plugins/vendors/dropify/dist/js/dropify.min.js')}}"></script>
  <script>
      $(function() {
          $('.dropify').dropify();
      });

      !function(e,t,r){"use strict";r(".repeater-default").repeater(),r(".file-repeater, .contact-repeater").repeater({show:function(){r(this).slideDown()},hide:function(e){confirm("Are you sure you want to remove this item?")&&r(this).slideUp(e)}})}(window,document,jQuery);

  </script>

<script>
      function getInputValue(id , a)
        {
            var e = a;
            $.ajax({
            url: "{{ route('pro-img-id-delet')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    id:id
                },
                success:function(response){

                    if(response.status){
                        $(e).parent().remove();
                    }
                    else{
                    }
                },
                });

        }

        function getval(sel)
        {
            var globelsel = sel;
            let value = sel.value;

            // alert(value);

            $.ajax({
            url: "{{ route('get-attributes')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    value:value
                },
                success:function(response){
                    $(globelsel).parent().parent().find('.value').html('');
                    if(response.status){
                        var html = '';
                        for(var i = 0; i < response.message.length; i++){
                            html += '<option value="'+response.message[i].id+'">'+response.message[i].value+'</option>';
                        }
                        $(globelsel).parent().parent().find('.value').html(html);
                    }
                    else{

                    }
                },
                });
        }

        function deleteAttr(product_att_id, a){
            var e = a;
            var id = product_att_id;
            $.ajax({
                url: "{{ route('delete.product.variant')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    id:id
                },
                success:function(response){
                    if(response.status){
                        $(e).parent().parent().parent().parent().remove();

                    }
                    else{

                    }
                },
            });
        }
  </script>
@endpush

@php
    $banners = \Illuminate\Support\Facades\DB::table('banners')->get();
@endphp

@extends('layouts.main')

@section('css')
    <style>
        .real-world {
            background-image: url('{{ asset($banners[0]->image) }}');
        }
        .traning-info-img.non-border {
    border: none;
}
    </style>
@endsection


@section('content')
    <section class="real-world inner-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="shop-stragety">
                        <h2>{{ $page->name ?? 'YouTube' }}</h2>
                        @if (Auth::user()->id)
                            <a href="{{ route('account') }}" class="btn orange-btn org-btn">Dashboard</a>
                        @else
                            <a href="{{ route('signup') }}" class="btn orange-btn org-btn">Sign Up Now</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="upcoming-traning">
        <div class="container">
            <div class="row">
                @foreach ($youtube as $val)
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="traning-info">
                            <div class="traning-info-img non-border">
                                {!! $val->link !!}
                            </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection

@section('css')
    <style>

    </style>
@endsection

@section('js')
    <script type="text/javascript"></script>
@endsection

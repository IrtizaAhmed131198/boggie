
@extends('layouts.main')
@section('content')

<section class="real-world">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-stragety">
                    <h2>{!! $page->sections[0]->value !!}</h2>
                    <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                        been the industry's standard dummy text ever since the 1500s, when an unknown printer took
                        a galley of type and scrambled it to make a type specimen book.</p>
                    <a href="#" class="btn orange-btn org-btn">Sign Up Now</a> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="staff-pg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                {!! $page->sections[1]->value !!}
            </div>
        </div>
    </div>
</section>


<section class="stay-touch">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="touch-form">
                    <h4>Stay in touch!</h4>
                    <div class="mail-form">
                        <form>
                            <input type="email" name="email" value="Enter Your Email" class="form-control" required="">
                            <input type="submit" value="Subscribe"></input>
                        </form>
                    </div>
                    <div class="need-help">
                        <div class="touch-main">
                            <h6>Need help?</h6>
                        </div>
                        <div class="contact-link">
                            <a href="#" class="btn contact-btn">Contact us </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('css')

@endsection
@endsection
@section('js')
<script type="text/javascript">

</script>
@endsection

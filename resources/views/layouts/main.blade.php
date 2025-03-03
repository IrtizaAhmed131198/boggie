<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/sriracha" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/fullpage.js/dist/fullpage.min.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">

    <title>Boogie!</title>
    <!-- <style>
        canvas { border: 1px solid #ccc; cursor: grab; }
        #container { text-align: center; margin-top: 20px; }
    </style> -->
    <style>
        a.filepond--credits {
            display: none !important;
        }
    </style>

</head>

<body>


    @include('layouts/front.header')



    @yield('content')


    @include('layouts/front.footer')
    <!-- ============================================================== -->
    <!-- All SCRIPTS ANS JS LINKS IN BELOW FILE -->
    <!-- ============================================================== -->
    @include('layouts/front.scripts')
    @yield('js')

    @if (Session::has('message'))
    <script type="text/javascript">
        toastr.success("{{ Session::get('message') }}");
    </script>
    @endif

    @if (Session::has('success'))
    <script type="text/javascript">
        toastr.success("{{ Session::get('success') }}");
    </script>
    @endif

    @if (Session::has('error'))
    <script type="text/javascript">
        toastr.error("{{ Session::get('error') }}");
    </script>
    @endif



</body>

</html>
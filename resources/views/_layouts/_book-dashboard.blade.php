<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TNS5ZTC');</script>
<!-- End Google Tag Manager -->

    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::to('/') }}/assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('/') }}/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('/') }}/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ URL::to('/') }}/assets/images/favicon/site.webmanifest">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$config->company_name}} Booking Area</title>

    <!-- Fonts -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'crossorigin='anonymous'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="{{ asset('/assets/dist/book/styles.css') }}" rel="stylesheet" type="text/css">

    <style>

        .header-banner {
            background-size: cover;
        }

        @media screen and (max-width: 768px){
                .header-banner {
                    background-size: contain !important;
                }
        }



    </style>

    @yield('styles')

    @yield('header')

</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNS5ZTC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <div id="app">

        @include('book._partials._side-nav')

        <main id="mainContent">
            <header class="header-nav header-banner" style="
            height: 300px;
            width: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-image: url(&quot;{{ asset('/assets/images/public/general') }}/{{$event->filename}}&quot;);
            ">
                <div class="js-side-nav-collapse">
                    <i class="line"></i>
                    <i class="line"></i>
                    <i class="line"></i>
                </div>
            </header>

            <div class="content relative">
                <div class="col-12 relative">
                    @yield('content')
                </div>
            </div>
        </main>

    </div>
    <script src="{{ asset('/assets/dist/book/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    @yield('scripts')

</body>
</html>

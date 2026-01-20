<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="register-html">
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
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} {{ ucfirst(config('multiauth.prefix')) }}</title>

    <!-- Fonts -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'crossorigin='anonymous'>
    <link href="{{ asset('/assets/dist/book/styles.css') }}" rel="stylesheet" type="text/css">

    @yield('styles')
    <style>
         body, html {

            width: 100%;
            height: 100%;
            float: left;

        }


        .logo-box{
            height: 100vh;

        }

        @media screen and (max-width: 767px){
            .logo-box{
                height: 30vh;

            }
        }

    </style>



    @if(isset($wallpaper->filename))
        <style>
            body, html {
            background:url({{ asset('/assets/images/public/general/') }}/{{$wallpaper->filename}});
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;

        }

        </style>
    @endif



</head>

<body  class="register-body">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNS5ZTC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



    <main class="container-fluid">
        @yield('content')
    </main>

    <script src="{{ asset('/assets/dist/admin/scripts.js') }}"></script>
    @yield('scripts')


</body>
</html>

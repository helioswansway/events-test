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

    <title>{{ config('app.name', 'Laravel') }} {{ ucfirst(config('multiauth.prefix')) }}</title>

    <!-- Fonts -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'crossorigin='anonymous'>
    <link href="{{ asset('/assets/dist/book/styles.css') }}" rel="stylesheet" type="text/css">

    @yield('styles')
    <style>
        body, html {
            background: #FFF;

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


</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNS5ZTC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <main class="container-fluid">
        <div class="row">
            <div class="col-lg-6 login-panel logo-box py-5 d-flex justify-content-center align-items-center"
                @if(isset($wallpaper->filename))
                    style="
                            background:url({{ asset('/assets/images/public/general/') }}/{{$wallpaper->filename}}) no-repeat center center / cover;
                        "
                    @endif
                >

                @if (Route::is('book.login'))
                    <div class="row text-center">
                        <span class="block"><img src="{{asset('assets/images/public/general/')}}/{{$config->filename_contrast}}" alt="" width="300"></span>
                        <span class="block text-white fs-300 mt-4 uppercase"> Welcome Back</span>
                    </div>
                @endif
            </div>

            <div class="col-lg-6 bg-white py-5 d-flex align-items-center">

                @yield('content')
            </div>
        </div>
    </main>

    <script src="{{ asset('/assets/dist/admin/scripts.js') }}"></script>
    @yield('scripts')


</body>
</html>

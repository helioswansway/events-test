<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

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
    <link href="{{ asset('/assets/dist/admin/styles.css') }}" rel="stylesheet" type="text/css">

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
                height: 50vh;
            }
        }

    </style>

</head>
<body>
    <main class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-5 exec-login-panel bg-brand logo-box py-5 d-flex justify-content-center align-items-center"
                @if(isset($wallpaper->filename))
                    style="
                            background:url({{ asset('/assets/images/public/general/') }}/{{$wallpaper->filename}}) no-repeat left center / cover;
                        "
                @endif
            >
                {{-- <div class="row text-center">
                    <span class="block"><img src="{{ asset('/assets/images/logo.png') }}" alt=""></span>
                    <span class="block text-white fs-300 mt-4 uppercase"> Welcome Back</span>
                </div> --}}
            </div>

            <div class="col-lg-6 col-md-7 bg-white py-5 d-flex align-items-center">
                @yield('content')
            </div>

        </div>
    </main>

    <script src="{{ asset('/assets/dist/admin/scripts.js') }}"></script>
    @yield('scripts')
</body>
</html>

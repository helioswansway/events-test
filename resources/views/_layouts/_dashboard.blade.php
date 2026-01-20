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

    <title>{{$config->company_name}} Events Management Area</title>

    <!-- Fonts -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'crossorigin='anonymous'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <link href="{{ asset('/assets/dist/admin/styles.css') }}" rel="stylesheet" type="text/css">
    @yield('head')
    @yield('styles')

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNS5ZTC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    @if (auth('admin')->user()->mobile == "")
        <div class="pop-up-wrapper show-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 bg-white shadow ">
                        <div class="s-card ">
                            <div class="s-card-header row bg-info text-white border-0">Please provide us with a valid mobile number</div>
                            <div class="s-card-body row px-2">
                                <form action="{{route('admin.update-account', auth('admin')->user()->id)}}" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="job_title" value="{{auth('admin')->user()->job_title}}">
                                    <input type="hidden" name="name" value="{{auth('admin')->user()->name}}">
                                    <input type="hidden" name="email" value="{{auth('admin')->user()->email}}">
                                    <input type="hidden" name="update_mobile" value="1">
                                    @csrf @method('patch')
                                    <div class="bold">
                                        <label for="mobile">Mobile Number<span class="text-danger">*</span></label>
                                        <input type="number" name="mobile" value="{{old('mobile')}}" class="form-control form-control-lg" required>
                                        @if ($errors->has('mobile'))
                                            <div class="text-danger" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-3 mb-2">
                                        <button type="submit" name="button" class="btn btn-action brother block">Submit Mobile <i class="fa fa-angle-double-right"></i></button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif

    <div class="pop-up-wrapper-spin d-flex justify-content-center hide">
        <div class="align-self-center text-center">
            <p class="text-white bold"> Please be patient, your request is being processed! </p>
            <i class="fas fa-spinner fa-spin fs-300 text-white"></i>
        </div>
    </div>

    <div id="app">
        @include('admin._partials._side-nav')

        <header class="header-nav shadow-sm">

            {{-- <div class="js-side-nav-collapse">
                <i class="line"></i>
                <i class="line"></i>
                <i class="line"></i>
            </div> --}}

            <ul class="basic-ul user-nav float-end">
                <li class="pl-3">
                    @guest('admin')
                        <a class="nav-link" href="{{route('admin.login')}}">{{ ucfirst(config('multiauth.prefix')) }} Login</a>
                    @else

                        @if (auth('admin')->user()->filename == "")
                            <a href="javascript:void(0);" class="js-user-nav">
                                <i class='fas fa-user-alt mr-2'></i> {{ auth('admin')->user()->name }} <i class="fa fa-angle-down"></i>
                            </a>
                        @else
                            <a href="javascript:void(0);" class="js-user-nav">
                                <img src="{{asset('assets/images/admin/general/')}}/{{auth('admin')->user()->filename}}" alt=""  width="30" title="User avatar">
                                    {{ auth('admin')->user()->name }} <i class="fa fa-angle-down"></i>
                            </a>
                        @endif


                        <ul class="sub-menu js-sub-menu js-dropdown-menu">
                            @admin('super-admin,admin')
                                <li><a href="{{route('admin.index')}}"><i class='fas fa-angle-double-right'></i> Admins</a></li>
                            @endadmin
                            @admin('super')
                                <li><a href="{{ route('admin.roles') }}"><i class='fas fa-angle-double-right'></i> Roles</a></li>
                            @endadmin
                            <li><hr></li>

                            <li><a href="{{url('/dashboard/account')}}"> <i class="fas fa-address-card"></i>  Account</a></li>

                            <li><hr></li>

                            <li>
                                <a class="text-danger" href="/admin/logout" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    <i class="fas fa-power-off"></i>  {{ __('Logout') }}
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>

                    @endguest

                </li>
            </ul>
        </header>

        <div class="content relative">
            @yield('content')
        </div>

    </div>
    <script src="{{ asset('/assets/dist/admin/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    @yield('scripts')

    <script>
        /** TO DISABLE PRINT SCREEN **/
        document.addEventListener('keyup', (e) => {
            if (e.key == 'PrintScreen') {
                navigator.clipboard.writeText('');

            }
        });

        /** TO DISABLE PRINTS WHIT CTRL+P **/
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key == 'p') {
                e.cancelBubble = true;
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        });



    </script>

</body>
</html>

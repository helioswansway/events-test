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

    <title>{{$config->company_name}} Exec Management Area</title>

    <!-- Fonts -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'crossorigin='anonymous'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    {{-- <link href="{{ asset('/assets/dist/exec/styles.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('/assets/dist/admin/styles.css') }}" rel="stylesheet" type="text/css">
    @yield('head')
    @yield('styles')

</head>
<body>
    @if (auth('exec')->user()->mobile == "")
        <div class="pop-up-wrapper show-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 bg-white shadow ">
                        <div class="s-card ">
                            <div class="s-card-header row bg-info text-white border-0">Please provide us with a valid mobile number</div>
                            <div class="s-card-body row px-2">
                                <form action="{{route('exec.account.update')}}" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="name" value="{{auth('exec')->user()->name}}">
                                    <input type="hidden" name="email" value="{{auth('exec')->user()->email}}">
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

        @include('exec._partials._side-nav')

            <header class="header-nav shadow-sm">
                <ul class="basic-ul user-nav float-end">
                    <li class="pl-3">
                        @guest('exec')
                            <a class="nav-link" href="{{route('exec.login')}}">{{ ucfirst(config('multiauth.prefix')) }} Login</a>
                        @else

                            @if (auth('exec')->user()->filename == "")
                                <a href="javascript:void(0);" class="js-user-nav">
                                    <img src="{{asset('assets/images/')}}/avatar.jpg" alt="" style="width:30px; height: auto; border-radius:50px" class="img-fluid mr-2 border " title="You Avatar"> {{ auth('exec')->user()->name }} <i class="fa fa-angle-down"></i>
                                </a>
                            @else
                                <a href="avascript:void(0);" class="js-user-nav">
                                    <img src="{{asset('assets/images/public/general/')}}/{{auth('exec')->user()->filename}}" alt="" style="width:30px; height: auto; border-radius:50px" class="img-fluid mr-2 border"   title="{{auth('exec')->user()->name}}">
                                    {{ auth('exec')->user()->name }} <i class="fa fa-angle-down"></i>
                                </a>
                            @endif

                            <ul class="sub-menu js-sub-menu js-dropdown-menu">
                                @admin('super-admin,owner')
                                    <li><a href="/exec/show{{-- route('admin.show') --}}"><i class='fas fa-angle-double-right'></i> Admins</a></li>
                                @endadmin

                                <li><a href="{{ route('exec.account') }}"> <i class="fas fa-address-card"></i>  Account</a></li>

                                <li><hr></li>

                                <li>
                                    <a class="text-danger" href="/exec/logout" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                       <i class="fas fa-power-off"></i>  {{ __('Logout') }}
                                    </a>
                                </li>

                                <form id="logout-form" action="{{ route('exec.logout') }}" method="POST" style="display: none;">
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
    <script src="{{ asset('/assets/dist/exec/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    @yield('scripts')

</body>
</html>

@extends('_layouts._login')
{{--@extends('multiauth::layouts.app')--}}
@section('content')
<div class="container text-dark">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="s-card shadow">
                <h1 class="s-card-header bg-brother fs-110"><i class="fa fa-lock"></i> Login</h1>

                <div class="s-card-body border-0 px-3">

                    @if(Session::get('success'))
                        <div class="alert alert-success js-display-message rounded-0">
                            <i class='far fa-laugh'></i> {{session('success')}}
                            <div class="js-close">X</div>
                        </div>
                    @endif



                    <form method="POST" action="{{ route('admin.login') }}" aria-label="{{ __('Admin Login') }}">
                        @csrf

                        <div class="form-group relative">
                            <label for="email" class="bold">{{ __('E-Mail Address') }}</label>

                            <input id="email" type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group relative">
                            <label for="password" class="bold">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            <i class="fas fa-eye js-toggle-password fs-150"></i>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div class="form-group my-3">
                            <div class="form-check px-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                        </div>

                        <div class="form-group ">
                            <div class="row">
                                <div class="col-lg-6 text-start">
                                    <button type="submit" class="btn btn-default brand">
                                        {{ __('Login') }} <i class="fa fa-angle-double-right"></i>
                                    </button>
                                </div>

                                <div class="col-lg-6 text-end">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                                            <i class="fas fa-lock-open"></i>  {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

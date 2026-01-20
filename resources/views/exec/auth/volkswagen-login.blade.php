@extends('_layouts._exec-login')

@section('content')
<div class="container text-dark">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="s-card shadow-sm">
                <h1 class="s-card-header bg-brother fs-110"><i class="fa fa-lock"></i> Exec Login</h1>

                <div class="s-card-body border-0 px-0 py-1">
                    <form method="POST" action="{{ route('exec.login') }}" aria-label="{{ __('Exec Login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="col bold">{{ __('E-Mail Address:') }} <span class="text-danger">*</span></label>

                            <div class="col-12">
                                <input id="email" autocomplete="off" type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"
                                    required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col bold">Password: <span class="text-danger">*</span></label>

                            <div class="col-12">
                                <input id="password" autocomplete="off"  type="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                    required> @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span> @endif
                            </div>
                        </div>


                        <div class="form-group my-3">
                            <div class="col-12 px-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group px-2">
                            <div class="row">
                                <div class="col-lg-6 text-start">
                                    <button type="submit" class="btn btn-default brand">
                                        {{ __('Login') }} <i class="fa fa-angle-double-right"></i>
                                    </button>
                                </div>

                                <div class="col-lg-6 text-end">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('exec.password.request') }}">
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

@extends('_layouts._exec-login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="s-card shadow text-dark">
                    <h1 class="s-card-header bg-brother fs-110">
                        Exec Reset Password
                        <a href="/exec" class="float-right btn btn-sm btn-border sister">Login <i class="fas fa-sign-in-alt"></i></a>
                    </h1>

                    <div class="s-card-body border-0 px-0 py-1">

                        <div class="px-3">
                            <div class="p-3 alert-warning lighter rounded bold mb-3">
                                Your password  needs to have a minimum of: <br>
                                10 characters, have a number, special character, uppercase and lowercase.
                            </div>
                        </div>

                        <form method="POST" action="{{ route('exec.password.request') }}" aria-label="{{ __('Exec Reset Password') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group ">
                                <label for="email" class="col-12 bold">{{ __('E-Mail Address') }}</label>

                                <div class="col-12">
                                    <input id="email" type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}"
                                        required autofocus> @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span> @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-12 bold">{{ __('Password') }}</label>

                                <div class="col-12">
                                    <input id="password" type="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                        required> @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span> @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="password-confirm" class="col-12 bold">{{ __('Confirm Password') }}</label>

                                <div class="col-12">
                                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group my-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-default sister">
                                        {{ __('Reset Password') }} <i class="fa fa-angle-double-right"></i>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

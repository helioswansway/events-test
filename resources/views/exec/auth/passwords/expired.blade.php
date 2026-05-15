@extends('_layouts._login')
@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-10">



            <div class="s-card shadow text-dark mt-5">
                <h1 class="s-card-header px-3 fs-150">Reset Password</h1>

                <div class="s-card-body border-0 px-3 fs-110">

                    <div class="p-3 alert-warning lighter rounded bold mb-3">
                        Your password have expired, please reset a new one.
                        <br>
                        It needs to contain a minimum of 10 characters, have a number, special character, uppercase and lowercase.
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form method="POST" action="{{ route('exec.password.updated') }}" aria-label="{{ __('Admin Reset Password' ) }}" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="form-group ">
                                <label for="email" class="col-12 bold">{{ __('E-Mail Address') }}</label>

                                <div class="col-12">
                                    <input id="email" type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{auth('exec')->user()->email}}" disabled>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback fs-100" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-12 bold">{{ __('Password') }}</label>

                                <div class="col-12">
                                    <input id="password" type="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback fs-100" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="password-confirm" class="col-12 bold">{{ __('Confirm Password') }}</label>

                                <div class="col-12">
                                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback fs-100" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group mb-0">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-default sister">
                                        {{ __('Reset Password') }} <i class="fa fa-angle-double-right"></i>
                                    </button>
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

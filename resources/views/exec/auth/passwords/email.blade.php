@extends('_layouts._exec-login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="s-card shadow text-dark">
                <h1 class="s-card-header bg-brother fs-110">
                    <i class="fa fa-unlock"></i> Reset Exec Password

                    <a href="/exec" class="float-right btn btn-sm btn-border sister">Login <i class="fas fa-sign-in-alt"></i></a>
                </h1>

                <div class="s-card-body border-0 p-2">
                    @if (session('status'))
                        <div class="col-12">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>

                    @endif

                    <form method="POST" action="{{ route('exec.password.email') }}" aria-label="{{ __('Reset Exec Password') }}">
                        @csrf

                        <div class="form-group ">
                            <label for="email" class="col-12 bold">{{ __('E-Mail Address') }}</label>

                            <div class="col-12">
                                <input id="email" type="email" class="form-control form-control-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"
                                    required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group my-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-default sister">
                                    {{ __('Send Password Reset Link') }} <i class="fa fa-angle-double-right"></i>
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

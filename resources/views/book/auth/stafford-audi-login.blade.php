@extends('_layouts._book-login')
{{--@extends('multiauth::layouts.app')--}}

@section('styles')
    <style>
            .btn-audi{
                background: #f50537 !important;
                color: #FFFFFF !important;
                border-radius: 0px;
            }

            .btn-audi:hover{
                color: #FFF !important;
            }

            .btn-login {
                border-radius: 0px;
                background: #FFF !important;
                border: 1px solid #000 !important;
                color: #000000 !important;
            }

            .btn-login:hover {
                border: 1px solid #000 !important;
            }


    </style>

@endsection

@section('content')
<div class="container text-dark">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="s-card shadow-sm" style="background: #f4f5f7; border: 1px solid #ffffff">

                <div class="s-card-body p-5 border-0">
                    <form method="POST" action="{{ route('book.login') }}" aria-label="{{ __('Admin Login') }}">
                        @csrf
                        <input  type="hidden" value="Rreenn84?he" name="password">

                        <div class="row">
                            <label for="customer_number" class="col bold">Enter your unique code</label>
                            <div class="col-12">
                                <input id="customer_number" type="text" class="form-control form-control-lg   {{ $errors->has('customer_number') ? ' is-invalid' : '' }}" name="customer_number" value="{{ old('customer_number') }}" autocomplete="off" required autofocus>
                                @if ($errors->has('customer_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('customer_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group mt-3">
                            <div class="row align-items-center">
                                <div class="col-md-6 ">
                                    <button type="submit" name="login_step_1" class="btn btn-action btn-audi brand block fs-130"> <i class="fas fa-user-circle mr-2 "></i> Sign in  </button>
                                </div>

                                <div class="mob-space my-1"></div>

                                <div class="col-md-6 mob-text-center text-end fs-110 ">
                                    <a href="{{route('book.reset.code.form')}}" name="reset_code_step_1" class="text-sister bold ms-1"><i class="fa-solid fa-arrows-rotate me-1"></i> Reset Unique Code  </a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-10">
            <div class="s-card shadow-sm mt-4" style="background: #f8f8f8; border: 1px solid #f1f1f1">
                <div class="s-card-body p-3 border-0">
                    <div class="col text-center fs-110">
                        Don't have a unique code? Don't worry you can get one through our registration form. <a href="{{route('book.register.audi')}}" name="register_from_login_page" class="text-sister bold ms-1"> Register here  </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script>

</script>

@endsection

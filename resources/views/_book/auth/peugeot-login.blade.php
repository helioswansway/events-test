@extends('_layouts._book-login')
{{--@extends('multiauth::layouts.app')--}}

@section('styles')
    <style>
            .btn-honda{
                background: #0074e8 !important;
                color: #FFFFFF !important;
                border-radius: 0px;
            }

            .btn-honda:hover{
                background: #000000 !important;
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
                            <div class="row">
                                <div class="col text-start">
                                    <button type="submit" class="btn btn-action btn-honda block fs-130"> <i class="fas fa-user-circle mr-2 "></i> Sign in  </button>
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


@section('scripts')

<script>

</script>

@endsection

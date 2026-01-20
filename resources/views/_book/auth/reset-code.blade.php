@extends('_layouts._reset-code')
{{--@extends('multiauth::layouts.app')--}}
@section('content')
<div class="container text-dark">

    <div class="row justify-content-center">
        <div class="my-3"></div>
        <img src="{{asset('assets/images/public/general/')}}/{{$config->filename}}" alt="Swansway Group Events" style="width: 250px;"/>

        <div class="my-3"></div>

        <div class="col-lg-10 mob-px-0">
              <div class="s-card shadow-sm" style="background: #eef0f7; border: 1px solid #ffffff">
                <div class="s-card-body p-3 border-0">

                    <form method="POST" action="{{ route('book.reset.code') }}">
                        @csrf
                        <input  type="hidden" value="Rreenn84?he" name="password">

                        @if(Session::has('error_code'))
                            <div class="text-danger fs-110 mb-3">
                                {!!Session::get('error_code')!!}
                            </div>
                        @endif

                        <div class="row">
                            <label for="email" class="col bold">Enter your Email:</label>
                            <div class="col-12">
                                <input id="email" type="email" class="form-control form-control-lg   {{ $errors->has('customer_number') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autocomplete="off" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="row align-items-center">
                                <div class="col-12 ">
                                    <button type="submit" class="btn btn-action brand block fs-120"> Reset Code  <i class="fa fa-angle-double-right"></i></button>
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

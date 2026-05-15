@extends('_layouts._book-register')
{{--@extends('multiauth::layouts.app')--}}
@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-lg-6 p-5">
            <div class="s-card shadow-lg bg-white rounded">
                <div class="s-card-body pt-3 border-0">
                    <div class="s-card-header border-0">
                        <div class="row display-4 mb-0 border-0">
                            <div class="col text-center">
                                Use code <span class="rounded fs-110 text-info mx-2 alert-info lighter px-2 py-1 mob-block" id="value">{{$customer->customer_number}}</span> to login.
                                <br><br>
                                {{-- <input type="text" value="{{$customer->customer_number}}" id="copyValue" style=""> --}}
                                {{-- <button id="copyValue" class="btn btn-default sister mob-block js-copy-value">Copy to Clipboard</button> --}}
                                {{-- <a href="javascript:void(0)" class="btn btn-default sister mob-block">Copy to Clipboard</a> --}}
                                <div class="mt-4 border-top pt-3">
                                    @if($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    @endif
                                    <form method="POST" action="{{ route('book.login') }}" aria-label="{{ __('Admin Login') }}">
                                        @csrf
                                        <input  type="hidden" value="Rreenn84?he" name="password">
                                        <input id="customer_number" type="hidden"  name="customer_number" value="{{$customer->customer_number}}">
                                        {{-- <a href="{{route('book.login')}}" class="btn btn-action brand mob-block"><i class="fas fa-user-circle mr-1 fs-120 "></i> Login</a> --}}
                                        <a href="javascript:void(0)" id="copyValue" name="copy_to_clipboard" class="btn btn-action sister mob-block js-copy-value me-3"><i class="fa-regular fa-copy mr-1 fs-120"></i> Copy to Clipboard</a>

                                        <button type="submit"  name="login_from_clipboard"  class="btn btn-action brand mob-block"><i class="fas fa-user-circle mr-1 fs-120"></i> Sign in</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')

<script>

    // Function to copy customer code to Clipboard
    function copyValue(htmlElement) {
        if(!htmlElement) {
            return;
        }

        let elementValue = htmlElement.innerText;
        let inputValue = document.createElement('input');
        inputValue.setAttribute('value', elementValue);
        document.body.appendChild(inputValue);
        inputValue.select()

        document.execCommand('copy')
        inputValue.parentNode.removeChild(inputValue)

    }

    document.querySelector('#copyValue').onclick = function () {
        copyValue(document.querySelector('#value'))
    }



    $(function(){


       $('.js-event-wrapper').hide();
       $('.js-register-details').hide();

       $('#dealership_code').change(function(){
            var dealership_code = $(this).val();

              $.ajax({
                    url: '/book/register/fetchEvents?dealership_code=' + dealership_code,

                        success:function(response){
                        //console.log(response)
                        $('.js-event-wrapper').fadeIn();
                        $('#event_id').html(response);

                    }
            });

        });

        $('#event_id').change(function(){
            $('.js-register-details').fadeIn();
        })




    });

</script>

@endsection

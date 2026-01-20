@extends('_layouts._book-register')

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
    @include('book.inc._messages')
    <div class="row justify-content-center py-5">
        <div class="col-lg-8 p-5">
            <div class="s-card">
                <form action="{{route('book.register.customer')}}" enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}
                    {{ method_field('POST') }}
                    <input type="hidden" name="utm_url" value="{{URL::full()}}">

                    <div class="s-card shadow-lg bg-light">
                        <div class="s-card-header pb-0 border-0 " style="background: #000000;">
                            <div class="row display-4 mb-0">
                                <div class="col mob-full-with mob-text-center">
                                    <span class="fs-100 text-white"  style="padding-top:5px;">Select Your Event: </span>
                                    <div class="space-10 show-mobile"></div>
                                    <a href="{{route('book.audi')}}" class="btn btn-login btn-default px-2 sister fs-60 mob-block float-end"> Login <i class="fas fa-angle-double-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="s-card-body border-0  p-0">
                            <div class="col">
                                <div class="row s-card-row border-0  py-3">
                                    <div class="col-lg-12 bold ">
                                        <label for="dealership_code">Dealership: <span class="text-danger">*</span></label>
                                        <select name="dealership_code" id="dealership_code" class=" form-control form-control-lg" required>
                                            <option value="">--Select a dealership--</option>
                                            @foreach($dealerships as $dealership)
                                                <option value="{{$dealership->code}}">{{$dealership->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row s-card-row border-0  py-3 js-event-wrapper">
                                    <div class="col-lg-12 bold">
                                        <label for="event_id">Event: <span class="text-danger">*</span></label>
                                        <select name="event_id" id="event_id" class=" form-control form-control-lg" required></select>
                                    </div>
                                </div>

                                <div class="js-register-details">
                                    <div class="row">
                                        <div class="s-card-header text-white border-0 px-3" style="background: #000;"> Enter Your Details:</div>
                                    </div>

                                    <div class="row s-card-row border-0  pb-3">
                                        <div class="col-lg-4 bold pt-3">
                                            <label for="title">Title: <span class="text-danger">*</span></label>
                                            <select name="title" id="title" class=" form-control form-control-lg" required>
                                                <option value="">--Select one--</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Ms">Ms</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Mrs">Mrs</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-4 bold pt-3">
                                            <label for="name">Name: <span class="text-danger">*</span></label>
                                            <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control form-control-lg" required>
                                        </div>

                                        <div class="col-lg-4 bold pt-3">
                                            <label for="surname">Surname: <span class="text-danger">*</span></label>
                                            <input type="text" id="surname" name="surname" value="{{old('surname')}}" class="form-control form-control-lg" required>
                                        </div>
                                    </div>

                                    <div class="row s-card-row border-0  pb-3">
                                        <div class="col-lg-4 bold pt-3">
                                            <label for="email">Email: <span class="text-danger">*</span></label>
                                            <input type="text" id="email" name="email" value="{{old('email')}}" class="form-control form-control-lg" required>
                                        </div>

                                        <div class="col-lg-4 bold pt-3">
                                            <label for="home_phone">Home Phone: </label>
                                            <input type="text" id="home_phone" name="home_phone" value="{{old('home_phone')}}" class="form-control form-control-lg">
                                        </div>

                                        <div class="col-lg-4 bold pt-3">
                                            <label for="mobile">Mobile: <span class="text-danger">*</span></label>
                                            <input type="text" id="mobile" name="mobile" value="{{old('mobile')}}" class="form-control form-control-lg" required>
                                        </div>
                                    </div>

                                    <div class="row s-card-row border-0  pb-3">
                                        <div class="col-lg-4 bold pt-3">
                                            <label for="address_1">Address: <span class="text-danger">*</span></label>
                                            <input type="text" id="address_1" name="address_1" value="{{old('address_1')}}" class="form-control form-control-lg" required>
                                        </div>

                                        {{-- <div class="col-lg-4 bold pt-3">
                                            <label for="address_2">Address 2: </label>
                                            <input type="text" id="address_2" name="address_2" value="{{old('address_2')}}" class="form-control form-control-lg">
                                        </div>

                                        <div class="col-lg-4 bold pt-3">
                                            <label for="address_3">Address 3: </label>
                                            <input type="text" id="address_3" name="address_3" value="{{old('address_3')}}" class="form-control form-control-lg">
                                        </div> --}}
                                        <div class="col-lg-4 bold pt-3">
                                            <label for="post_code">Post Code: <span class="text-danger">*</span></label>
                                            <input type="text" id="post_code" name="post_code" value="{{old('post_code')}}" class="form-control form-control-lg" required>
                                        </div>
                                    </div>

                                    <div class="row s-card-row border-0 pb-3">
                                        {{-- <div class="col-lg-4 bold pt-3">
                                            <label for="address_4">Address 4: </label>
                                            <input type="text" id="address_4" name="address_4" value="{{old('address_4')}}" class="form-control form-control-lg">
                                        </div>

                                        <div class="col-lg-4 bold pt-3">
                                            <label for="address_5">Address 5: </label>
                                            <input type="text" id="address_5" name="address_5" value="{{old('address_5')}}" class="form-control form-control-lg">
                                        </div> --}}


                                    </div>

                                    <div class="row s-card-row border-bottom pb-3">
                                        <div class="col-12 bold pt-3">
                                            <button type="submit" name="register_step_1" class="btn btn-action btn-audi block fs-110"> <i class="fas fa-address-card me-1"></i> Register and get code </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>



@endsection


@section('scripts')

<script>

    $(function(){
       $('.js-event-wrapper').hide();
       $('.js-register-details').hide();

       $('#dealership_code').change(function(){
            var dealership_code = $(this).val();

            if(dealership_code == ""){
                $('.js-register-details, .js-event-wrapper').fadeOut();
            }else{
                $.ajax({
                        url: '/book/register/fetchEvents?dealership_code=' + dealership_code,

                            success:function(response){
                            //console.log(response)
                            $('.js-event-wrapper').fadeIn();
                            $('#event_id').html(response);

                        }
                });
            }



        });

        $('#event_id').change(function(){
            $('.js-register-details').fadeIn();
        })


    });

</script>

@endsection


@extends('_layouts._exec-dashboard')

@section('styles')

<link href="{{ asset('/assets/vendor/css/swiper.css') }}" rel="stylesheet" type="text/css">
    <style>
        .swiper-container {
            width: 100%;
            border: none;
            padding:20px 20px;
        }

        .swiper-pagination {
            bottom: -5px!important;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .swiper-pagination-bullet {
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            color: #000;
            opacity: 1;
            background: rgba(0, 0, 0, 0.2);
        }

        .swiper-pagination-bullet {
            width: 15px;
            height: 15px;
        }

        .swiper-pagination-bullet-active {
            color: #fff;
            background: #1b39a8;
        }

        .swiper-button-next, .swiper-button-prev {
            font-weight:bold;
            font-size: 10px;
            color: rgb(168, 168, 168);
        }

    </style>

@endsection


@section('content')
    <div class="row pop-up-wrapper"></div>
    <h1 class="display-4"><i class="fas fa-users"></i> Prospect Full Details</h1>

    @include('admin.inc._messages')

    <div class="s-card">

        <div class="row gx-5 pb-2">
            <div class="col text-end">
                <a href="{{route('exec.prospect.index')}}" class="btn btn-border sister py-0">Back</a>
            </div>
        </div>


        <div class="s-card-body border-top-0 shadow">

            <form action="{{route('exec.prospect.update', [$prospect->id])}}" enctype="multipart/form-data" method="POST">
                {{csrf_field()}}

                {{--Customer Details and Contact--}}
                    <div class="row">
                        {{--Customer Details--}}
                            <div class="col-lg-6">
                                <div class="px-3">
                                    <div class="row gx-5 ">
                                        <div class="col-12 s-card-header bg-brand">
                                            Customer Details
                                        </div>
                                    </div>
                                </div>

                                <div class="s-card-body alert-light border-0  px-3">
                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                                Customer name
                                        </div>
                                        <div class="col ">
                                            {{ $prospect->title}}  {{ $prospect->name}} {{ $prospect->surname }}
                                        </div>
                                    </div>

                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Address
                                        </div>
                                        <div class="col ">
                                            {{ $prospect->address_1}},   {{ $prospect->address_2}}, {{ $prospect->address_3 }} {{ $prospect->address_4 }} {{ $prospect->address_5 }}
                                        </div>
                                    </div>

                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Post Code
                                        </div>
                                        <div class="col ">
                                            {{ $prospect->post_code}}
                                        </div>
                                    </div>

                                    <div class="row gx-5 ">
                                        <div class="col-12 s-card-header alert-brand border-0">
                                            Vehicle Details
                                        </div>
                                    </div>

                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Registration
                                        </div>
                                        <div class="col ">
                                            {{ $prospect->vehicle_reg}}
                                        </div>
                                    </div>

                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Description
                                        </div>
                                        <div class="col ">
                                            {{ $prospect->vehicle_description}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{--END--}}

                        {{--Customer Contact--}}
                            <div class="col-lg-6">
                                <div class="px-3">
                                    <div class="row gx-5 ">
                                        <div class="col-12 s-card-header bg-brand">
                                            Customer Contact
                                        </div>
                                    </div>
                                </div>

                                <div class="s-card-body alert-light border-0  px-3">
                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Home Phone
                                        </div>
                                        <div class="col ">
                                            {{ $prospect->home_phone}}
                                        </div>
                                    </div>

                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Mobile
                                        </div>
                                        <div class="col ">
                                            {{ $prospect->mobile}}
                                        </div>
                                    </div>

                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Email Address
                                        </div>
                                        <div class="col ">
                                            <a href="mailto:{{ $prospect->email}}">{{ $prospect->email}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{--END--}}
                    </div>
                {{--END--}}

                {{--Booking Details and Prospect Progress--}}
                    <div class="row">

                    {{--Booking Details--}}
                        <div class="col-lg-6">
                            <div class="px-3">
                                <div class="row gx-5 ">
                                    <div class="col-12 s-card-header bg-brand">
                                        Booking Details
                                    </div>
                                </div>
                            </div>

                            <div class="s-card-body alert-light border-0  px-3">
                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Sales Executive
                                    </div>
                                    <div class="col ">
                                        @if($appointment) {{ $appointment->exec->name}} @endif
                                    </div>
                                </div>

                                @if(!empty($appointment->drink))
                                    <div class="row gx-5 py-2 border-bottom">
                                        <div class="col-lg-5 bold border-end">
                                            Drink Preference:
                                        </div>
                                        <div class="col ">
                                            {{ $appointment->drink}} @if(!empty($appointment->preference)) - {{ $appointment->preference}} @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Date/Time
                                    </div>
                                    <div class="col ">
                                        @if($appointment)
                                            <div class="row">
                                                <div class="col">{{ $appointment->date}}  - @if($appointment->event_time_id == NULL)  @else {{ $appointment->eventTime->time}} @endif</div>
                                                <div class="col text-end">
                                                    <a href="javascript:void(0)" appointment-id="{{ $appointment->id}}" date="{{ $appointment->date}}" class="js-edit-sale-time"><i class="fas fa-user-edit"></i> Edit</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 border-right">
                                        <span class="bold">Model Interested in:</span>    @if(!empty($appointment->model_interest)) ({{ $appointment->model_interest}}) @endif
                                    </div>
                                    <div class="col px-0 mt-1">
                                        @if(!empty($appointment->vehicles))
                                            @php
                                                $obj = json_decode($appointment->vehicles, true);
                                            @endphp
                                            <div class="swiper-container pt-0 ">
                                                <div class="swiper-wrapper">
                                                    @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                                                        @foreach ($obj as $key => $id)
                                                            @if($id ==  $vehicle->id)
                                                                <div class="swiper-slide shadow-sm relative border-0 mb-3">
                                                                    <h2 class="fs-150" style="position: absolute; top:20px; left: 20px; z-index: 10;">{{$vehicle->name}}</h2>
                                                                    <img class="block"  src="{{asset('assets/images/public/general')}}/{{$vehicle->filename}}" alt="">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                                <!-- Add Pagination -->
                                                <div class="swiper-pagination"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if(!empty($appointment->friend_interest == 1))
                                    <div class="form-group">
                                        <div class="row border-bottom pb-2">
                                            <div class="col-lg-5 bold border-right">
                                                Guest Details:
                                            </div>
                                            <div class="col">
                                                {{ $appointment->friend_name}} @if(!empty($appointment->friend_model_interest)) - {{ $appointment->friend_model_interest}} @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($appointment->part_exchange == 1))
                                    <div class="form-group">
                                        <div class="row border-bottom pb-2">
                                            <div class="col-lg-5 bold border-right">
                                                Part Exchange:
                                            </div>
                                            <div class="col">
                                            {{ $appointment->make}} - [ {{ $appointment->fuel_type}}, {{ $appointment->colour}}, {{ $appointment->registration}} ]
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    {{--END--}}

                    {{--Prospect progress--}}
                        <div class="col-lg-6">
                            <div class="px-3">
                                <div class="row gx-5 ">
                                    <div class="col-12 s-card-header bg-brand">
                                        Prospect Progress
                                    </div>
                                </div>
                            </div>

                            <div class="s-card-body alert-light border-0  px-3">
                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Call Attempts
                                    </div>
                                    <div class="col ">
                                        <select name="call_attempts" id="" class="form-control form-control-lg">
                                            <option value="">--Please Select--</option>
                                            <option value="1st Call" @if($appointment->call_attempts == '1st Call') selected @endif>1st Call</option>
                                            <option value="2nd Call" @if($appointment->call_attempts == '2nd Call') selected @endif>2nd Call</option>
                                            <option value="3rd Call" @if($appointment->call_attempts == '3rd Call') selected @endif>3rd Call</option>
                                            <option value="4th Call" @if($appointment->call_attempts == '4th Call') selected @endif>4th Call</option>
                                            <option value="5th Call" @if($appointment->call_attempts == '5th Call') selected @endif>5th Call</option>
                                            <option value="6th Call" @if($appointment->call_attempts == '6th Call') selected @endif>6th Call</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Call Made
                                    </div>
                                    <div class="col ">
                                        <input type="checkbox" id="call_made" class="js-call-made" name="call_made" value="1"
                                            @if($appointment->call_made == 1) checked @endif
                                        >
                                    </div>
                                </div>

                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Call back required
                                    </div>
                                    <div class="col ">
                                        <input type="checkbox" id="call_back" class="js-call-back" name="call_back" value="1"
                                            @if($appointment->call_back == 1) checked @endif
                                        >
                                    </div>
                                </div>

                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Message Left
                                    </div>
                                    <div class="col ">
                                        <input type="checkbox" id="message_left" name="message_left" value="1"
                                            @if($appointment->message_left == 1) checked @endif
                                        >
                                    </div>
                                </div>

                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Appointment Status
                                    </div>
                                    <div class="col ">
                                        <label for="null" class="mr-2 text-brand"><input type="radio" id="null" name="confirm" value="0"
                                            @if($appointment->confirm == 0) checked @endif
                                            > <small><strong>Null</strong></small>  </label>
                                        <label for="confirm" class="mr-2  text-brand"><input type="radio" id="confirm" name="confirm" value="1"
                                            @if($appointment->confirm == 1) checked @endif
                                            > <small><strong>Confirmed</strong></small> </label>
                                        <label for="cancel" class=" text-brand"><input type="radio" id="cancel" name="confirm" value="2"
                                            @if($appointment->confirm == 2) checked @endif
                                            > <small><strong> Cancelled</strong></small> </label>

                                            @if($appointment->confirm == 1) <div class="rounded fs-80 alert-success px-2 py-1"> Appointment Confirmed on: {{$appointment->updated_at}}</div> @endif
                                            @if($appointment->confirm == 2) <div class="text-danger rounded fs-80 alert-danger px-2 py-1"> Appointment Cancelled on: {{$appointment->updated_at}}</div> @endif

                                    </div>
                                </div>



                                <div class="row gx-5 py-2 border-bottom">
                                    <div class="col-lg-5 bold border-end">
                                        Notes
                                    </div>
                                    <div class="col ">
                                        <textarea name="notes" id="notes" rows="8" class="form-control form-control-lg">{{$appointment->notes}}</textarea>

                                    </div>
                                </div>
                            </div>

                        </div>
                    {{--END--}}

                    </div>
                {{--END--}}

                {{--Safe Prospects and View Sale Buttons--}}
                    <div class="js-btn-holder">
                        @if($sale)
                            <a href="javascript:void(0)" class="btn btn-default success js-view-sale mr-2"  sale-id="{{$prospect->sale->id}}"><i class="fas fa-handshake mr-2"></i> View Sale </a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-default sister js-create-sale mr-2"  appointment-id="{{$prospect->appointment->id}}" dealership-id="{{$dealership->id}}"  exec-id="{{$exec->id}}"   book-id="{{$prospect->id}}"> Create Sale </a>
                        @endif

                        <button type="submit" name="button" class="btn btn-default brother"><i class="fas fa-save mr-2"></i> Save Changes </button>
                    </div>
                {{--END--}}

            </form>
        </div>
    </div>





@endsection


@section('scripts')
    <script src="{{ asset('/assets/vendor/js/swiper.js') }}"></script>


    <script>
        $(function(){

            //toggles between call made and call back required (unchecks call_back)
            $('.js-call-made').click(function(){
                if($('.js-call-back').prop('checked')){
                     $('.js-call-back').prop('checked', function(_, checked) {
                        return !checked;
                    });
                }else{

                }
            });

            //toggles between call back required and call made (unchecks call_made)
            $('.js-call-back').click(function(){
                if($('.js-call-made').prop('checked')){
                    $('.js-call-made').prop('checked', function(_, checked) {
                        return !checked;
                    });
                }else{

                }
            });

        });

        //
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

    </script>

@endsection

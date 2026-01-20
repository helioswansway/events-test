@extends('_layouts._book-dashboard')

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

    @include('admin.inc._messages')

    @if($appointment->confirm == 1)
        <div class="bg-success border-0 text-center mb-4 pt-3 pb-2 px-5" style="margin-top: -30px; margin-left:-10px; margin-right:-22px;">
            <h1 class="display-4 fs-200 bold uppercase text-white border-0 m-0 mob-h1" style="line-height: 24px">Your Booking Confirmation has Been Made</h1>
        </div>
    @endif

    <form action="{{route('book.submit.booking')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="appointment_id" value="{{$appointment->id}}">

        <h1 class="display-4 bold mb-0 d-flex justify-content-between align-items-center mob-flex-table mob-full-with text-center">
            <div>Booking confirmation details.</div>

            <div class="show-mobile" style="height:10px"></div>

            @if($appointment->confirm != 1)
                <div class="js-confirm-button show-mobile">
                    {{-- <a href="{{route('book.confirm-details')}}" class="btn btn-border warning btn-radius-md "><i class="fas fa-arrow-left mr-3"></i>  Back</a> --}}
                    @if($appointment->confirm == 0)
                        <button type="submit" name="booking_confirmed" class="btn btn-border success btn-radius-md ">Confirm Booking</button>
                    @endif
                </div>
            @endif
        </h1>


        <div class="s-card px-3 mb-5 mt-5">
            <div class="row justify-content-center">

                    @if($event->show_vehicles == 1)
                        <div class="col-lg-5 py-3 rounded border shadow-sm mb-5">
                            <h2 class="text-center fs-120 border-bottom pb-2">
                            <span class="bold">Your Models Selected</span>
                                @if(!empty($appointment->model_interest))
                                - <span class="normal"> Interest <span class="text-info bold">{{$appointment->model_interest}}</span></span>
                                @endif
                            </h2>
                            <!-- Swiper -->

                            @if(!empty($appointment->vehicles))

                                @php
                                    $obj = json_decode($appointment->vehicles, true);
                                @endphp
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                                            @foreach ($obj as $key => $id)
                                                @if($id ==  $vehicle->id)
                                                    <div class="swiper-slide">
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

                            @if($appointment->confirm != 1)
                                <div class="col-12 text-center pt-3">
                                    <a href="{{route('book.dashboard')}}" class="btn  btn-radius-sm btn-sm btn-border sister">
                                        Amend
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endif

                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col px-5">
                                <div class="row py-5 shadow-sm rounded border">
                                    <div class="col text-center">
                                        <i class="fas fa-calendar-alt"></i>

                                        <div class="fs-120 border-bottom mb-2">Date</div>

                                        {{ date('F d, Y', strtotime($appointment->date))}}
                                    </div>

                                    <div class="col text-center">
                                        <i class="fas fa-user-clock"></i>
                                        <div class="fs-120 border-bottom mb-2">Time</div>
                                        {{$appointment->eventTime->time}}
                                    </div>

                                    @if($inc_exec == 1)
                                        <div class="col text-center">
                                            <i class="fas fa-user-alt"></i>
                                            <div class="fs-120 border-bottom mb-2">Sales person</div>
                                            @if($inc_exec == 1)
                                                {{$appointment->exec->name}}
                                            @else

                                            @endif
                                        </div>
                                    @endif

                                    @if($appointment->confirm != 1)
                                        <div class="col-12 text-center pt-3">
                                            <a href="{{route('book.appointment')}}" class="btn  btn-radius-sm btn-sm btn-border sister">
                                                Amend
                                            </a>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        @if($event->show_part_exchange == 1)
                            <div class="row mt-5">
                                <div class="col px-5">
                                    <div class="row border shadow-sm rounded">
                                        <div class="col py-5 text-center border">
                                            <i class="fas fa-exchange-alt"></i>
                                            <div class="fs-120 border-bottom mb-2"> Part exchange</div>

                                            @if($appointment->part_exchange == 1)
                                                <div class="py-2">
                                                <strong>Make:</strong>  {{$appointment->make}} <br>
                                                <strong>Registration:</strong>     {{$appointment->registration}} <br>
                                                <strong>Colour:</strong>     {{$appointment->colour}} <br>
                                                <strong>Fuel Type:</strong>     {{$appointment->fuel_type}} <br><br>
                                                <strong>Mileage:</strong>     {{$appointment->mileage}}
                                                </div>

                                                <br><br>

                                            @else
                                                <p class="bold my-2">None</p>
                                            @endif

                                            @if($appointment->confirm != 1)
                                                <a href="{{route('book.part.exchange')}}" class="btn  btn-radius-sm btn-sm btn-border sister">
                                                    Amend
                                                </a>
                                            @endif
                                        </div>
                                        {{--
                                        <div class="col-lg-6 py-5 text-center border">
                                            <i class="fas fa-user-plus"></i>
                                            <div class="fs-120 border-bottom mb-2">Guest </div>

                                            @if($appointment->friend_interest == 1)

                                                <div class="py-2">
                                                    <strong>Guest name:</strong>  {{$appointment->friend_name}} <br>
                                                    <strong>Model of Interest:</strong>     {{$appointment->friend_model_interest}} <br>
                                                </div>

                                                <br><br>

                                            @else
                                                <p class="bold my-2">None</p>
                                            @endif

                                            @if($appointment->confirm != 1)
                                                <a href="{{route('book.appointment')}}" class="btn  btn-radius-sm btn-sm btn-border sister">
                                                    Amend
                                                </a>
                                            @endif

                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
            </div>
        </div>

        @if($appointment->confirm != 1)
            <div class="col-12 text-center js-confirm-button show-descktop">
                {{-- <a href="{{route('book.confirm-details')}}" class="btn btn-border warning btn-radius-md "><i class="fas fa-arrow-left mr-3"></i>  Back</a> --}}
                @if($appointment->confirm == 0)
                    <button type="submit" name="booking_confirmed" class="btn btn-border success btn-radius-md ">Confirm Booking</button>
                @endif
            </div>
        @endif

    </form>

@endsection

@section('scripts')
    <script src="{{ asset('/assets/vendor/js/swiper.js') }}"></script>


    <script>
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

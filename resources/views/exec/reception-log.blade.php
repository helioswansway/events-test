@extends('_layouts._exec-dashboard')

@section('styles')

<link href="{{ asset('/assets/vendor/css/swiper.css') }}" rel="stylesheet" type="text/css">
    <style>
        .swiper-container {
            width: 100%;
            border: none;
            padding-bottom:30px ;
        }

        .swiper-pagination {
            bottom: 3px!important;
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
    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-concierge-bell"></i> Reception Log
                <span class="h1-button" style="">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-border brother px-3"><i class="fas fa-angle-double-left mr-1"></i> Back </a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    {{csrf_field()}}
    @if(isset($date->date))
        <input type="hidden" name="date" id="date" value="{{$date->date}}" date-id="{{$date->id}}" event-id="{{$date->event_id}}">
    @endif


    <div class="s-card-body border-0 px-3">
        <div class="row">
            <div class="col-lg-9 px-0">
                <div class="row">
                    <div class="col-12 text-end mb-1 fs-90">
                        <span class="icon-list"> <span class="icon-name"> Previous Date</span> <span class="icon booked-circle alert-prev "></span> </span>
                        <span class="icon-list"> <span class="icon-name"> Cancelled</span> <span class="icon booked-circle alert-cancelled "></span> </span>
                        <span class="icon-list"> <span class="icon-name"> Arrived</span> <span class="icon booked-circle alert-arrived"></span> </span>
                    </div>
                </div>


                <div class="shadow">
                    <div class="s-card-header px-2 bg-brother">Event Appointments</div>

                    <div class="s-card-header px-2 bg-brand">
                        <div class="row">
                            <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Date/Time
                            </div>
                            <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Prospect name
                            </div>
                            <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Dealership
                            </div>
                            <div class="col-2  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Exec
                            </div>
                            <div class="col-2  border-end  text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Has Arrived
                            </div>
                            <div class="col-2  text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                Appointment Status
                            </div>
                        </div>
                    </div>

                    <div class="s-card-body p-0">
                        @if(count($appointments) > 0)

                            <div id="accordion" class="accordion-message s-card-body col-12  p-0">
                                @foreach($appointments as $appointment)
                                        <h3 class="col-12 py-0
                                            @if(isset($date->date))
                                                @if($appointment->date < $date->date) text-dark alert-prev @endif
                                            @endif

                                            @if($appointment->cancelled == 1) alert-cancelled text-danger  @endif
                                            @if($appointment->arrived === 1) alert-arrived text-brand  @endif
                                            " >
                                            <div class="row s-card-row  line-height-34"  style="border: none;">
                                                <div class="col-lg-2 px-4  border-end bold" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    @if($appointment->cancelled == 1)
                                                        {{\Carbon\Carbon::parse($appointment->date)->format('jS')}} {{\Carbon\Carbon::parse($appointment->date)->format('M Y')}}
                                                    @else
                                                        {{\Carbon\Carbon::parse($appointment->date)->format('jS')}} {{\Carbon\Carbon::parse($appointment->date)->format('M Y')}} - @if(!empty($appointment->eventTime->time)) {{$appointment->eventTime->time}} @endif
                                                    @endif
                                                </div>

                                                <div class="col-2 hide-mobile bold border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{$appointment->book->title}}   {{$appointment->book->name}} {{$appointment->book->surname}}
                                                </div>

                                                <div class="col-2 hide-mobile border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{$appointment->dealership->name}}
                                                </div>

                                                <div class="col-2 hide-mobile bold  border-end" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{$appointment->exec->name}}
                                                </div>

                                                <div class="col-2 hide-mobile bold  border-end text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    @if($appointment->arrived == 1)
                                                        <i class="fas fa-check-circle fs-150 text-success mt-2"></i>
                                                    @else
                                                        @if(isset($date->date)  && $appointment->date < $date->date)

                                                        @else
                                                            <a href="javascript:void(0)"  appointment-id="{{$appointment->id}}" class="btn btn-border brand js-arrived py-0 px-2 fs-80">Arrived</a>
                                                        @endif
                                                    @endif
                                                </div>

                                                <div class="col-2 hide-mobile text-center">
                                                    @if($appointment->cancelled == 1)
                                                        <i class="fas fa-times-circle  fs-150 text-danger mt-2" title="Appointment Cancelled"></i>
                                                    @else
                                                        @if($appointment->arrived == 1)

                                                        @else
                                                            @if(isset($date->date)  && $appointment->date < $date->date)
                                                            @else
                                                                <a href="javascript:void(0)"  appointment-id="{{$appointment->id}}" class="btn btn-border sister js-cancelled  py-0 px-2 fs-80">Cancel</a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </h3>

                                        <div class="s-card-body alert-light col-12 border-top-0 " >
                                            <div class="row pb-4 ">
                                                <div class="col-lg-6 pl-0 border-right  line-height-22">
                                                    <h2 class="fs-150 text-brand alert-secondary p-2 border-0">Event Details</h2>
                                                    <div ><strong>Date:</strong> {{\Carbon\Carbon::parse($appointment->date)->format('jS')}} {{\Carbon\Carbon::parse($appointment->date)->format('M Y')}} - @if(!empty($appointment->eventTime->time)) {{$appointment->eventTime->time}} @endif</div>
                                                    <div ><strong>Dealership:</strong> {{$appointment->dealership->name}}</div>
                                                    <div ><strong>Exec:</strong> {{$appointment->exec->name}}</div>

                                                </div>
                                                <div class="col-lg-6 line-height-22">
                                                    <h2 class="fs-150 text-brand alert-secondary p-2 border-0">Customer Details</h2>

                                                    <div ><strong>Name: </strong>{{$appointment->book->title}} {{$appointment->book->name}} {{$appointment->book->surname}}</div>
                                                    <div ><strong>Email:</strong> {{$appointment->book->email}}</div>
                                                    <div><strong>Home Phone:</strong> {{$appointment->book->home_phone}}</div>
                                                    <div><strong>Mobile:</strong> {{$appointment->book->mobile}}</div>
                                                    <hr class="my-3">
                                                    @if($appointment->drink)
                                                        <div><strong>Drink Preference:</strong> {{$appointment->drink}} @if($appointment->preference) with  {{$appointment->preference}} @endif</div>
                                                    @else
                                                        <div><strong>Drink Preference:</strong> <i> Customer didn't select any drink!</i></div>
                                                    @endif



                                                    @if($appointment->friend_interest)
                                                        <div><strong>Additional guests:</strong> {{$appointment->friend_name}}</div>
                                                        <div><strong>Model Interested:</strong> {{$appointment->friend_model_interest}}</div>
                                                    @else
                                                        <pdiv><strong>Additional guests:</strong> <i> Customer may come alone!</i></pdiv>
                                                    @endif

                                                    @if($appointment->confirm == 2)
                                                        <div class="text-danger rounded fs-80 alert-danger p-2 mt-2" style="float:none; cursor:default "> Appointment Cancelled at {{$appointment->updated_at}} </div>
                                                    @endif

                                                </div>

                                            </div>

                                            <div class="row bg-white py-3">
                                                <div class="col-lg-6 mb-3">
                                                    @if($appointment->part_exchange == 1)
                                                        <h2 class="fs-150 text-brand alert-light p-2 border-0">Part Exchange</h2>
                                                    <div class="col-12 fs-90 line-height-20 pl-0">
                                                        <strong>Mileage:</strong> {{$appointment->mileage}} <br>
                                                        <strong>Registration:</strong> {{$appointment->registration}} <br>
                                                        <strong>Make:</strong> {{$appointment->make}} <br>
                                                        <strong >Colour:</strong> {{$appointment->colour}} <br>
                                                        <strong>Fuel Type:</strong> {{$appointment->fuel_type}}
                                                    </div>
                                                    @else
                                                        <h2 class="fs-150 text-brand alert-light p-2 border-0">Part Exchange</h2>

                                                        <p> <i> Customer didn't enter a Part exchange</i></p>
                                                    @endif

                                                </div>

                                                <div class="col-lg-6">
                                                    <h2 class="fs-150 text-brand alert-light p-2 border-0">Model Interest</h2>
                                                    <div class="row fs-90 line-height-20">
                                                        <div class="col-3 bold">Interested in:</div>
                                                        <div class="col-9">{{$appointment->model_interest}}</div>
                                                    </div>

                                                    <div class="row pb-3">
                                                        <div class="col-12">
                                                            @if(!empty($appointment->vehicles))
                                                            <h2 class="fs-150 text-brand alert-light p-2 border-0 mt-3">Vehicle Selected</h2>

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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <h2 class="fs-150 text-brand alert-sister p-2 border-0 mt-3 mb-0">Call Log</h2>
                                                <div class="col-12 fs-90 bg-white line-height-20  py-3">
                                                    <strong>Call Attempts:</strong>
                                                    @if($appointment->call_attempts == null) <i>No</i>  @else {{$appointment->call_attempts}} @endif <br>
                                                    <strong>Call Made:</strong>
                                                    @if($appointment->call_made == 0) <i>No</i>  @else Yes @endif <br>
                                                    <strong>Customer Require Call Back:</strong>
                                                    @if($appointment->call_back == 0) <i>Didn't require call back</i>  @else Requested a call back @endif <br>
                                                    <strong>Left Voice Message:</strong>
                                                    @if($appointment->message == 0) <i>No</i>  @else Yes @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <h2 class="fs-150 text-brand alert-sister p-2 border-0 mt-3 mb-0">Sale</h2>
                                                <div class="col-12 bg-white fs-90 line-height-20 py-3">
                                                    @if(adminSale($appointment->id))
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <strong> Sale Type:</strong> {{adminSale($appointment->id)->sale_type}}  <br>
                                                            <strong> Appointment:</strong>  {{adminSale($appointment->id)->from_appointment}} <br>
                                                            <strong> Warranty:</strong>    @if(adminSale($appointment->id)->warranty == 1) Yes @else No @endif <br>
                                                            <strong> Finance:</strong>    @if(adminSale($appointment->id)->finance == 1) Yes @else No @endif <br>
                                                            <strong> Gap:</strong>    @if(adminSale($appointment->id)->gap == 1) Yes @else No @endif <br>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <strong> Paint Protection:</strong>    @if(adminSale($appointment->id)->paint_protection == 1) Yes @else No @endif <br>
                                                            <strong> Smart:</strong>    @if(adminSale($appointment->id)->smart == 1) Yes @else No @endif <br>
                                                            <strong> Part Exchange:</strong>    @if(adminSale($appointment->id)->part_exchange == 1) Yes @else No @endif <br>
                                                            <strong> Registration:</strong>    @if(adminSale($appointment->id)->registration) {{adminSale($appointment->id)->registration}}  @else  @endif <br>
                                                        </div>
                                                    </div>


                                                    @else

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <strong> Sale Type:</strong> No  <br>
                                                            <strong> Appointment:</strong>  No <br>
                                                            <strong> Warranty:</strong>    No <br>
                                                            <strong> Finance:</strong>    No <br>
                                                            <strong> Gap:</strong>    No <br>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <strong> Paint Protection:</strong>  No <br>
                                                            <strong> Smart:</strong>  No <br>
                                                            <strong> Part Exchange:</strong>  No <br>
                                                            <strong> Registration:</strong>   No<br>
                                                        </div>
                                                    </div>

                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row pr-4"> <hr class="my-3"> </div>

                                            <div class="row">
                                                <div class="col-12 bold pl-0">Notes:</div>
                                                <div class="col-12 p-3 border  bg-white">
                                                    <form action="{{route('appointment.update.notes', [$appointment->id])}}" method="POST">
                                                        {{ method_field('POST') }}
                                                        {{csrf_field()}}
                                                        <textarea name="notes" id="notes" class="form-control from-control-lg" rows="10">{{$appointment->notes}}</textarea>
                                                        <button type="submit" name="btnSaveNotes" class="btn btn-default sister mt-3"><i class="fas fa-save mr-2"></i> Save Notes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                @endforeach
                            </div>

                        @else
                            <div class="row">
                                <div class="alert-warning text-dark border border-warning px-3 py-2">
                                    <i class="fas fa-exclamation-triangle text-warning fs-170"></i> There's no record sets in the database!
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="mob-space py-2"></div>
            <div class="col-lg-3 pb-5">
                <div class="s-card-header px-2 bg-brand">Todays availability</div>

                <div class="s-card-body p-0">
                    @if($times->count() > 0 )
                        <div id="accordion-times" class="accordion-message s-card-body  p-0">
                            @foreach($times as $time)
                                <h3 class="row s-card-row bold alert-brand text-brand py-3">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col">{{$time->time}}</div>
                                            <div class="col text-end normal fs-110">
                                                <span class="badge alert-success text-dark ms-2 py-1"   title="Number of Bookings">
                                                    <i class="fas fa-clipboard-check"></i> {{numberOfExecs($time->id)}}
                                                </span>

                                                <span class="badge alert-sister text-sister ms-2  py-1" title="Number of Execs available">
                                                    <i class="fas fa-clipboard-list"></i> {{(count($execs)- numberOfExecs($time->id))}}
                                                </span>

                                            </div>
                                        </div>

                                    </div>
                                </h3>
                                <div class="s-card-body bg-white border-top-0 px-3 py-0 " >
                                    @foreach ($execs as $exec)
                                        @if(execAppointment($time->id, $exec->id))

                                            <div class="row py-1 border-bottom alert-success py-2">
                                                <div class="col-6">
                                                    {{ $exec->name }}
                                                </div>
                                                <div class="col-6 text-end">
                                                    Booked <i class="fas fa-check"></i>
                                                </div>
                                            </div>
                                        @else

                                            <div class="row py-1 border-bottom py-3">
                                                <div class="col-6">
                                                    {{ $exec->name }}
                                                </div>
                                                <div class="col-6 text-end">
                                                    <a href="{{route('admin.appointment.prospect', [$date->event_id, dealershipByCode($exec->dealership_code)->id])}}" title="Make a Booking" exec-id="{{ $exec->id }}" class="js-book-appointment text-info"  time="{{$time->time}}" time-id="{{$time->id}}">
                                                        <i class="fas fa-book-reader"></i> Book
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                    @else
                        <div class="col text-sister bold py-2 text-center">
                            No dates available!
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>





    <div class="py-5 my-3"></div>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script src="{{ asset('/assets/vendor/js/swiper.js') }}"></script>


    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: false,
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



    <script>
            $( function() {

                $( "#accordion" ).accordion({
                    heightStyle: "content",
                    collapsible: true,
                    active:false,

                })

                $( "#accordion-times" ).accordion({
                    heightStyle: "content",
                    collapsible: true,
                    active:false,

                })

                //Markes customer as arrived
                $('.js-arrived').click(function(){
                    $( "#accordion > h3:first-child" ).addClass( "ui-state-disabled" );
                    var id = $(this).attr('appointment-id');
                    $.ajax({
                        url: '/exec/reception-log/arrived?appointment_id='+id,
                        success:function(response){
                            console.log(response);
                            window.location.reload(0);
                        }
                    });
                })

                $('.js-cancelled').click(function(){
                    $( "#accordion > h3:first-child" ).addClass( "ui-state-disabled" );
                    var id = $(this).attr('appointment-id');
                    $.ajax({
                        url: '/exec/reception-log/cancelled?appointment_id='+id,
                            success:function(response){
                                console.log(response);
                                window.location.reload(0);
                            }
                    });
                })

            });
    </script>

@endsection

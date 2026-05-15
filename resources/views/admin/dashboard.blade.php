@extends('_layouts._dashboard')


@section('content')

    <h1 class="display-4"><i class="fas fa-tachometer-alt"></i> Dashboard <span class="text-info bold fs-70">(Last logged in <em class="text-warning">{{ auth('admin')->user()->last_login_at }}</em> )</span> </h1>

    @include('admin.inc._messages')

    {{-- @admin('super-admin,leaderboard')
        <div class="s-card border-0 mb-5">
            <div class="row">
                <div class="col-lg-3">
                    <div class="col-12 text-center"><h1 class="fs-130 bold mt-3">Active Competitions</h1></div>
                    <div class="col-12">{!! $competition->container() !!}</div>
                </div>

                <div class="col-lg-7">
                    {!! $chart->container() !!}
                </div>

                <div class="col-lg-2 shadow d-flex justify-content-center align-items-center py-5 px-1">
                    <div class="text-center">
                        <div class="col-12 fs-120">
                            Leaderboard Total:    <span class="ml-2 fs-200">{{$total_sales->count()}}</span>
                        </div>
                        @if($total_sales->count() > 0)
                            <div class="col-12 mt-3">
                                <a href="{{route('admin.leaderboard.index')}}" class="btn btn-action brother"><i class="fas fa-chart-bar mr-2 fs-120"></i> View League</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endadmin --}}

    @admin('super-admin,appointments,reception')
        {{csrf_field()}}

        <div class="col-12">
            <div class="row px-3 fs-80">
                <div class="col-12 py-2 bg-white text-end border-0">

                    <span class="icon-list"> <span class="icon-name"> Confirmed</span> <span class="icon booked-circle border border-secondary"></span> </span>
                    <span class="icon-list"> <span class="icon-name"> In Progress</span> <span class="icon booked-circle border border-warning"></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Hot Leads</span> <span class="icon booked-circle border border-danger"></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Not Interested</span> <span class="icon booked-circle border border-info"></span> </span>
                    <span class="icon-list"> <span class="icon-name"> Sales</span> <span class="icon booked-circle border border-success"></span> </span>

                </div>
            </div>

            <div class="s-card shadow ">
                <div class="s-card-header bg-brand border-bottom-0 pl-0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col ">
                                @admin('super-admin')
                                    <a href="{{route('event.index')}}" class="btn btn-border brother" title="Edit Events"><i class="far fa-edit me-1"></i> Events</a>
                                @else
                                    Events
                                @endadmin
                            </div>

                            <div class="col text-end hide">
                                <a href="javascript:void(0)" class="js-book-appointment btn btn-default sister" title="Book an Appointment">
                                    <i class="fas fa-book-reader"></i> <span> Book Appointment <i class='fas fa-angle-right fs-100'></i></span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="s-card-body pb-3 px-3">
                    @if(count($events) > 0)
                        <div class="row">
                            @foreach($events as $event)
                                <div class="col-12 ">
                                    <div class="row">
                                        <div class="col pt-2">
                                            <h2 class="fs-120 bold text-brand">
                                                @if($event->active == 1)
                                                    <i class="fas fa-check text-success" title="Event is active"></i>
                                                @else
                                                    <i class="fas fa-times text-danger" title="Event isn't active"></i>
                                                @endif
                                                {{$event->name}}  <span class="ms-2 normal fs-80 italic"><u> From:</u> <span class="text-secondary me-2"> {{eventFirstDate($event->id)}}</span> <u>To:</u> <span class="text-secondary">{{eventLastDate($event->id)}}</span></span>
                                            </h2>
                                        </div>

                                        @admin('super-admin,reports')
                                            <div class="col text-end pt-1">
                                                <a href="{{route('admin.report.index',$event->id)}}" class="btn btn-default sister mb-2"><i class="fas fa-chart-pie fs-150 me-2" style="margin-bottom: -10px"></i> Reports <i class="fas fa-angle-right ml-3"></i></a>
                                            </div>
                                        @endadmin
                                    </div>

                                    <div class="row">
                                        @foreach($dealerships->event_dealerships($event->id) as $dealership)
                                            <div class="col-lg-8 text-end">
                                                <a href="{{route('admin.appointment.show', [$dealership->id])}}" class="btn btn-border  brand text-brand mr-1 fs-80 block line-height-26 text-end" style="text-decoration: none;" title="Manage {{$dealership->name}} Dealership">
                                                    <span class="float-start">
                                                        <img src="{{asset('assets/images/public/general/')}}/{{$event->filename}}" class="fluid-img mr-2 " style="height:20px" title="{{$event->name}} Logo">     {{$dealership->name}}
                                                    </span>

                                                    <span class="border text-center" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{dealershipNumbAppointment($dealership->id, $event->id)}}
                                                    </span>

                                                    <span class="border border-warning text-warning text-center  ml-2" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{dealershipNumbInProgress($dealership->id, $event->id)}}
                                                    </span>

                                                    <div class="border border-danger text-center text-danger ml-2" style="display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{ hotLeadsNumb($dealership->id, $event->id)}}
                                                    </div>

                                                    <span class="border border-info  text-info text-center ml-2" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{dealershipNumbNotInterested($dealership->id, $event->id)}}
                                                    </span>

                                                    <span class="border border-success  text-success text-center ml-2" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{dealershipNumbSales($dealership->id, $event->id)}}
                                                    </span>

                                                </a>
                                            </div>

                                            <div class="col-lg-3 pb-1">
                                                <a href="{{route('admin.appointment.prospect', [$event->id, $dealership->id])}}" class="btn btn-border brother mr-1 fs-80 block text-start">
                                                    <span class="line-height-26  "><i class="fas fa-address-card mr-3"></i> Prospects
                                                        @if($exec)
                                                            <span class="badge  alert-brother px-1 text-brand ml-2">Amount: {{prospectsExecAmount($dealership->code, $event->id, $exec->id)}}</span>
                                                        @else
                                                            <span class="badge  alert-brother px-1 text-brand ml-2">Amount: {{prospectsAmount($dealership->code, $event->id)}}</span>
                                                        @endif
                                                        @admin('super-admin,renewals')
                                                            <span class="badge  alert-sister px-1 text-brand ml-1">K2K: {{prospectsRenewalAmount($dealership->code, $event->id)}}</span>
                                                        @endadmin
                                                    </span>

                                                    <span class="float-end border text-center" style=" display: inline-block; height:25px; width:25px; line-height:23px; border-radius: 100%;">
                                                        <i class="fas fa-angle-right fs-100 "></i>
                                                    </span>
                                                </a>
                                            </div>

                                            <div class="col-lg-1 py-1">
                                                <a href="{{route('exec.dealership.export', [$dealership->id])}}" class="btn btn-default light fs-100 block text-center px-0 py-0" title="Export Execs" style="float: left;">
                                                    <span class="text-brand" style=" display: inline-block; line-height:30px; border-radius: 100%;">
                                                        <i class="fa-solid fa-file-arrow-down fs-120"></i> <span class="fs-60 bold"> Execs</span>
                                                    </span>
                                                </a>
                                            </div>

                                        @endforeach
                                    </div>

                                    @admin('super-admin,renewals')
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <a href="javascript:void(0)" class="btn text-end  px-3 py-1 text-brand mr-1 fs-80 block line-height-26 text-start" style="text-decoration: none; cursor: default;" title="Manage {{$dealership->name}} Dealership">
                                                    <strong class="mr-2">Total:</strong>
                                                    <span class="border border-secondary text-center" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{eventNumbAppointment($event->id)}}
                                                    </span>

                                                    <span class="border border-warning text-warning text-center ml-2" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{eventNumbInProgress($event->id)}}
                                                    </span>


                                                    <span class=" border border-danger text-center text-danger ml-2" style="display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{eventNumbHotLeads($event->id)}}
                                                    </span>

                                                    <span class="border border-info  text-info text-center ml-2" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{eventNumbNotInterested($event->id)}}
                                                    </span>

                                                    <span class="border border-success  text-success text-center ml-2" style=" display: inline-block; height:28px; width:28px; line-height:28px; border-radius: 100%;">
                                                        {{eventNumbSales($event->id)}}
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    @endadmin
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12 alert-warning text-dark border border-warning py-2 bold">
                                <i class="fas fa-exclamation-triangle text-warning fs-170 mr-2"></i> There's no record sets in the database!
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endadmin

@endsection

{{--
@section('scripts')

    {!! $chart->script() !!}
    {!! $competition->script() !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>



    <script>

    </script>



@endsection --}}

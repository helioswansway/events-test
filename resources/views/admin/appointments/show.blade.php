
@extends('_layouts._dashboard')

@section('content')
    <div class="row pop-up-wrapper hide"></div>


    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-calendar-alt"></i> Appointments
                <span class="h1-button" style="">
                    <a href="{{route('admin.appointment.index')}}" class="btn btn-border sister "><i class="fas fa-angle-double-left mr-1"></i> Back </a>
                    <a href="{{route('admin.appointment.reception', [$dealership->id])}}" class="btn btn-border brother "><i class="fas fa-concierge-bell"></i> Reception </a>
                    <a href="{{route('admin.appointment.prospect', [$event->id, $dealership->id])}}" class="btn btn-border brother "><i class="fas fa-chalkboard-teacher mr-2"></i> Prospects</a>

                    <a href="{{route('admin.appointment.prospect.register', [$event->id, $dealership->id])}}" class="btn btn-default brother "><i class="fas fa-user-plus mr-2"></i> Create Appointment</a>

                </span>
            </h1>
        </div>
    </div>


    @include('admin.inc._messages')
    <div class="js-message alert-success p-3 hide"></div>
    <div class="s-card shadow border-0">
        {{csrf_field()}}
        <div class="s-card-header">
            <div class="row">
                <div class="col "> Appointments </div>
                <div class="col text-end hide">
                    <a href="javascript:void(0)" class="js-book-appointment btn btn-default sister" title="Book an Appointment">
                        <i class="fas fa-book-reader"></i> <span> Book Appointment <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="s-card-header bg-brother">
            <div class="row fs-90 normal">
                <div class="col-2 border-right ">Dealership</div>
                @foreach($dates as $date)
                    <div class="col  border-right text-center">
                        @if($dates->count() > 10)
                            {{\Carbon\Carbon::parse($date->date)->format('d')}}
                        @else
                            {{\Carbon\Carbon::parse($date->date)->format('l')}}
                        @endif

                    </div>
                @endforeach
                <div class="col-1 text-center">Total</div>
            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            <div class="row s-card-row bold line-height-40">
                <div class="col-2 border-right">
                    {{$dealership->name}}
                </div>
                @foreach($dates as $date)
                    <a href="{{route('admin.log.appointment', [$date->id, $dealership->id])}}" class="col  border-right text-center" style="text-decoration: none;" title="Create/Manage Appointments">
                        <span data-appointment=" {{ adminNumbAppointment($date->date, $dealership->id) }}" class="border js-num-appointments" style="display: inline-block; height:25px; width:25px; line-height:23px; border-radius: 100%;">
                            {{ adminNumbAppointment($date->date, $dealership->id) }}
                        </span> <i class="fas fa-hand-pointer fs-100 ml-0"></i>
                    </a>
                @endforeach
                <div class="col-1 text-center text-danger js-total" total=""></div>
            </div>
        </div>

        <div class="s-card-body border-0  px-3">
            <div class="row">
                <div class="col-lg-4 border-right border-white">
                    <p class="mb-1 fs-90"><i>Number of Sales</i></p>
                    <div class="row alert-success py-2 bold">
                        <div class="col-12">
                            <span class="mr-3 text-dark">Sales</span>
                            <a href="{{route('admin.appointment.show.sales', [$event->id, $dealership->id])}}" class="btn btn-sm btn-default success px-3"> {{ salesNumb($dealership->id, $event->id)}}</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 border-right border-white">
                    <p class="mb-1 fs-90"><i>Number of Appointments in Progress</i></p>
                    <div class="row alert-warning lighter py-2 border-0 bold">
                        <div class="col-12">
                            <span class="mr-3 text-dark">In-progress</span>
                            <a href="{{route('admin.appointment.show.in.progress', [$event->id, $dealership->id])}}" class="btn btn-sm btn-default warning px-3"> {{ inProgressNumb($dealership->id, $event->id)}}</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 border-left border-white">
                    <p class="mb-1 fs-90"><i>Number of customers that logged in but didn't confirm booking</i></p>
                    <div class="row alert-brother py-2 bold">
                        <div class="col-12">
                            <span class="mr-3 text-dark">Hot Leads</span>
                            <a href="{{route('admin.appointment.hot.leads', [$event->id, $dealership->id])}}" class="btn btn-sm btn-default brother px-3"> {{ hotLeadsNumb($dealership->id, $event->id)}}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

@endsection


@section('scripts')
    <script>
        $(function(){
                var appointments = [];
                var total = 0;

                $(".js-num-appointments").each(function(){

                    appointments.push($(this).data('appointment')); //get links
                    total += parseInt($(this).data('appointment'), 10);
                });

                $('.js-total').html(total);

        });

    </script>
@endsection


@extends('_layouts._exec-dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

    <h1 class="display-4"><i class="fas fa-calendar-alt"></i> Appointments</h1>
    @include('admin.inc._messages')
    <div class="js-message alert-success p-3 hide"></div>
    <div class="s-card shadow">
        {{csrf_field()}}
        <div class="s-card-header bg-brother border-bottom-0 ">
            <div class="row">
                <div class="col">{{$exec->name}} - Appointments </div>
                <div class="col text-end hide">
                    <a href="javascript:void(0)" class="js-book-appointment btn btn-default sister" title="Book an Appointment">
                        <i class="fas fa-book-reader"></i> <span> Book Appointment <i class='fas fa-angle-right fs-100'></i></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="s-card-header bg-brand ">
            <div class="row bold">
                <div class="col-2 border-right ">Dealership</div>
                @foreach($dates as $date)
                    <div class="col  border-right text-center">{{\Carbon\Carbon::parse($date->date)->format('l')}}</div>
                @endforeach
                <div class="col-2 text-center">Total</div>
            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            <div class="row s-card-row py-2 bold">
                <div class="col-2 border-right">
                    {{$dealership->name}}
                </div>

                {{-- <a href="" class="col  border-right text-center" style="text-decoration: none;" title="Create/Manage Appointments">
                    <span data-appointment="3" class="border js-num-appointments" style="display: inline-block; height:25px; width:25px; line-height:23px; border-radius: 100%;">
                        3
                    </span> <i class="fas fa-hand-pointer fs-100 ml-0"></i>
                </a> --}}
                @foreach($dates as $date)
                    <a href="/exec/appointments/log/{{currentExec()->id}}/{{$date->id}}" class="col  border-right text-center" style="text-decoration: none;" title="Create/Manage Appointments">
                        <span data-appointment="{{numbAppointment($date->date)}}" class="border js-num-appointments" style="display: inline-block; height:25px; width:25px; line-height:23px; border-radius: 100%;">
                            {{numbAppointment($date->date)}}
                        </span> <i class="fas fa-hand-pointer fs-100 ml-0"></i>
                    </a>
                @endforeach

                <div class="col-2 text-center text-danger js-total" total=""></div>
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

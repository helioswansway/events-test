
@extends('_layouts._exec-dashboard')


@section('content')
    <div class="row pop-up-wrapper"></div>

    <div class="col-12">
        <h1 class="display-4"><i class="fas fa-calendar-alt"></i> Appointments Log
            <span class="h1-button">
                <a href="{{route('exec.appointment.index')}}" class=" btn btn-border sister  py-0"><i class="fas fa-caret-left mr-1"></i> Back</a>
            </span>
        </h1>
    </div>

    @include('admin.inc._messages')
    <div class="s-card shadow">
        {{csrf_field()}}
        <input type="hidden" name="date" id="date" value="{{$date->date}}" date-id="{{$date->id}}" event-id="{{$date->event_id}}">
        <div class="s-card-header bg-brother">
             Appointments Log for {{currentDealership()->name}} - {{\Carbon\Carbon::parse($date->date)->isoFormat('dddd Do MMMM')}}
        </div>


        <div class="s-card-header bg-brand hide-mobile">
            <div class="row bold">
                <div class="col-1  border-right ">Time</div>
                <div class="col-1  border-right  text-center">Edit</div>

                <div class="col-2  border-right text-center">Customer</div>
                <div class="col-2  border-right text-center">Phone</div>
                <div class="col-2 border-right text-center">Booked By</div>
                <div class="col-2  border-right text-center">Date Booked</div>
                <div class="col-2 text-end">Action</div>
            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            @foreach($times as $time)
                <div class="row s-card-row line-height-30 normal ">
                    <div class="col-3 col-lg-1  border-right bold">{{$time->time}}</div>

                    @forelse($appointments->where('event_time_id', $time->id) as $appointment)
                        {{--It's available for booking--}}


                        <div class="col-4 col-lg-1  border-right text-start text-lg-center">
                            <a href="{{route('exec.edit.appointment', [$appointment->book->event_id, $appointment->dealership_id, $appointment->book->id])}}" title="Edit Booking" class="text-success"  time="{{$time->time}}" time-id="{{$time->id}}"><i class="fas fa-user-edit"></i> Edit</a>
                        </div>
                        <div class="col-4 col-lg-2  border-right  text-start text-md-center">
                            {{ $appointment->book->title }} {{$appointment->book->name }} {{$appointment->book->surname }}
                        </div>



                        <div class="col-3 col-lg-2  border-right text-start text-lg-center">
                            {{ $appointment->book->mobile }}
                        </div>
                        <div class="col-4 col-lg-2  border-right text-start text-md-center">{{$appointment->exec->name }}</div>
                        <div class="col-4 col-lg-2  border-right text-start text-md-center">{{\Carbon\Carbon::parse($appointment->date)->format('d M Y')}}</div>

                        <div class="col-6 col-lg-2  border-right text-start text-md-end">
                            <span appointment-id="{{$appointment->id }}" class="rounded js-confirm-appointment" title="Booking Confirmed">
                                <i class="fas fa-calendar-check text-success fs-120"></i>
                            </span>
                            &nbsp;
                            <a href="javascript:void(0)" appointment-id="{{$appointment->id }}" style="" class="rounded border border-danger px-1 pt-1 pb-0  ml-1 js-delete-appointment" title="Delete Appointment"><i class="fa fa-trash text-danger fs-120"></i></a>

                        </div>


                        {{--There's no bookings--}}
                        @empty

                            <div class="col-5 col-lg-1 border-right  text-start text-lg-center">
                                <a href="{{route('exec.prospect.index')}}" title="Create Booking" class="text-info" exec-id="{{auth('exec')->user()->id}}"  time="{{$time->time}}" time-id="{{$time->id}}"><i class="fas fa-book-reader"></i> Book</a>
                            </div>
                            <div class="col-1 col-lg-2  border-right text-md-center"> - - </div>
                            <div class="col-1 col-lg-2  border-right text-md-center"> - - </div>
                            <div class="col-1 col-lg-2  border-right text-md-center"> - - </div>
                            <div class="col-1 col-lg-2  border-right text-md-center">  - - </div>
                            <div class="col text-center">   </div>

                    @endforelse

                </div>
            @endforeach
        </div>

@endsection


@section('scripts')
    <script>
        $(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.js-view-customer').click(function(){
            var customer_id     =   $(this).attr('customer-id');

            $.ajax({
                    url: '/exec/appointments/view-customer?customer_id='    + customer_id,

                        success:function(response){
                            //console.log(response)

                            $('.pop-up-wrapper').fadeIn(1000);
                            $('.pop-up-wrapper').html(response);

                            $('.js-refresh').click(function(){
                                setTimeout(function(){
                                    return location.reload();
                                }, 500);
                            })


                    }
            });

        });

        //Delete Appointment
            $('.js-delete-appointment').click(function(){

                var id = $(this).attr('appointment-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete this booking?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                url: '/exec/appointments/delete-appointment?id='+id,
                                    success:function(response){
                                        setTimeout(function(){
                                            return location.reload();
                                        }, 500);
                                    }
                            });
                        },
                        cancel: function () {
                            location.reload();
                        }
                    }
                });


            });
        //END

        });


    </script>
@endsection

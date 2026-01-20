
@extends('_layouts._dashboard')


@section('content')
    <div class="row pop-up-wrapper hide"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fas fa-calendar-alt"></i> Appointments Log
                <span class="h1-button" style="">
                    <a href="{{route('admin.appointment.show', $dealership->id)}}" class="btn btn-border sister"><i class="fas fa-angle-double-left mr-1"></i> Back </a>
                    <a href="{{route('admin.appointment.reception', [$dealership->id])}}" class="btn btn-border brother"><i class="fas fa-concierge-bell"></i> Reception </a>
                    <a href="{{route('admin.appointment.prospect', [$event->id, $dealership->id])}}" class="btn btn-border brother"><i class="fas fa-chalkboard-teacher mr-2"></i> Prospects</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')
    <div class="s-card shadow border-0">
        {{csrf_field()}}
        <input type="hidden" name="date" id="date" value="{{$date->date}}" date-id="{{$date->id}}" event-id="{{$date->event_id}}">

        <div class="s-card-header border-0">
            Appointments Log for {{$dealership->name}} - {{\Carbon\Carbon::parse($date->date)->isoFormat('dddd Do MMMM')}}
        </div>

        <div class="s-card-header bg-brother hide-mobile ">
            <div class="row bold">
                <div class="col-3 col-lg-1  border-right bold">Time</div>
                <div class="col-11">
                    <div class="row">
                        <div class="col-1  border-right  text-center">Edit</div>
                        <div class="col-3  border-right text-center">Customer</div>
                        <div class="col-2  border-right text-center">Phone</div>
                        <div class="col-2 border-right text-center">Booked With</div>
                        <div class="col-2  border-right text-center">Date Booked</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="s-card-body px-3 py-0">
            @foreach($times as $time)
                <div class="row s-card-row  line-height-30 normal ">
                    <div class="col-3 col-lg-1  border-right bold">{{$time->time}} </div>

                    <div class="col-11">
                        <div class="row ">
                            @forelse($appointments->where('event_time_id', $time->id) as $appointment)
                                {{--It's available for booking--}}
                                <div class="col-12">
                                    <div class="row border-bottom py-1">
                                        <div class="col-4 col-lg-1  border-right text-start text-lg-center">
                                            <a href="{{route('admin.edit.appointment', [$appointment->book->event_id, $appointment->dealership_id, $appointment->book->id])}}" title="Edit Booking" class="text-success"  time="{{$time->time}}" time-id="{{$time->id}}"><i class="fas fa-user-edit"></i> Edit</a>
                                        </div>

                                        <div class="col-4 col-lg-3  border-right  text-start text-md-center">
                                            {{ $appointment->book->title }} {{$appointment->book->name }} {{$appointment->book->surname }}
                                        </div>

                                        <div class="col-3 col-lg-2  border-right text-start text-lg-center">
                                            {{ $appointment->book->mobile }}
                                        </div>
                                        <div class="col-4 col-lg-2  border-right text-start text-md-center text-brand bold">@if(isset($appointment->exec->name)) {{$appointment->exec->name }} @else NULL @endif</div>
                                        <div class="col-4 col-lg-2  border-right text-start text-md-center">{{\Carbon\Carbon::parse($appointment->date)->format('d M Y')}}</div>
                                        <div class="col text-start text-md-end">
                                            @if(prospectIsBooked($appointment->book_id))
                                                @if(hasSale($appointment->book_id))
                                                    <span class="icon booked-circle alert-success "></span>
                                                @else
                                                    <a href="{{route('admin.sale.create', $appointment->id)}}" title="Add a Sale"><i class="fas fa-tags fs-120"></i></a>
                                                @endif
                                            @else
                                                ---
                                            @endif

                                            <a href="javascript:void(0)" appointment-id="{{$appointment->id }}" style="" class="btn btn-sm btn-border danger ms-1 js-delete-appointment fs-90" title="Delete Appointment"><i class="fa fa-trash text-danger fs-120"></i></a>
                                        </div>
                                    </div>
                                </div>

                            {{--There's no bookings--}}
                            @empty
                                <div class="col-4 col-lg-1  border-right text-md-center text-lg-center"> - - </div>
                                <div class="col-1 col-lg-3  border-right text-md-center"> - - </div>
                                <div class="col-1 col-lg-2  border-right text-md-center"> - - </div>
                                <div class="col-1 col-lg-2  border-right text-md-center"> - - </div>
                                <div class="col-1 col-lg-2  border-right text-md-center">  - - </div>
                                <div class="col text-center">   </div>
                            @endforelse
                        </div>
                    </div>

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

            //Delete Appointment
            $('.js-delete-appointment').click(function(){

                var item_id = $(this).attr('appointment-id');

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete Appointment?',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    var url = '{{ route('admin.delete.appointment', ":id") }}';
                                    url = url.replace(':id',item_id);
                                    window.location.href = url;

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

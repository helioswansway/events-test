@extends('_layouts._book-dashboard')

@section('styles')
    <link href="{{ URL::to('/') }}/assets/vendor/css/calendar.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

    @include('book.inc._messages')


    {{--END POP UP--}}
    <form action="{{route('book.part.exchange')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" id="appointment_id" name="appointment_id" value="{{$appointment->id}}">
        <input type="hidden" name="exec_id" id="exec_id" value="{{$appointment->exec_id}}">

        <div class="row justify-content-center">
            <h1 class="display-4 bold mb-0">Book your appointment</h1>
        </div>

        <div class="s-card mt-3">

            {{--Booking Details--}}
                <div class="p-3 shadow-sm alert-success rounded text-center bold hide js-message">Your booking details have been saved!</div>

                <div class="s-card-body alert-brand border-0  py-0">
                    <div class="row">
                        <div class="@if($event->inc_exec == 1) col-lg-4 @else col-lg-6 @endif mt-3">
                            <div id="date-group" class="row justify-content-center px-3">
                                <label class="pl-3 bold"><i class="fas fa-calendar-alt"></i> Select Date <span class="text-danger">*</span></label>
                                @foreach($dates as $date)
                                    <div class="col-lg-3 p-1">
                                        <div class="js-appointment-date
                                        @if($date->date == $appointment->date) current-date active @endif

                                        " date="{{$date->date}}" date-id="{{$date->id}}" event-id="{{$date->event_id}}" appointment-id="{{$appointment->id}}" dealership-id="{{$date->dealership_id}}">
                                            {{\Carbon\Carbon::parse($date->date)->format('d M')}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="@if($event->inc_exec == 1) col-lg-4 @else col-lg-6 @endif mt-3">
                            <div id="time-group" class="row justify-content-center px-3">
                                <div class="row justify-content-center js-appointment-time">
                                    <label  class="pl-3 bold"><i class="fas fa-clock"></i> Select Time Slot  <span class="text-danger">*</span></label>
                                    @foreach ($slots->slots($appointment->date, $appointment->dealership_id) as $slot)
                                        <div class="col-lg-3 p-1">
                                            <div class="js-time  @if($slot->id == $appointment->event_time_id) current-time active @endif"  time-id="{{$slot->id}}" appointment-id="{{$appointment->id}}" book-id="{{$appointment->book_id}}" event-id="{{$event->id}}" date-id="{{$slot->event_date_id}}" dealership-id="{{$slot->dealership_id}}">
                                                {{$slot->time}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if($event->inc_exec == 1)
                            <div class="col-lg-4 mt-3">
                                <div id="exec-group" class="row justify-content-center px-3">
                                    <div  class="row justify-content-center  @if($event->inc_exec == 1) js-appointment-exec @endif @if($appointment->exec_id == NULL) hide @endif">
                                        <label class="pl-3 bold"><i class="fas fa-user-tie"></i> @if($event->show_vehicles == 0) Select Vehicle @else Select Exec @endif <span class="text-danger">*</span></label>
                                        @foreach($execs as $exec)
                                            <div class="col-12 p-0">
                                                <div class=" @if($exec->id == $appointment->exec_id)js-exec current-exec active @endif @if(execAdminAppointment($appointment->event_time_id, $exec->id)) js-booked @else js-exec @endif
                                                            " time-id="{{$appointment->event_time_id}}" exec-id="{{$exec->id}}" event-id="{{$event->id}}" appointment-id="{{$appointment->id}}"  dealership-id="{{$dealership->id}}" >
                                                        {{$exec->name}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="js-error p-2 text-danger text-center bold"></div>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- <div class="row justify-content-center mt-4 py-4 border-top">
                        <div class="col-lg-4 text-center">
                            <label for="guest_friend" class="bold"> Are you thinking of bringing a friend?</label>
                            <div class="bold mt-2">
                                <div class="bold mt-2">
                                    <label >
                                        <input type="checkbox" id="friend_interest_yes" class="friend-interest" name="friend_interest" value="1"
                                        @if($appointment->friend_interest == 1) checked @endif
                                        > Yes
                                    </label>

                                    <label class="ml-2">
                                        <input type="checkbox" id="friend_interest_no" class="friend-interest" name="friend_interest" value="0"
                                        @if($appointment->friend_interest == 0) checked @endif
                                        > No
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 js-friend @if($appointment->friend_interest == 0) hide @endif mt-3 text-start">
                                <label for="" class="bold">Friend Name  </label>
                                <input placeholder="Enter your friends name" id="friend_name" type="text" class="mb-3 form-control form-control-lg" name="friend_name" value="{{$appointment->friend_name}}">
                                <label for="" class="bold">Friend Model Interest</label>
                                <input placeholder="Model Interest" id="model_interest" type="text" class="form-control form-control-lg " name="friend_model_interest" value="{{$appointment->friend_model_interest}}">
                            </div>

                        </div>
                    </div> --}}
                </div>
            {{--END Booking Details--}}

        </div>

        <div class="col-12 mt-3 text-center">
            @if($event->show_vehicles == 1)
                <a href="{{route('book.dashboard')}}" class="btn btn-border warning btn-radius-md mr-5"><i class="fas fa-arrow-left mr-3"></i>  Back</a>
            @endif
            <button type="submit" name="book_your_appointment_step_2" class="btn btn-border sister btn-radius-md ml-5">Next <i class="ml-3 fas fa-arrow-right"></i></button>
        </div>

    </form>

@endsection

@section('scripts')

    <script>

        $(function(){
                //Toggle friend-interest Checked box
                $("input[name='friend_interest']:checkbox").change(function() {
                if($(this).is(':checked')) {
                    if($(this).val() == '1'){
                        $('.js-friend ').removeClass('hide');
                    }else{
                        $('.js-friend ').addClass('hide');
                    }

                    $("input[name='friend_interest']:checkbox").prop("checked", false);
                    $("input[name='friend_interest']:checkbox").parent('label').removeClass("checked");
                    $(this).prop("checked", true);
                    $(this).parent('lavel').addClass('checked');
                }
                else{
                    $('.js-friend').addClass('hide');
                    $("input[name='friend_interest']").prop("checked", false);
                    $("input[name='friend_interest']").parent('label').removeClass('checked');
                }
            });

            //Toggle friend-interest Checked box
            $("input[name='friend_interest']:checkbox").change(function() {
                if($(this).is(':checked')) {
                    if($(this).val() == '1'){
                        $('.js-friend ').removeClass('hide');
                    }else{
                        $('.js-friend ').addClass('hide');
                    }

                    $("input[name='friend_interest']:checkbox").prop("checked", false);
                    $("input[name='friend_interest']:checkbox").parent('label').removeClass("checked");
                    $(this).prop("checked", true);
                    $(this).parent('lavel').addClass('checked');
                }
                else{
                    $('.js-friend').addClass('hide');
                    $("input[name='friend_interest']").prop("checked", false);
                    $("input[name='friend_interest']").parent('label').removeClass('checked');
                }
            });

            //Dates
            $('#date-group').on('click', '.js-appointment-date', function(){
                $('.js-appointment-exec').html("");
                $('#date-group .js-appointment-date ').removeClass('current-date active');
                $(this).addClass('current-date active');

                var dealership_id   =   $(this).attr('dealership-id');
                var date_id         =   $(this).attr('date-id');
                var event_id        =   $(this).attr('event-id');
                //alert(event_id + " - " + date_id + " - " + dealership_id);

                $.ajax({
                    url: '/book/appointments/get-times?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id,
                        success:function(response){
                            $('.js-appointment-time').html(response);
                        }
                });
            });

            //Time Slots
            $('#time-group').on('click', '.js-time', function(){
                $('#time-group .js-time').removeClass('current-time active');
                $('.js-appointment-exec').removeClass('hide');

                $(this).addClass('current-time active');

                var dealership_id   =   $(this).attr('dealership-id');
                var date_id         =   $(this).attr('date-id');
                var event_id        =   $(this).attr('event-id');
                var time_id         =   $(this).attr('time-id');
                //alert(time_id + " - " +event_id + " - " + date_id + " - " + dealership_id);

                $.ajax({
                    url: '/book/appointments/get-execs?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id+'&time_id='+time_id,
                        success:function(response){
                            $('.js-appointment-exec').html(response);
                        }
                });

            });

            //Save date and time if There's no exec
            $('#time-group').on('click', '.js-no-exec', function(){
                $('.js-error').html('');

                var appointment_id = $('#appointment_id').val();
                var date = $('.current-date').attr('date');
                var time_id = $('.current-time').attr('time-id');

                $.ajax({
                        success: function (response)
                        {

                            fetch('/book/appointment/store-no-exec',{
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({
                                    appointment_id: appointment_id,
                                    date: date,
                                    time_id: time_id


                                }),
                            })
                            .then((response) => response.json())
                            .then((response) => {
                                console.log(response);

                                //location.reload();


                            })
                            .catch(error => console.log('Error:' + error))

                        }
                    });


            })

            //Execs
            $('#exec-group').on('click', '.js-exec', function(){

                $('#exec-group .js-exec').removeClass('current-exec active js-booked');
                $(this).addClass('current-exec active');
                $('.js-exec-message').removeClass('alert-warning').html('Date, Time and Exec have been saved!')

                $('.js-error').html('');

                var appointment_id          =   $('#appointment_id').val();
                var date                    =   $('.current-date').attr('date');
                var time_id                 =   $('.current-time').attr('time-id');
                var exec_id                 =   $('.current-exec').attr('exec-id');

                if($(this).hasClass('js-booked')){

                }else{
                    $.ajax({
                        success: function (response)
                        {

                            fetch('/book/appointment/store',{
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({
                                    appointment_id: appointment_id,
                                    date: date,
                                    time_id: time_id,
                                    exec_id: exec_id,


                                }),
                            })
                            .then((response) => response.json())
                            .then((response) => {
                                console.log(response);

                                //location.reload();


                            })
                            .catch(error => console.log('Error:' + error))

                        }
                    });
                }
            });
    })

    /*Code here*/


    /**/

    </script>


    <script>

        /* Calendar Code here */

        /**/

    </script>



@endsection

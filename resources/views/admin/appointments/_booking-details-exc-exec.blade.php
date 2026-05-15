<div class="s-card shadow mt-5">
    <div class=" s-card-header bg-brand border-0 border-bottom px-3 py-3"><i class="fas fa-address-card mr-3"></i>   Booking Details </div>

    <div class="col-12 alert-brand border-0  py-3">
        <div class="row">
            <div class="col-lg-6 mt-3">
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

            <div class="col-lg-6 mt-3">
                <div id="time-group" class="row justify-content-center px-3">
                    <div class="row justify-content-center js-appointment-time">
                        <label  class="pl-3 bold"><i class="fas fa-clock"></i> Select Time Slot  <span class="text-danger">*</span></label>
                        @foreach ($slots->slots($appointment->date, $appointment->dealership_id) as $slot)
                            <div class="col-lg-3 p-1">
                                <div class="js-time @if($slot->id == $appointment->event_time_id) current-time active @endif"  time-id="{{$slot->id}}" appointment-id="{{$appointment->id}}" book-id="{{$appointment->book_id}}" event-id="{{$event_id}}" date-id="{{$slot->event_date_id}}" dealership-id="{{$slot->dealership_id}}">
                                    {{$slot->time}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <span class="js-error p-2 text-danger text-center"></span>
            </div>
        </div>

        <div class="col-12">
            <div class="row justify-content-center mt-3 py-3">
                <div class="col-lg-4 text-center ">
                    <label for="guest_friend" class="bold alert-sister block py-2 "> Is Prospect bringing a friend?</label>
                    <div class="bold mt-2">
                        <label for="friend_interest_yes">
                            <input type="checkbox" id="friend_interest_yes" class="friend-interest" name="friend_interest" value="1"
                            @if($appointment->friend_interest == 1) checked @endif
                            > Yes
                        </label>

                        <label for="friend_interest_no" class="ml-2">
                            <input type="checkbox" id="friend_interest_no" class="friend-interest" name="friend_interest" value="0"
                            @if($appointment->friend_interest == 0) checked @endif
                            > No
                        </label>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12 js-friend @if($appointment->friend_interest == 0) hide @endif mt-3 text-start">
                            <div class="border-top mb-3"></div>
                            <label for="friend_name" class="bold">Friend Name  </label>
                            <input placeholder="Enter your friends name" id="friend_name" type="text" class=" form-control form-control-lg" name="friend_name" value="{{$appointment->friend_name}}" autocomplete="off">
                            <div class="js-error p-2 text-danger text-center bold"></div>
                            <label for="model_interest" class="bold">Friend Model Interest</label>
                            <input placeholder="Friend Model Interest" id="friend_model_interest" type="text" class="mt-3 form-control form-control-lg " name="friend_model_interest" value="{{$appointment->friend_model_interest}}" autocomplete="off">
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

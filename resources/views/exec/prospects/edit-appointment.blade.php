@extends('_layouts._exec-dashboard')


@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-book-reader fs-110"></i> Edit Prospect Appointment for  [{{$dealership->name}}]
                <span class="h1-button" style="">
                    <a href="{{route('exec.prospect.index')}}" class="btn btn-sm btn-default brother px-3 py-1 "><i class="fas fa-angle-double-left mr-1"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="hidden" id="event_id" event-id="{{$event_id}}" value="{{$event_id}}" >
    <input type="hidden" id="dealership_id" name="dealership_id" value="{{$dealership->id}}" >

    {{--Prospect Details--}}
        <div class="s-card shadow">
            <div class=" s-card-header alert-brand border-0 ">
                <i class="fas fa-address-card mr-3"></i>   Prospect Details
            </div>

            <div class="s-card-body px-3 pt-2">
                <div class="row">
                    <div class="col-lg-4 mt-2">
                        <label for="book_id" class="bold">Customer Name <span class="text-danger">*</span></label>
                        <input id="book_id" type="text" class="form-control form-control-lg" book-id="{{$prospect->id}}" value="{{$prospect->title}} {{$prospect->name}} {{$prospect->surname}}"  disabled="">
                    </div>

                    <div class="col-lg-4 mt-2">
                        <label class="bold">Vehicle Registration</label>
                        <input type="text" class="form-control form-control-lg " value="{{$prospect->vehicle_reg}}" disabled >
                    </div>

                    <div class="col-lg-4 mt-2">
                        <label class="bold">Post Code</label>
                        <input type="text" class="form-control form-control-lg "  value="{{$prospect->post_code}}" disabled>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-lg-4 mt-3">
                        <label class="bold">Email  </label>
                        <input  type="text" class="form-control form-control-lg" value="{{$prospect->email}}"  disabled="">
                    </div>

                    <div class="col-lg-4 mt-3">
                        <label class="bold">Home Phone</label>
                        <input type="text" class="form-control form-control-lg "  value="{{$prospect->home_phone}}" disabled>
                    </div>

                    <div class="col-lg-4 mt-3">
                        <label class="bold">Mobile Number</label>
                        <input type="text" class="form-control form-control-lg "  value="{{$prospect->mobile}}" disabled>
                    </div>
                </div>
            </div>
        </div>
    {{--END Prospect Details--}}

    {{--Booking Details--}}
        <div class="s-card shadow mt-5">
            <div class=" s-card-header bg-brand border-0">
                <i class="fas fa-address-card mr-3"></i>   Booking Details
            </div>

            <div class="s-card-body alert-brand pt-0">
                <div class="row">
                    <div class="col-lg-6 mt-3 ">
                        <div id="date-group" class="row justify-content-center px-3">
                            <label class="ml-3 bold"><i class="fas fa-calendar-alt"></i> Select Date <span class="text-danger">*</span></label>
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
                            <div class="js-error p-2 text-danger text-center bold"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row justify-content-center mt-3 py-3">
                        <div class="col-lg-4 text-center ">
                            <label for="guest_friend" class="bold bg-white border-0 block py-2 mb-3"> Is Prospect bringing a friend?</label>
                            <div class="form-check form-check-inline">
                                <label for="friend_interest_yes" class="form-check-label">Yes</label>
                                <input type="checkbox" id="friend_interest_yes" class="form-check-input friend-interest" name="friend_interest" value="1"
                                @if($appointment->friend_interest == 1) checked @endif
                                >
                            </div>

                            <div class="form-check form-check-inline">
                                <label for="friend_interest_no" class="form-check-label">No</label>
                                <input type="checkbox" id="friend_interest_no" class="form-check-input friend-interest" name="friend_interest" value="0"
                                @if($appointment->friend_interest == 0) checked @endif
                                >
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-lg-12 js-friend @if($appointment->friend_interest == 0) hide @endif mt-3 text-start">
                                    <div class="border-top mb-3"></div>
                                    <label for="friend_name" class="bold">Friend Name  </label>
                                    <input placeholder="Enter your friends name" id="friend_name" type="text" class="form-control form-control-lg" name="friend_name" value="{{$appointment->friend_name}}" autocomplete="off">
                                    <div class="js-error p-2 text-danger text-center bold"></div>
                                    <label for="friend_model_interest" class="bold">Friend Model Interest</label>
                                    <input placeholder="Friend Model Interest" id="friend_model_interest" type="text" class="form-control form-control-lg " name="model_interest" value="{{$appointment->friend_model_interest}}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    {{--END Booking Details--}}

    {{--Part Exchange--}}
        <div class="s-card shadow mt-5">
            <div class=" s-card-header alert-brand border-0 border-bottom"><i class="fas fa-car mr-3"></i>   Part Exchange </div>

            <div class="s-card-body px-3 border-0">
                <div class="row ">
                    <div class="col-lg-4 mt-3">
                        <div class="v-reg mb-0">
                            <span>Registration Number:</span>
                            <input type="text" id="reg_number" name="reg_number" autocomplete="off">
                        </div>
                        <a href="javascript:void(0)" class="btn btn-action brother block mt-3 js-get-vehicle">Get Vehicle Details</a>
                    </div>

                    <div class="col-lg-4">
                        <div class="show-vehicle-details mt-3 @if($appointment->registration == "") hide @endif">
                            <div class="fs-100 p-2 rounded alert-brand lighter text-dark mt-1" >
                                <div class="mb-1">
                                    <span class="bold">Registration:</span> {{$appointment->registration}}
                                    <input type="hidden" name="registration_number" id="registration" class="form-control" value="">
                                </div>
                                <div class="mb-1">
                                    <span class="bold">Make:</span> {{$appointment->make}}
                                    <input type="hidden" name="make" id="make" class="form-control" disabled="">
                                </div>
                                <div class="mb-1">
                                    <span class="bold">Colour:</span> {{$appointment->colour}}
                                    <input type="hidden" name="colour" id="colour" class="form-control" disabled="">
                                </div>
                                <div class="mb-1">
                                    <span class="bold">Fuel Type:</span> {{$appointment->fuel_type}}
                                    <input type="hidden" name="fuel_type" id="fuel_type" class="form-control"  disabled="">
                                </div>
                            </div>

                            <div class="v-mileage mt-2">
                                <label for="mileage" class="bold border-bottom block">Mileage</label>
                                <input type="text" name="mileage" id="mileage" class="form-control alert-brand lighter" style="padding-left:10px!important" value="{{$appointment->mileage}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-3 no-part-exchange ">
                        <div class="col-lg-12 text-center">
                            <h2 class="fs-110 bold js-part-exchange @if($appointment->part_exchange != 1) active @endif ">Customer doesn't want to part exchange a vehicle</h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    {{--END Part Exchange--}}

    {{--Booking Preferences--}}
        <div class="s-card shadow mt-5">
            <div class=" s-card-header alert-brand border-0 border-bottom"><i class="fas fa-sliders-h"></i>   Booking Preferences </div>

            <div class="s-card-body px-3 pb-3">
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <label for="mobile" class="bold">Drink Preference</label>
                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                        <select name="drink" id="drink" class="form-control form-control-lg">
                            <option value="">--Select one--</option>
                            <option value="tea" @if($appointment->drink == "tea") selected @endif>Tea</option>
                            <option value="coffee" @if($appointment->drink == "coffee") selected @endif>Coffee</option>
                            <option value="water" @if($appointment->drink == "water") selected @endif>Water</option>
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <label for="preference" class="bold">Milk/Sugar etc</label>
                        <input   id="preference" type="text" class="form-control form-control-lg" name="preference" value="{{$appointment->preference}}" autocomplete="off" >
                    </div>
                </div>

                <div class="s-card-body mt-3 px-3 alert-brand">
                    <div class="row">
                        <div class="col-12 bold">
                            <label for="model_interest">Model Interest</label>
                            <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            <select name="model_interest" id="model_interest" class="form-control form-control-lg">
                                <option value="">--Select one--</option>
                                <option value="new" @if($appointment->model_interest == "new") selected @endif>New</option>
                                <option value="used" @if($appointment->model_interest == "used") selected @endif>Used</option>
                                <option value="either" @if($appointment->model_interest == "either") selected @endif>Either</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 bold">
                            <label for="model_interest">Vehicles</label>
                            <div class="row text-center js-models">
                                @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                                    <div class="col-lg-2 mb-4">
                                        <a href="javascript:void(0)"  class="mb-2 bg-white js-select-vehicles">
                                            <img class="border block
                                                @if(isset($appointment->vehicles))
                                                    @php $obj = json_decode($appointment->vehicles, true); @endphp
                                                    @foreach($obj as $key => $value)
                                                        @if($value == $vehicle->id) active @endif
                                                    @endforeach
                                                @endif

                                            " data-vehicle="{{$vehicle->id}}"  src="{{asset('assets/images/public/general')}}/{{$vehicle->filename}}" alt="">
                                        </a>
                                        <div class="py-1 bold border-bottom">{{$vehicle->name}}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

           </div>
        </div>
    {{--END Booking Preferences--}}

    {{--Prospect Progress--}}
        <div class="s-card shadow mt-5">
            <div class="s-card-header bg-brother"><i class="fas fa-address-card mr-1"></i>   Prospect Progress </div>

            <div class="s-card-body alert-brother px-3 py-3">
                <div class="row pb-3">
                    <div class="col-12 bold ">
                        <label for="call_attempts">Call Attempts</label>
                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                        <select name="call_attempts" id="call_attempts" class="form-control form-control-lg">
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

                <div class="row border-top border-left-0 border-right-0 border-bottom-0 py-2 alert-brand">
                    <div class="col-lg-4 bold  border-end pb-1 pt-2">
                        <div class="form-check form-check-inline">
                            <label for="call_made" class="form-check-label">Call Made</label>
                            <input type="checkbox" id="call_made" class="form-check-input js-call_made" name="call_made" value="1"
                                @if($appointment->call_made == 1) checked @endif
                            >
                        </div>
                        <span class="js-error p-2 text-danger text-center"></span>
                    </div>

                    <div class="col-lg-4 bold  border-end pb-1 pt-2">
                        <div class="form-check form-check-inline">
                            <label for="call_back" class="form-check-label">Call back required</label>
                            <input type="checkbox" id="call_back" class="form-check-input js-call_back" name="call_back" value="1"
                                @if($appointment->call_back == 1) checked @endif
                            >
                        </div>
                    </div>

                    <div class="col-lg-4 bold  pb-1 pt-2">
                        <div class="form-check form-check-inline">
                            <label for="message_left" class="form-check-label">Message Left</label>
                            <input type="checkbox" id="message_left" class="form-check-input js-message_left" name="message_left" value="1"
                                @if($appointment->message_left == 1) checked @endif
                            >
                        </div>
                    </div>

                </div>

                <div class="row border-top border-bottom py-3">
                    <div class="col-lg-4 bold text-end border-end pb-1 pt-2">
                        Appointment Status:
                    </div>
                    <div class="col border-end pb-1 pt-2">
                        <div class="form-check form-check-inline">
                            <label for="confirm" class="form-check-label">Confirm</label>
                            <input type="checkbox" id="confirm" class="form-check-input js-confirm" name="confirm" value="@if($appointment->confirm == 1) 1 @else 0 @endif" @if($appointment->confirm == 1) checked @endif >
                        </div>

                        <div class="form-check form-check-inline">
                            <label for="cancelled" class="form-check-label">Cancelled</label>
                            <input type="checkbox" id="cancelled" class="form-check-input js-cancelled" name="cancelled" value="@if($appointment->cancelled == 1) 1 @else 0 @endif" @if($appointment->cancelled == 1) checked @endif >
                        </div>

                        <div class="form-check form-check-inline">
                            <label for="not_interested" class="form-check-label">Not Interested</label>
                            <input type="checkbox" id="not_interested" class="form-check-input js-not-interested" name="not_interested" value="@if($appointment->not_interested == 1) 1 @else 0 @endif" @if($appointment->not_interested == 1) checked @endif >
                        </div>

                        <div class="form-check form-check-inline">
                            <label for="in_progress" class="form-check-label">In Progress</label>
                            <input type="checkbox" id="in_progress" class="form-check-input js-in-progress" name="in_progress" value="@if($appointment->in_progress == 1) 1 @else 0 @endif" @if($appointment->in_progress == 1) checked @endif >
                        </div>

                        <div class="js-confirm-status rounded fs-80 alert-success mt-2 px-2 py-1 @if($appointment->confirm == 0) hide @endif"> Appointment has been Confirmed </div>
                        <div class="js-cancel-status text-danger rounded fs-80 alert-danger mt-2 px-2 py-1 @if($appointment->cancelled == 0) hide  @endif"> Appointment has been Cancelled </div>
                        <div class="js-not-interested-status text-dark rounded fs-80 alert-warning mt-2 px-2 py-1 @if($appointment->not_interested == 0) hide @endif"> Customer isn't interested in coming to the Event </div>
                        <div class="js-in-progress-status text-dark rounded fs-80 alert-info mt-2 px-2 py-1 hide"> Please, make notes of appointment status.</div>

                    </div>
                </div>

                <div class="row gx-5 border-bottom mt-2">
                    <div class="col-12 bold border-end">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="8" class="form-control form-control-lg">{{$appointment->notes}}</textarea>
                        <div class="js-error p-2 text-danger text-center bold"></div>
                    </div>
                </div>

                {{--
                    <div class="col-lg-12 text-center">
                        <label for="send_email" class=" text-brand">
                            <input type="checkbox" class="js-send-email" id="send_email" name="send_email"><strong> Send Notification Email to Customer</strong></small>
                        </label>
                    </div>
                --}}

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <a href="javascript:void(0)"class="btn btn-action brother block js-submit-appointment @if($appointment->confirm == 1) @else hide @endif">Save Appointment</a>
                        <a href="javascript:void(0)"class="btn btn-action sister block js-submit-not-interested @if($appointment->not_interested == 1) @else hide @endif">Save Appointment</a>
                        <a href="javascript:void(0)"class="btn btn-action danger block js-submit-cancelled @if($appointment->cancelled == 1) @else hide @endif">Save Appointment</a>
                        <a href="javascript:void(0)"class="btn btn-action warning block js-submit-in-progress  @if($appointment->confirm == 0 && $appointment->cancelled == 0 && $appointment->not_interested == 0) @else hide @endif">Save Appointment</a>
                    </div>
                </div>

            </div>
        </div>
    {{--END Prospect Progress--}}

@endsection


@section('scripts')
    @if($appointment->completed != 1)
        <script>

            $(function(){

                //toggles between call made and call back required (unchecks call_back)
                $('.js-call-made').click(function(){
                    $(this).val(1)
                    if($('.js-call-back').prop('checked')){
                        $('.js-call-back').prop('checked', function(_, checked) {
                            $(this).val(0)
                            return !checked;
                        });
                    }else{

                    }
                });

                //Hides execs if no time selected
                if(!$(".current-exec")[0]){
                    $('.js-appointment-exec').html("");
                }

                //toggles between call back required and call made (unchecks call_made)
                $('.js-call-back').click(function(){
                    $(this).val(1)
                    if($('.js-call-made').prop('checked')){

                        $('.js-call-made').prop('checked', function(_, checked) {
                            $(this).val(0)
                            return !checked;
                        });
                    }else{

                    }
                });

                //Empties vehicles details container if clicled no vehicle exchange
                $('.js-part-exchange').click(function(){
                    $('.show-vehicle-details').html('');
                    $('#reg_number').val('')
                    $('.v-reg span').removeClass('slide-up')

                    $(this).addClass('active');
                });

                //toggles between Confirm and Cancelled
                $('.js-confirm').click(function(){
                    $(this).val(1)
                    $('.js-confirm-status').removeClass('hide');
                    $('.js-not-interested-status, .js-in-progress-status').addClass('hide');
                    $('.js-cancel-status').addClass('hide');
                    $('.js-appointment-status').addClass('hide');

                    $('.js-appointment-status').html('');
                    $('#appointment_status').removeAttr('checked');
                    $('.js-submit-appointment').removeClass('hide disabled');
                    $('.js-submit-not-interested').addClass('hide');
                    $('.js-submit-cancelled').addClass('hide');
                    $('.js-submit-in-progress').addClass('hide');

                    var checkbox = $(this);
                    if (checkbox.is(":checked")) {
                        if($('.js-cancelled').prop('checked')){

                        $('.js-cancelled').prop('checked', function(_, checked) {
                            $(this).val(0)
                            $('.js-not-interested').val(0)
                            return !checked;
                        });
                        }

                        if($('.js-not-interested').prop('checked')){
                            $('.js-not-interested').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                        if($('.js-in-progress').prop('checked')){

                            $('.js-in-progress').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                    } else {
                    // prevent from being unchecked
                        this.checked=!this.checked;
                    }
                });

                //Mark if customer is or not interested
                $('.js-not-interested').click(function(){
                    $(this).val(1)
                    $('.js-not-interested-status').removeClass('hide');
                    $('.js-confirm-status, .js-in-progress-status').addClass('hide');
                    $('.js-cancel-status, .js-in-progress-status').addClass('hide');
                    $('.js-appointment-status').addClass('hide');


                    $('.js-appointment-status').html('');
                    $('#appointment_status').removeAttr('checked');
                    $('.js-submit-appointment').addClass('hide');
                    $('.js-submit-cancelled').addClass('hide');
                    $('.js-submit-not-interested').removeClass('hide');
                    $('.js-submit-in-progress').addClass('hide');

                    var checkbox = $(this);
                    if (checkbox.is(":checked")) {

                        if($('.js-confirm').prop('checked')){

                            $('.js-confirm').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                            }

                            if($('.js-cancelled').prop('checked')){

                                $('.js-cancelled').prop('checked', function(_, checked) {
                                    $(this).val(0)
                                    return !checked;
                                });
                            }
                            if($('.js-in-progress').prop('checked')){

                                $('.js-in-progress').prop('checked', function(_, checked) {
                                    $(this).val(0)
                                    return !checked;
                                });
                            }


                    } else {
                    // prevent from being unchecked
                        this.checked=!this.checked;
                    }

                });

                //Toggles between Cancelled and Confirm
                $('.js-cancelled').click(function(e){
                    $(this).val(1)
                    $('.js-cancel-status').removeClass('hide');
                    $('.js-confirm-status, .js-in-progress-status').addClass('hide');
                    $('.js-not-interested-status').addClass('hide');
                    $('.js-appointment-status').addClass('hide');
                    $('.js-appointment-status').html('');
                    $('#appointment_status').removeAttr('checked');
                    $('.js-submit-appointment').addClass('hide');
                    $('.js-submit-not-interested').addClass('hide');
                    $('.js-submit-cancelled').removeClass('hide');
                    $('.js-submit-in-progress').addClass('hide');

                    var checkbox = $(this);
                    if (checkbox.is(":checked")) {

                        if($('.js-confirm').prop('checked')){

                            $('.js-confirm').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                        if($('.js-not-interested').prop('checked')){

                            $('.js-not-interested').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                        if($('.js-in-progress').prop('checked')){

                            $('.js-in-progress').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                    } else {
                    // prevent from being unchecked
                        this.checked=!this.checked;
                    }

                });

                                //Toggles between Cancelled and Confirm
                $('.js-in-progress').click(function(e){
                    $('.js-in-progress-status').removeClass('hide');
                    $('.js-confirm-status, .js-appointment-status, .js-cancel-status, .js-not-interested-status').addClass('hide');

                    $('.js-appointment-status').html('');
                    $('#appointment_status').removeAttr('checked');
                    $('.js-submit-appointment').addClass('hide');
                    $('.js-submit-not-interested').addClass('hide');
                    $('.js-submit-cancelled').addClass('hide');
                    $('.js-submit-in-progress').removeClass('hide');

                    var checkbox = $(this);
                    if (checkbox.is(":checked")) {

                        if($('.js-confirm').prop('checked')){

                            $('.js-confirm').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                        if($('.js-not-interested').prop('checked')){

                            $('.js-not-interested').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                        if($('.js-cancelled').prop('checked')){

                            $('.js-cancelled').prop('checked', function(_, checked) {
                                $(this).val(0)
                                return !checked;
                            });
                        }

                    } else {
                    // prevent from being unchecked
                        this.checked=!this.checked;
                    }

                });

                // Adds a value to the checkbox on click
                $('#message_left').click(function(){
                    if($('#message_left').is(':checked'))
                    {
                        $(this).val(1)
                    }else
                    {
                        $(this).val(0)
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
                    $('#date-group .js-appointment-date ').removeClass('current-date active');
                    $(this).addClass('current-date active');

                    var dealership_id   =   $(this).attr('dealership-id');
                    var date_id         =   $(this).attr('date-id');
                    var event_id        =   $(this).attr('event-id');

                    $.ajax({
                        url: '/exec/prospects/get-times?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id,
                            success:function(response){
                                $('.js-appointment-time').html(response);
                            }
                    });

                });

                //Time Slots
                $('#time-group').on('click', '.js-time', function(){
                    $('#time-group .js-time, #time-group .js-time-booked').removeClass('current-time bg-sister text-white active');

                    $(this).addClass('current-time active');
                    $('.js-error').html('');

                });

            });

            //toggles class .active when selecting vehicles
            $('.js-models a img').click(function(){
                // alert(0);
                $(this).toggleClass('active');
            });

            $('.v-reg input').focus(function(){
                $('.v-reg span').addClass('slide-up');
                $('.js-get-vehicle').removeClass('hide');
            });

            //Gets vehicle details if theres a part exchange
            //It will return Customer vehicle details from DVLA
            $('.js-get-vehicle').click(function(){

                $(this).addClass('disabled'); //Disables button
                $('.js-part-exchange').removeClass('active'); //Removes Active class
                $('.show-part-exchange-details').addClass('hide');

                //Gets Registration number that was entered
                var reg_number  =   $('#reg_number').val();

                if(reg_number === ""){
                    var message = `<div class="col-12 alert-danger lighter py-1 mt-1 bold rounded">Please enter a valid Registration!</div>`
                    $('.js-get-vehicle').removeClass('disabled');
                    $('.show-vehicle-details').removeClass('hide').html(message)
                }else{
                    //Fetchs all the execs that belongs to the selected dealership
                    fetch('/book/show-vehicle-details',{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            reg_number: reg_number,
                        }),
                    })
                    .then((response) => response.json())
                    .then((response) => {
                        console.log(response);

                        if(response == '404'){
                                var message = `<div class="col-12 alert-danger lighter py-1 mt-1 bold rounded">Vehicle <span class="normal fs-120 text-danger">"${reg_number}"</span>  doesn't seem to exist.<br> Please try again!</div>`
                                $('.js-get-vehicle').removeClass('disabled');
                                $('.show-vehicle-details').removeClass('hide').html(message)

                            }else{

                                const html = response.map(item => {
                                    return `
                                            <div class="fs-100 p-2 rounded alert-brother lighter text-dark mt-1">
                                                <div class="line-height-20">
                                                    <span class="bold">Registration:</span> ${item.registration}
                                                    <input type="hidden" name="registration_number" id="registration" class="form-control" value="${item.registration}">
                                                </div>
                                                <div class="">
                                                    <span class="bold">Make:</span> ${item.make}
                                                    <input type="hidden" name="make" id="make" class="form-control" value="${item.make}" disabled>
                                                </div>
                                                <div class="">
                                                    <span class="bold">Colour:</span> ${item.primaryColour}
                                                    <input type="hidden" name="colour" id="colour" class="form-control" value="${item.primaryColour}" disabled>
                                                </div>
                                                <div class="">
                                                    <span class="bold">Fuel Type:</span> ${item.fuelType}
                                                    <input type="hidden" name="fuel_type" id="fuel_type" class="form-control" value="${item.fuelType}" disabled>
                                                </div>
                                            </div>

                                        <div class="v-mileage mt-3">
                                            <input type="text" name="mileage" id="mileage" class="form-control" placeholder="Enter your approximate Mileage">
                                        </div>


                                    `

                                    })
                                    $('.js-get-vehicle').removeClass('disabled');
                                    $('.show-vehicle-details').removeClass('hide').html(response)
                                    document.querySelector('.show-vehicle-details').insertAdjacentHTML("afterbegin", html)
                                    partExchange()
                        }

                    })
                    .catch(error => console.log('Error:' + error))
                }


            })


            function partExchange(){
                //Saves all vehicle details
                $('.js-part-exchange-details').click(function(){
                    var registration_number     =   $('#registration').val();
                    var make                    =   $('#make').val();
                    var colour                  =   $('#colour').val();
                    var fuel_type               =   $('#fuel_type').val();
                    var appointment_id          =   $('#appointment_id').val();
                    var mileage                 =   $('#mileage').val();

                    var attr = $(this).attr('item');


                    //If .js-part-exchange has .active class it will redirect to next page with no further action
                    if($('.js-part-exchange').hasClass('active')){
                        window.location.replace("/book/confirm-details");
                    }else{
                        fetch('/book/part-exchange-details',{
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: JSON.stringify({
                                registration_number: registration_number,
                                make: make,
                                colour: colour,
                                fuel_type: fuel_type,
                                appointment_id: appointment_id,
                                mileage: mileage,
                            }),
                        })
                        .then((response) => response.json())
                        .then((response) => {
                            console.log(response);
                            //window.location.replace("/book/part-exchange");

                            if(attr == "save"){
                                //location.reload();
                            }else{
                                window.location.replace("/book/confirm-details");
                            }


                            //alert("Success");
                            //$('.show-vehicle-details').removeClass('hide').html(response)

                        })
                            .catch(error => console.log('Error:' + error))
                    }
                })

            }

            partExchange()

            //Save appointment
            $('.js-submit-appointment').click(function(){
                    $("input[name='optradio']:checked").val();
                    var appointment_id          =  $('.js-appointment-date').attr('appointment-id');
                    var dealership_id           =  $('#dealership_id').val();
                    var event_id                =  $('#event_id').attr('event-id');

                    var call_attempts           =  $('#call_attempts').val();
                    var call_made               =  $('#call_made').val();
                    var call_back               =  $('#call_back').val();
                    var message_left            =  $('#message_left').val();

                    var confirm                 =  $('#confirm').val();
                    var cancelled               =  $('#cancelled').val();
                    var not_interested          =  $('#not_interested').val();

                    //alert(confirm + " " +cancelled + " " +not_interested + " " )

                    var book_id                 =   $('#book_id').attr('book-id');
                    var date                    =   $('.current-date').attr('date');
                    var time_id                 =   $('.current-time').attr('time-id');


                    if ($('#friend_interest_yes').is(":checked")){
                        var friend_interest         =   1;

                    }else{
                        var friend_interest         =   0;
                    }


                    var friend_name             =   $('#friend_name').val();
                    var friend_model_interest   =   $('#friend_model_interest').val();



                    var registration            =   $('#registration').val();
                    var make                    =   $('#make').val();
                    var colour                  =   $('#colour').val();
                    var fuel_type               =   $('#fuel_type').val();
                    var mileage                 =   $('#mileage').val();


                    var model_interest          =   $('#model_interest').val();
                    var drink                   =   $('#drink').val();
                    var preference              =   $('#preference').val();


                    var vehicles                =   $('.js-select-vehicles img.active');
                    var vehicles                =   $.map(vehicles, e => $(e).attr('data-vehicle'));

                    var notes                   =   $('#notes').val();

                    //alert("appointment_id:" + appointment_id + "call_attempts:" + call_attempts + " Calls Made:"+ call_made + " Call Back:"+ call_back + " Message Left:"+ message_left + " Confirm:"+ confirm + " Not Intereted:"+ not_interested + " Cancelled:"+ cancelled + " Vehicles:"+ vehicles)

                    if($('.no-part-exchange  h2').hasClass('active')){
                        var part_exchange =   0;
                    }else{
                        var part_exchange =   1;
                    }

                    //Checks if Time was selected
                    if($(".current-time")[0]){

                        if($('#friend_interest_yes').is(":checked") && $('#friend_name').val() == ""){
                            if($('#friend_name').val() == ""){
                                //scrool to where the error is
                                var friendPosition = $('#friend_name').offset();
                                $('html, body').animate({scrollTop: friendPosition.top}, "slow");
                                $('#friend_name').addClass('border-danger').next('.js-error').html('* Friend Name\'s required')

                            }

                        }else{

                            fetch('/exec/appointments/update-appointment',{
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({
                                    appointment_id: appointment_id,
                                    dealership_id: dealership_id,
                                    event_id: event_id,
                                    book_id: book_id,

                                    date: date,
                                    time_id: time_id,


                                    friend_interest: friend_interest,
                                    friend_name: friend_name,
                                    friend_model_interest: friend_model_interest,

                                    registration: registration,
                                    make: make,
                                    colour: colour,
                                    fuel_type: fuel_type,
                                    mileage: mileage,
                                    part_exchange: part_exchange,
                                    model_interest: model_interest,
                                    drink: drink,
                                    preference: preference,
                                    vehicles: vehicles,

                                    confirm: confirm,
                                    cancelled: cancelled,
                                    not_interested: not_interested,

                                    call_attempts: call_attempts,
                                    call_made: call_made,
                                    call_back: call_back,
                                    message_left: message_left,

                                    notes: notes

                                }),
                            })
                            .then((response) => response.json())
                            .then((response) => {
                                //console.log(response);

                                //Notifies user that changes have been saved

                                /**/
                                $.confirm({
                                    title: '<span class="text-brand">Success!</span>',
                                        content: 'Appointment has been updated, go to...',

                                        buttons: {
                                            tryAgain: {
                                                text: 'Prospects page',
                                                btnClass: 'btn-action brand fs-80',
                                                action: function(){
                                                window.location.href = '/exec/prospects';
                                                }

                                            },
                                            heyThere: {
                                                text: 'Appointments page', // text for button
                                                btnClass: 'btn-action sister fs-80', // class for the button

                                                action: function(heyThereButton){
                                                    window.location.href = '/exec/appointments';

                                                }
                                            },
                                        }
                                });




                            })
                            .catch(error => console.log('Error:' + error))
                        }

                    //alert(event_id + " - " +dealership_id + " - " +part_exchange + " - " +registration + " - " + make + " - " + colour + " - " + fuel_type + " - " + mileage + " - " + book_id + " - " + date + " - " + time_id + " - " + exec_id + " - " + vehicles + " - " + model_interest + " - " + drink + " - " + preference+ " - " + notes )
                    }else{
                        //scrool to where the error is
                        var execPosition = $('#time-group').offset();
                        $('html, body').animate({scrollTop: execPosition.top}, "slow");
                        $('.js-appointment-time').addClass('border-danger').next('.js-error').html('* Time Slot needs to be selected')

                    }


            })

            $('.js-submit-not-interested').click(function(){

                var dealership_id           =   $('#dealership_id').val();
                var event_id                =   $('#event_id').attr('event-id');
                var book_id                 =   $('#book_id').attr('book-id');
                var notes                   =   $('#notes').val();
                var call_attempts           =   $('#call_attempts').val();
                var call_made               =   $('#call_made').val();
                var call_back               =   $('#call_back').val();
                var message_left            =   $('#message_left').val();



                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to mark Prospect as Not Interested',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {

                                    fetch('/exec/appointments/not-interested',{
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                            'X-Requested-With': 'XMLHttpRequest',
                                        },
                                        body: JSON.stringify({
                                            dealership_id: dealership_id,
                                            event_id: event_id,
                                            book_id: book_id,

                                            call_attempts: call_attempts,
                                            call_made: call_made,
                                            call_back: call_back,
                                            message_left: message_left,
                                            notes: notes

                                        }),
                                    })
                                    .then((response) => response.json())
                                    .then((response) => {
                                        //console.log(response);
                                        /**/
                                        $.confirm({
                                            title: '<span class="text-brand">Success!</span>',
                                            content: 'Prospect Saved has been save Not Interested',

                                            buttons: {
                                                tryAgain: {
                                                    text: 'Prospects page',
                                                    btnClass: 'btn-action brand fs-80',
                                                    action: function(){
                                                        window.location.href = '/exec/prospects' ;
                                                    }

                                                },
                                                heyThere: {
                                                    text: 'Appointments page', // text for button
                                                    btnClass: 'btn-action sister fs-80', // class for the button

                                                    action: function(heyThereButton){
                                                        window.location.href = '/exec/appointments';

                                                    }
                                                },
                                            }
                                        });


                                    })
                                    .catch(error => console.log('Error:' + error))

                                }
                            });
                        },
                        cancel: function () {
                            location.reload();
                        }
                    }
                });
            });

            $('.js-submit-cancelled').click(function(){
                var dealership_id           =   $('#dealership_id').val();
                var event_id                =   $('#event_id').attr('event-id');
                var book_id                 =   $('#book_id').attr('book-id');
                var notes                   =   $('#notes').val();
                var call_attempts           =   $('#call_attempts').val();
                var call_made               =   $('#call_made').val();
                var call_back               =   $('#call_back').val();
                var message_left            =   $('#message_left').val();

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to CANCEL Prospect appointment',
                    buttons: {
                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {
                                    fetch('/exec/appointments/cancelled',{
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                            'X-Requested-With': 'XMLHttpRequest',
                                        },
                                        body: JSON.stringify({
                                            dealership_id: dealership_id,
                                            event_id: event_id,
                                            book_id: book_id,

                                            call_attempts: call_attempts,
                                            call_made: call_made,
                                            call_back: call_back,
                                            message_left: message_left,
                                            notes: notes

                                        }),
                                    })
                                    .then((response) => response.json())
                                    .then((response) => {
                                        //console.log(response);
                                        /**/
                                        $.confirm({
                                            title: '<span class="text-brand">Success!</span>',
                                            content: 'Prospect Saved has been save Not Interested',

                                            buttons: {
                                                tryAgain: {
                                                    text: 'Prospects page',
                                                    btnClass: 'btn-action brand fs-80',
                                                    action: function(){
                                                        window.location.href = '/exec/prospects' ;
                                                    }

                                                },
                                                heyThere: {
                                                    text: 'Appointments page', // text for button
                                                    btnClass: 'btn-action sister fs-80', // class for the button

                                                    action: function(heyThereButton){
                                                        window.location.href = '/exec/appointments' ;

                                                    }
                                                },
                                            }
                                        });

                                    })
                                    .catch(error => console.log('Error:' + error))

                                }
                            });
                        },
                        cancel: function () {
                            location.reload();
                        }
                    }
                });

            });

            $('.js-submit-in-progress').click(function(){
                var dealership_id           =   $('#dealership_id').val();
                var event_id                =   $('#event_id').attr('event-id');
                var book_id                 =   $('#book_id').attr('book-id');
                var notes                   =   $('#notes').val();
                var call_attempts           =   $('#call_attempts').val();
                var call_made               =   $('#call_made').val();
                var call_back               =   $('#call_back').val();
                var message_left            =   $('#message_left').val();


                if(!$('#call_made').prop('checked') && !$('#call_back').prop('checked')){
                        //scrool to where the error is
                        var call_made = $('#call_made').offset();
                        $('html, body').animate({scrollTop: notes.top}, "slow");
                        $('#call_made').addClass('border-danger').next('.js-error').html('* You need to make a call.')

                } else if($('#notes').val() == ""){
                        //scrool to where the error is
                        var notes = $('#notes').offset();
                        $('html, body').animate({scrollTop: notes.top}, "slow");
                        $('#notes').addClass('border-danger').next('.js-error').html('* You\'re required to add notes.')

                    }else{

                        $.confirm({
                            title: 'Confirm!',
                            content: 'Are you sure you want to submit changes?',
                            buttons: {

                                confirm: function (e) {
                                    $.ajax({
                                        success: function (response)
                                        {
                                            fetch('/exec/appointments/in-progress',{
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                },
                                                body: JSON.stringify({
                                                    dealership_id: dealership_id,
                                                    event_id: event_id,
                                                    book_id: book_id,


                                                    call_attempts: call_attempts,
                                                    call_made: call_made,
                                                    call_back: call_back,
                                                    message_left: message_left,
                                                    notes: notes

                                                }),
                                            })
                                            .then((response) => response.json())
                                            .then((response) => {
                                                //console.log(response);
                                                /**/
                                                $.confirm({
                                                    title: '<span class="text-brand">Success!</span>',
                                                    content: 'Changes has been made!',

                                                    buttons: {
                                                        tryAgain: {
                                                            text: 'Prospects page',
                                                            btnClass: 'btn-action brand fs-80',
                                                            action: function(){
                                                                window.location.href = '/exec/prospects' ;
                                                            }

                                                        },
                                                        heyThere: {
                                                            text: 'Appointments page', // text for button
                                                            btnClass: 'btn-action sister fs-80', // class for the button

                                                            action: function(heyThereButton){
                                                                window.location.href = '/exec/appointments';

                                                            }
                                                        },
                                                    }
                                                });

                                            })
                                            .catch(error => console.log('Error:' + error))
                                        }
                                    });
                                },
                                cancel: function () {
                                    location.reload();
                                }
                            }
                        });
                    }

            });

        </script>
    @endif
@endsection

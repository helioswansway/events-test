@extends('_layouts._dashboard')


@section('content')

    <div class="pop-up-wrapper-spin d-flex justify-content-center hide">
        <div class="align-self-center text-center">
            <p class="text-white bold"> Please be patient, your request is being processed! </p>
            <i class="fas fa-spinner fa-spin fs-300 text-white"></i>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-book-reader fs-110"></i> Register Prospect for [{{$dealership->name}}]
                <span class="h1-button" style="">
                    <a href="{{route('admin.appointment.prospect', [$event_id, $dealership_id] )}}" class="btn btn-border sister"><i class="fas fa-angle-double-left mr-1"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <form action="{{route('admin.appointment.store.prospect')}}" enctype="multipart/form-data" method="POST">
        {{csrf_field()}}
        <input type="hidden" id="event_id" name="event_id" value="{{$event_id}}" >
        <input type="hidden" id="dealership_id" name="dealership_id" value="{{$dealership->id}}" >

        {{--Prospect Details--}}
            <div class="s-card shadow">
                <div class="s-card-header bg-brother border-0 border-bottom"><i class="fas fa-address-card mr-1"></i>  Enter Prospect Details </div>

                <div class="s-card-body px-3 pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-2">
                            <label for="title" class="bold">Title <span class="text-danger">*</span></label>
                            <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            <select name="title" id="title" class=" form-control form-control-lg" required>
                                <option value="">--Select one--</option>
                                <option value="Mr" @if(old('title') && old('title') == "Mr") selected @endif>Mr</option>
                                <option value="Ms" @if(old('title') && old('title') == "Ms") selected @endif>Ms</option>
                                <option value="Miss" @if(old('title') && old('title') == "Miss") selected @endif>Miss</option>
                                <option value="Mrs" @if(old('title') && old('title') == "Mrs") selected @endif>Mrs</option>
                            </select>
                            <div class="js-error  text-danger bold"></div>
                        </div>
                        <div class="col-lg-4 mt-2">
                            <label for="name" class="bold">First Name <span class="text-danger">*</span></label>
                            <input id="name" name="name" type="text" class="form-control form-control-lg" value="{{old('name')}}" required>
                            <div class="js-error  text-danger bold"></div>
                        </div>

                        <div class="col-lg-4 mt-2">
                            <label for="surname" class="bold">Surname <span class="text-danger">*</span></label>
                            <input id="surname" id="surname" name="surname" type="text" class="form-control form-control-lg" value="{{old('surname')}}" required>
                            <div class="js-error text-danger bold"></div>
                        </div>
                    </div>

                    <div class="row py-2">
                        <div class="col-lg-4">
                            <label class="bold">Email</label>  <span class="text-danger">*</span>
                            <input  type="email" id="email" name="email" class="form-control form-control-lg" value="{{old('email')}}" required>
                            <div class="js-error text-danger bold"></div>
                        </div>

                        <div class="col-lg-4">
                            <label class="bold">Home Phone</label>
                            <input type="text" id="home_phone" name="home_phone" class="form-control form-control-lg "  value="{{old('home_phone')}}">
                        </div>

                        <div class="col-lg-4">
                            <label class="bold">Mobile Number</label> <span class="text-danger">*</span>
                            <input type="text" id="mobile" name="mobile" class="form-control form-control-lg "  value="{{old('mobile')}}" required>
                            <div class="js-error  text-danger bold"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 ">
                            <label class="bold">Address: </label>
                            <input  type="text" id="address_1" name="address_1" class="form-control form-control-lg" value="{{old('address_1')}}">
                            <div class="js-error text-danger bold"></div>
                        </div>

                        <div class="col-lg-4 ">
                            <label class="bold">Address 2:</label>
                            <input type="text" id="address_2" name="address_2" class="form-control form-control-lg "  value="{{old('address_2')}}">
                        </div>

                        <div class="col-lg-4 ">
                            <label class="bold">Address 3:</label>
                            <input type="text" id="address_3" name="address_3" class="form-control form-control-lg "  value="{{old('address_3')}}">
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-4 mt-2">
                            <label class="bold">Address 4:</label>
                            <input  type="text" id="address_4" name="address_4" class="form-control form-control-lg" value="{{old('address_1')}}" >
                        </div>

                        <div class="col-lg-4 mt-2">
                            <label class="bold">Address 5:</label>
                            <input type="text" id="address_5" name="address_2" class="form-control form-control-lg "  value="{{old('address_2')}}">
                        </div>

                        <div class="col-lg-4 mt-2">
                            <label class="bold">Post Code:</label>
                            <input type="text" id="post_code" name="post_code" class="form-control form-control-lg "  value="{{old('post_code')}}">
                            <div class="js-error  text-danger bold"></div>
                        </div>

                    </div>
                </div>
            </div>
        {{--END Prospect Details--}}

        {{--Booking Details--}}
            <div class="s-card shadow mt-5">
                <div class=" s-card-header bg-brand"><i class="fas fa-address-card mr-1"></i>   Booking Details </div>
                <div class="s-card-body px-3 alert-brother border-0">
                    <div class="row">
                        <div class="col-lg-4 mt-2">
                            <div id="date-group" class="row justify-content-center">
                                <label class="pl-3 bold"><i class="fas fa-calendar-alt"></i> Select Date <span class="text-danger">*</span></label>
                                @foreach($dates as $date)
                                    <div class="col-lg-3 p-1">
                                        <label class="js-appointment-date block @if(is_array(old('date_id')) && in_array($date->date, old('date_id')))) active @endif" date="{{$date->date}}" date-id="{{$date->id}}" event-id="{{$date->event_id}}" dealership-id="{{$date->dealership_id}}">
                                            {{\Carbon\Carbon::parse($date->date)->format('d M')}}
                                            <input type="radio" class="hide" name="date_id" value="{{$date->date}}"
                                                @if(is_array(old('date_id')) && in_array($date->date, old('date_id')))) checked @endif
                                            >
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-4 mt-2">
                            <div id="time-group" class="row justify-content-center">
                                <div class="row justify-content-center js-appointment-time"> </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-2">
                            <div id="exec-group" class="row justify-content-center ">

                                <div  class="row justify-content-center js-appointment-exec"> </div>
                                <div class="js-error text-danger text-center bold"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row justify-content-center mt-2 py-3">
                            <div class="col-lg-4 text-center ">
                                <label for="guest_friend" class="bold alert-sister block py-2 "> Is Prospect bringing a friend?</label>
                                <div class="bold mt-2">
                                    <div class="form-check form-check-inline">
                                        <label for="friend_interest_yes" class="form-check-label">Yes</label>
                                        <input type="checkbox" id="friend_interest_yes" class="form-check-input friend-interest" name="friend_interest" value="1"
                                        @if(old('friend_interest') && old('friend_interest') == "1") checked @endif
                                        >
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label for="friend_interest_no" class="form-check-label">No</label>
                                        <input type="checkbox" id="friend_interest_no" class="form-check-input friend-interest" name="friend_interest" value="0"
                                        @if(old('friend_interest') && old('friend_interest') == "0") checked @endif
                                        >
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-12 js-friend  @if(old('friend_interest') && old('friend_interest') == "1") block @else hide  @endif mt-2 text-start">
                                        <div class="border-top mb-3"></div>
                                        <label for="friend_name" class="bold">Friend Name  </label>
                                        <input placeholder="Enter your friends name" id="friend_name" type="text" class="form-control form-control-lg" name="friend_name" value="@if(old('friend_interest') && old('friend_interest') == "0") {{old('friend_name')}} @endif" autocomplete="off">
                                        <div class="js-error  text-danger text-center bold"></div>
                                        <label for="model_interest" class="bold mt-2">Friend Model Interest</label>
                                        <input placeholder="Friend Model Interest" id="friend_model_interest" type="text" class=" form-control form-control-lg " name="friend_model_interest" value="{{old('friend_name')}}" autocomplete="off">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        {{--END Booking Details--}}

        {{--Part Exchange--}}
            <div class="s-card shadow js-exec-selected mt-5">
                <div class=" s-card-header bg-brother"><i class="fas fa-car mr-1"></i>   Part Exchange </div>

                <div class="s-card-body px-3">
                    <div class="row">
                        <div class="col-lg-4 mb-3 mt-2">
                            <div class="v-reg mb-0">
                                <span>Registration Number:</span>
                                <input type="text" id="reg_number" name="reg_number" autocomplete="off">
                            </div>
                            <a href="javascript:void(0)" class="btn btn-action sister block mt-2 js-get-vehicle">Get Vehicle Details</a>

                        </div>

                        <div class="col-lg-4">
                            <div class="show-vehicle-details mt-2 hide"></div>
                        </div>

                        <div class="col-lg-4 mt-2 no-part-exchange ">
                            <div class="col-lg-12 text-center">
                                <h2 class="fs-110 bold js-part-exchange active">Customer doesn't want to part exchange a vehicle</h2>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        {{--END Part Exchange--}}

            <div class="s-card js-exec-selected shadow mt-5">
                <div class=" s-card-header bg-brother"><i class="fas fa-sliders-h mr-1"></i>   Booking Preferences </div>
                <div class="s-card-body px-3 pt-1 pb-3">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <label for="mobile" class="bold">Drink Preference</label>
                            <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            <select name="drink" id="drink" class="form-control form-control-lg">
                                <option value="">--Select one--</option>
                                <option value="tea" @if(old('drink') && old('drink') == "tea") selected @endif>Tea</option>
                                <option value="coffee" @if(old('drink') && old('drink') == "coffee") selected @endif>Coffee</option>
                                <option value="water" @if(old('drink') && old('drink') == "water") selected @endif>Water</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mt-2">
                            <label for="preference" class="bold">Milk/Sugar etc</label>
                            <input   id="preference" type="text" class="form-control form-control-lg" name="preference" value="{{old('preference')}}" autocomplete="off" >
                        </div>
                    </div>

                    <div class="col-12 my-3 py-2 px-3 alert-brother">
                        <div class="row">
                            <div class="col-12 bold">
                                <label for="model_interest">Model Interest</label>
                                <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                                <select name="model_interest" id="model_interest" class="form-control form-control-lg">
                                    <option value="">--Select one--</option>
                                    <option value="new" @if(old('model_interest') && old('model_interest') == "new") selected @endif>New</option>
                                    <option value="used" @if(old('model_interest') && old('model_interest') == "used") selected @endif>Used</option>
                                    <option value="either"  @if(old('model_interest') && old('model_interest') == "either") selected @endif>Either</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 bold">
                                <label for="model_interest">Vehicles</label>
                                <div class="row text-center js-models">
                                    @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                                        <div class="col-lg-2 mb-2">
                                            <label class="mb-2 bg-white js-select-vehicles">
                                                <img class="border block @if(is_array(old('vehicles_id')) && in_array($vehicle->id, old('vehicles_id')))) active @endif" data-vehicle="{{$vehicle->id}}"  src="{{asset('assets/images/public/general')}}/{{$vehicle->filename}}" alt="">
                                                <input type="checkbox" id="vehicle_{{$vehicle->id}}" class="form-check-input m-0 hide" name="vehicles_id[]" value="{{$vehicle->id}}"
                                                @if(is_array(old('vehicles_id')) && in_array($vehicle->id, old('vehicles_id')))) checked @endif
                                                >
                                            </label>
                                            <div class="py-1 bold border-bottom">{{$vehicle->name}}</div>
                                        </div>
                                    @endforeach
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        {{--Prospect Progress--}}
            <div class="s-card js-exec-selected shadow mt-5">
                <div class="s-card-header bg-brother"><i class="fas fa-address-card mr-1"></i>   Prospect Progress </div>
                <div class="s-card-body alert-brand px-3 pb-3">
                    <div class="row">
                        <div class="col-12 bold ">
                            <label for="call_attempts">Call Attempts</label>
                            <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            <select name="call_attempts" id="call_attempts" class="form-control form-control-lg">
                                <option value="">--Please Select--</option>
                                <option value="1st Call" @if(old('call_attempts') && old('call_attempts') == "1st Call") selected @endif>1st Call</option>
                                <option value="2nd Call" @if(old('call_attempts') && old('call_attempts') == "2nd Call") selected @endif>2nd Call</option>
                                <option value="3rd Call" @if(old('call_attempts') && old('call_attempts') == "3rd Call") selected @endif>3rd Call</option>
                                <option value="4th Call" @if(old('call_attempts') && old('call_attempts') == "4th Call") selected @endif>4th Call</option>
                                <option value="5th Call" @if(old('call_attempts') && old('call_attempts') == "5th Call") selected @endif>5th Call</option>
                                <option value="6th Call" @if(old('call_attempts') && old('call_attempts') == "6th Call") selected @endif>6th Call</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row bg-white py-2 my-3">
                            <div class="col-lg-4 bold border-end pt-2 pb-1">
                                <div class="form-check form-check-inline">
                                    <label for="call_made" class="form-check-label">Call Made</label>
                                    <input type="checkbox" id="call_made" class="form-check-input js-call-made" name="call_made" value=""
                                    @if(old('call_made') && old('call_made') == 1) checked @endif
                                    >
                                </div>

                            </div>

                            <div class="col-lg-4 bold  border-end pt-2 pb-1">

                                <div class="form-check form-check-inline">
                                    <label for="call_back" class="form-check-label">Call back required </label>
                                    <input type="checkbox" id="call_back" class="form-check-input js-call-back" name="call_back" value=""
                                    @if(old('call_back') && old('call_back') == 1) checked @endif
                                    >
                                </div>
                            </div>

                            <div class="col-lg-4 bold  border-end pt-2 pb-1">

                                <div class="form-check form-check-inline">
                                    <label for="message_left" class="form-check-label">Message Left </label>
                                    <input type="checkbox" id="message_left" class="form-check-input js-call-back" name="message_left" value=""
                                    @if(old('message_left') && old('message_left') == 1) checked @endif
                                    >
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="row border-top border-bottom">
                        <div class="col-lg-4 bold border-start border-end  py-2">
                            Appointment Status
                        </div>
                        <div class="col border-end  py-2">

                            <div class="form-check form-check-inline">
                                <label for="confirm" class="form-check-label">Confirmed</label>
                                {{-- <input type="radio" id="confirm" class="form-check-input js-confirm" name="appointment_status" value="confirm" required> --}}
                                <input type="checkbox" id="confirm" class="form-check-input js-confirm" name="confirm" value="0">
                            </div>

                            <div class="form-check form-check-inline">
                                <label for="not_interested" class="form-check-label">Not Interested</label>
                                {{-- <input type="radio" id="not_interested" class="form-check-input js-not-interested" name="appointment_status" value="not_interested" required> --}}
                                <input type="checkbox" id="not_interested" class="form-check-input js-not-interested" name="not_interested" value="0">
                            </div>

                            <div class="form-check form-check-inline">
                                <label for="in_progress" class="form-check-label">In Progress</label>
                                <input type="checkbox" id="in_progress" class="form-check-input js-in-progress" name="in_progress" value="0">
                            </div>

                            <div class="js-appointment-status text-danger rounded border border-danger  bold mt-2 px-2 py-1">
                                Please select one option
                                <input type="checkbox" class="hide"  id="appointment_status" name="appointment_status" checked="checked">
                            </div>

                            <div class="js-confirm-status rounded fs-80 alert-success mt-2 px-2 py-1 hide"> Appointment has been Confirmed </div>
                            <div class="js-cancel-status text-danger rounded fs-80 alert-danger mt-2 px-2 py-1 hide"> Appointment has been Cancelled </div>
                            <div class="js-not-interested-status text-dark rounded fs-80 alert-warning mt-2 px-2 py-1 hide"> Customer isn't interested in coming to the Event </div>
                            <div class="js-in-progress-status text-dark rounded fs-80 alert-info mt-2 px-2 py-1 hide"> Please, make notes of appointment status.</div>

                        </div>
                    </div>

                    <div class="row gx-5 border-bottom py-2">
                        <div class="col-12 bold border-end">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" rows="8" class="form-control form-control-lg">{{old('notes')}}</textarea>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-action brother block js-submit-appointment">Update Appointment</button>
                            {{-- <a href="javascript:void(0)"class="btn btn-action brother block js-submit-appointment">Update Appointment</a> --}}
                        </div>
                    </div>

                </div>
            </div>
        {{--END Prospect Progress--}}

    </form>


@endsection


@section('scripts')
    <script>
        $(function(){

            $('.js-exec-selected').hide()
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
                $('.js-submit-appointment').removeClass('hide disabled');

                $('.js-appointment-status').html('');
                $('#appointment_status').removeAttr('checked');
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
                $(this).val(1)
                $('.js-in-progress-status').removeClass('hide');
                $('.js-confirm-status, .js-appointment-status, .js-cancel-status, .js-not-interested-status').addClass('hide');

                $('.js-appointment-status').html('');
                $('.js-submit-appointment').removeClass('hide disabled');
                $('#appointment_status').removeAttr('checked');
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

            //On Click Returns Time Slots based on date selection
            $('#date-group').on('click', '.js-appointment-date', function(){
                $('.js-exec-selected').hide()
                $('.js-appointment-exec').html("");
                $('#date-group .js-appointment-date ').removeClass('current-date active');
                $(this).addClass('current-date active');


                var dealership_id   =   $(this).attr('dealership-id');
                var date_id         =   $(this).attr('date-id');
                var event_id        =   $(this).attr('event-id');
                //alert(event_id + " - " + date_id + " - " + dealership_id);

                $.ajax({
                    url: '/dashboard/appointments/get-times?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id,
                        success:function(response){
                            $('.js-appointment-time').html(response);
                        }
                });
            });

            //On Click Returns Execs based on Time Selection
            $('#time-group').on('click', '.js-time', function(){

                $('.js-exec-selected').hide()
                $('#time-group .js-time').removeClass('current-time active');
                $(this).addClass('current-time active');

                var dealership_id = $(this).attr('dealership-id');
                var date_id = $(this).attr('date-id');
                var event_id = $(this).attr('event-id');
                var time_id = $(this).attr('time-id');
                //alert(time_id + " - " +event_id + " - " + date_id + " - " + dealership_id);

                $.ajax({
                    url: '/dashboard/appointments/get-execs?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id+'&time_id='+time_id,
                        success:function(response){
                            $('.js-appointment-exec').html(response);
                        }
                });

            });

            //Return all excecs assigned to time slot
            $('#exec-group').on('click', '.js-exec', function(){
                $('#exec-group .js-exec').removeClass('current-exec active');
                $(this).addClass('current-exec active');
                $('.js-error').html('');
                $('.js-exec-selected').fadeIn('hide');
            });

        });

        //toggles class .active when selecting vehicles
        $('.js-models img').click(function(){
            // alert(0);
            $(this).toggleClass('active');
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



        $('.js-submit-appointment').addClass('disabled');

        $('.js-submit-appointment').click(function(){

            $('body').mousedown(function() {
                $('#title').removeClass('border-danger').next('.js-error py-1').html('');
                $('#name').removeClass('border-danger').next('.js-error py-1').html('');
                $('#surname').removeClass('border-danger').next('.js-error py-1').html('');
                $('#email').removeClass('border-danger').next('.js-error py-1').html('');
                $('#mobile').removeClass('border-danger').next('.js-error py-1').html('');
                $('#address_1').removeClass('border-danger').next('.js-error py-1').html('');
                $('#post_code').removeClass('border-danger').next('.js-error py-1').html('');
                $('#friend_name').removeClass('border-danger').next('.js-error').html('')
            });


            var title = $('#title').val();
            var name = $('#name').val();
            var surname = $('#surname').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();
            var address_1 = $('#address_1').val();
            var post_code = $('#post_code').val();

            if ($('#friend_interest_yes').is(":checked")){
                var friend_interest = 1;
            }else{
                var friend_interest = 0;
            }

            if($('.no-part-exchange  h2').hasClass('active')){
                var part_exchange = 0;
            }else{
                var part_exchange = 1;
            }

            if($('#appointment_status').prop('checked')){
                $('#appointment_status').prop('checked', function(_, checked) {
                    $('.js-appointment-status').removeClass('hide');
                });
            }


            //Validates required prospect details
            if(title == "" || name == "" || surname == "" || email == "" || mobile == "" || address_1 == "" || post_code == ""){
                $('.pop-up-wrapper-spin ').addClass('hide')
                var position = $('#title').offset();
                $('html, body').animate({scrollTop: position.top}, "slow");
                //validates title
                if(title == ""){
                    $('#title').addClass('border-danger').next('.js-error').addClass(' py-1').html('* Title needs to be selected')
                }else{
                    $('#title').removeClass('border-danger').next('.js-error').removeClass(' py-1').html('');
                }
                //validates name
                if(name == ""){
                    $('#name').addClass('border-danger').next('.js-error').addClass(' py-1').html('* Prospect\'s Name required')
                }else{
                    $('#name').removeClass('border-danger').next('.js-error').removeClass(' py-1').html('');
                }

                //validates Surname
                if(surname == ""){
                    $('#surname').addClass('border-danger').next('.js-error').addClass(' py-1').html('* Surname required')
                }else{
                    $('#surname').removeClass('border-danger').next('.js-error').removeClass(' py-1').html('');
                }

                //validates Surname
                if(email == ""){
                    $('#email').addClass('border-danger').next('.js-error').addClass(' py-1').html('* Email required')
                }else{
                    $('#email').removeClass('border-danger').next('.js-error').removeClass(' py-1').html('');
                }

                if( !validateEmail(email)) {
                    var position = $('#title').offset();
                    $('html, body').animate({scrollTop: position.top}, "slow");
                    $('#email').addClass('border-danger').next('.js-error').addClass(' py-1').html('* Email needs to be Valid')
                }

                //validates Mobile
                if(mobile == ""){
                    $('#mobile').addClass('border-danger').next('.js-error').addClass(' py-1').html('* Mobile required')
                }else{
                    //match('[0-9]{11}')
                    if(!mobile.match(/^((\+44\s?|0)7([45789]\d{2}|624)\s?\d{3}\s?\d{3})$/))  {
                        var position = $('#title').offset();
                        $('html, body').animate({scrollTop: position.top}, "slow");
                        $('#mobile').addClass('border-danger').next('.js-error').addClass(' py-1').html('* Invalid mobile number. Needs to be integers and contain 11 numbers.')
                    }else{
                        $('#mobile').removeClass('border-danger').next('.js-error').removeClass(' py-1').html('');
                    }
                }

            }



            function validateEmail($email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test( $email );
            }


            $("form").submit(function () {
                // prevent duplicate form submissions
                $(this).find(":submit").attr('disabled', 'disabled');
                $('.pop-up-wrapper-spin').removeClass('hide')
            });


        })


    </script>
@endsection

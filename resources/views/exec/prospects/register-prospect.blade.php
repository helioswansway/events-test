@extends('_layouts._exec-dashboard')


@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-book-reader fs-110"></i> Register Prospect for [{{$dealership->name}}]
                <span class="h1-button" style="">
                    <a href="{{url()->previous()}}" class="btn btn-border sister "><i class="fas fa-angle-double-left"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="hidden" id="eventId" name="eventId" value="{{$event_id}}" >
    <input type="hidden" id="dealership_id" name="dealership_id" value="{{$dealership->id}}" >

    {{--Prospect Details--}}
        <div class="s-card shadow">
            <div class=" s-card-header bg-brother"><i class="fas fa-address-card mr-1"></i>  Enter Prospect Details </div>

            <div class="s-card-body px-3 pb-3">
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        <label for="title" class="bold">Title <span class="text-danger">*</span></label>
                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                        <select name="title" id="title" class=" form-control form-control-lg" required="">
                            <option value="">--Select one--</option>
                            <option value="Mr">Mr</option>
                            <option value="Ms">Ms</option>
                            <option value="Miss">Miss</option>
                            <option value="Mrs">Mrs</option>
                        </select>
                        <div class="js-error text-danger bold"></div>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <label for="name" class="bold">First Name <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" class="form-control form-control-lg" value="{{old('name')}}">
                        <div class="js-error text-danger bold"></div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label for="surname" class="bold">Surname <span class="text-danger">*</span></label>
                        <input id="surname" id="surname" type="text" class="form-control form-control-lg" value="{{old('surname')}}">
                        <div class="js-error text-danger bold"></div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Email</label>  <span class="text-danger">*</span>
                        <input  type="email" id="email" name="email" class="form-control form-control-lg" value="{{old('email')}}">
                        <div class="js-error text-danger bold"></div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Home Phone</label>
                        <input type="text" id="home_phone" name="home_phone" class="form-control form-control-lg "  value="{{old('home_phone')}}">
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Mobile Number</label> <span class="text-danger">*</span>
                        <input type="text" id="mobile" name="mobile" class="form-control form-control-lg "  value="{{old('mobile')}}" >
                        <div class="js-error text-danger bold"></div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Address: </label>  <span class="text-danger">*</span>
                        <input  type="text" id="address_1" name="address_1" class="form-control form-control-lg" value="{{old('address_1')}}" >
                        <div class="js-error text-danger bold"></div>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Address 2:</label>
                        <input type="text" id="address_2" name="address_2" class="form-control form-control-lg "  value="{{old('address_2')}}">
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Address 3:</label>
                        <input type="text" id="address_3" name="address_3" class="form-control form-control-lg "  value="{{old('address_3')}}">
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Address 4:</label>
                        <input  type="text" id="address_4" name="address_4" class="form-control form-control-lg" value="{{old('address_4')}}" >
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Address 5:</label>
                        <input type="text" id="address_5" name="address_5" class="form-control form-control-lg "  value="{{old('address_5')}}">
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label class="bold">Post Code:</label> <span class="text-danger">*</span>
                        <input type="text" id="post_code" name="post_code" class="form-control form-control-lg "  value="{{old('post_code')}}">
                        <div class="js-error text-danger bold"></div>
                    </div>

                </div>
            </div>
        </div>
    {{--END Prospect Details--}}

    {{--Booking Details--}}
        <div class="s-card shadow mt-5">
            <div class="s-card-header bg-brand"><i class="fas fa-address-card mr-1"></i>   Booking Details </div>

            <div class="s-card-body px-3">
                <div class="row">
                    <div class="col-lg-6 mt-2">
                        <div id="date-group" class="row justify-content-center">
                            <label class="bold ml-3"><i class="fas fa-calendar-alt"></i> Select Date <span class="text-danger">*</span></label>
                            @foreach($dates as $date)
                                <div class="col-lg-3 p-1">
                                    <div class="js-appointment-date" date="{{$date->date}}" date-id="{{$date->id}}" event-id="{{$date->event_id}}" dealership-id="{{$date->dealership_id}}">
                                        {{\Carbon\Carbon::parse($date->date)->format('d M')}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-6 mt-2">
                        <div id="time-group" class="row justify-content-center ">
                            <div class="row justify-content-center js-appointment-time"> </div>
                            <div class="js-error text-danger bold"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row justify-content-center mt-3 py-3">
                        <div class="col-lg-4 text-center ">
                            <label class="bold alert-brand block py-2 mb-2"> Is Prospect bringing a friend?</label>

                            <div class="form-check form-check-inline">
                                <label for="friend_interest_yes" class="form-check-label">Yes</label>
                                <input type="checkbox" id="friend_interest_yes" class="form-check-input friend-interest" name="friend_interest" value="1">
                            </div>
                            <div class="form-check form-check-inline">
                                <label for="friend_interest_no" class="form-check-label">Yes</label>
                                <input type="checkbox" id="friend_interest_no" class="form-check-input friend-interest" name="friend_interest" value="0">
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-lg-12 js-friend hide mt-2 text-start">
                                    <div class="border-top mb-2"></div>
                                    <label for="friend_name" class="bold">Friend Name  </label>
                                    <input placeholder="Enter your friends name" id="friend_name" type="text" class="form-control form-control-lg" name="friend_name" value="" autocomplete="off">
                                    <div class="js-error text-danger bold"></div>
                                    <label for="model_interest" class="bold mt-2">Friend Model Interest</label>
                                    <input placeholder="Friend Model Interest" id="friend_model_interest" type="text" class="form-control form-control-lg " name="friend_model_interest" value="" autocomplete="off">
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
            <div class="s-card-header bg-brother"><i class="fas fa-car mr-1"></i>   Part Exchange </div>

            <div class="col-12 border-0 py-3">
                <div class="row ">
                    <div class="col-lg-4 mt-2">
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

    <div class="s-card shadow mt-5">
        <div class=" s-card-header bg-brother"><i class="fas fa-sliders-h mr-1"></i>   Booking Preferences </div>

        <div class="s-card-body px-3 pb-2">
            <div class="row">
                <div class="col-lg-6 mt-2">
                    <label for="mobile" class="bold">Drink Preference</label>
                    <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                    <select name="drink" id="drink" class="form-control form-control-lg">
                        <option value="">--Select one--</option>
                        <option value="tea">Tea</option>
                        <option value="coffee">Coffee</option>
                        <option value="water">Water</option>
                    </select>
                </div>

                <div class="col-lg-6 mt-2">
                    <label for="preference" class="bold">Milk/Sugar etc</label>
                    <input   id="preference" type="text" class="form-control form-control-lg" name="preference" value="" autocomplete="off" >
                </div>
            </div>

            <div class="col-12 my-3 p-3 alert-brand">
                <div class="row">
                    <div class="col-12 bold">
                        <label for="model_interest">Model Interest</label>
                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                        <select name="model_interest" id="model_interest" class="form-control form-control-lg">
                            <option value="">--Select one--</option>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="either">Either</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 bold">
                        <label for="model_interest">Vehicles</label>
                        <div class="row text-center js-models">
                            @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                                <div class="col-lg-2 mb-2">
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

    {{--Prospect Progress--}}
        <div class="s-card shadow mt-5">
            <div class=" s-card-header bg-brand"><i class="fas fa-address-card mr-1"></i>   Prospect Progress </div>

            <div class="s-card-body alert-brand px-3 pb-3">
                <div class="row pb-4">
                    <div class="col-12 bold ">
                        <label for="call_attempts">Call Attempts</label>
                        <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                        <select name="call_attempts" id="call_attempts" class="form-control form-control-lg">
                            <option value="">--Please Select--</option>
                            <option value="1st Call">1st Call</option>
                            <option value="2nd Call">2nd Call</option>
                            <option value="3rd Call">3rd Call</option>
                            <option value="4th Call">4th Call</option>
                            <option value="5th Call">5th Call</option>
                            <option value="6th Call">6th Call</option>
                        </select>
                    </div>
                </div>

                <div class="row bg-white border-top border-bottom">
                    <div class="col-lg-4 bold border-start border-end  pt-2 pb-1">
                        <div class="form-check form-check-inline">
                            <label for="call_made" class="form-check-label">Call Made</label>
                            <input type="checkbox" id="call_made" class="form-check-input js-call-made" name="call_made" value="">
                        </div>
                    </div>

                    <div class="col-lg-4 bold  border-end pt-2 pb-1">
                        <div class="form-check form-check-inline">
                            <label for="call_back" class="form-check-label">Call Back</label>
                            <input type="checkbox" id="call_back" class="form-check-input js-call-back" name="call_back" value="">
                        </div>
                    </div>

                    <div class="col-lg-4 bold  border-end  pt-2 pb-1">
                        <div class="form-check form-check-inline">
                            <label for="message_left" class="form-check-label">Message Left</label>
                            <input type="checkbox" id="message_left" class="form-check-input" name="message_left" value="">
                        </div>
                    </div>

                </div>

                <div class="row border-top border-bottom py-3">
                    <div class="col-lg-4 bold text-end border-end pb-1 pt-2">
                        Appointment Status:
                    </div>

                    <div class="col border-end  py-2">

                        <div class="form-check form-check-inline">
                            <label for="confirm" class="form-check-label">Confirm</label>
                            <input type="checkbox" id="confirm" class="form-check-input js-confirm" name="confirm" value="" >
                        </div>

                        <div class="form-check form-check-inline">
                            <label for="not_interested" class="form-check-label">Not Interest</label>
                            <input type="checkbox" id="not_interested" class="form-check-input js-not-interested" name="not_interested" value="" >
                        </div>

                        <div class="form-check form-check-inline">
                            <label for="in_progress" class="form-check-label">In Progress</label>
                            <input type="checkbox" id="in_progress" class="form-check-input js-in-progress" name="in_progress" value="" >
                        </div>


                        <div class="js-appointment-status bg-white rounded border mt-2  px-1 py-1 fs-80">
                            Select Appointment Status
                            <input type="checkbox" class="hide"  id="appointment_status" name="appointment_status" checked="checked">
                        </div>

                        {{----}}
                        <div class="js-confirm-status rounded fs-80 alert-success mt-2 px-2 py-1 hide"> Appointment has been Confirmed </div>

                        <div class="js-cancel-status text-danger rounded fs-80 alert-danger mt-2 px-2 py-1 hide"> Appointment has been Cancelled </div>
                        <div class="js-not-interested-status text-dark rounded fs-80 alert-warning mt-2 px-2 py-1 hide"> Customer isn't interested in coming to the Event </div>


                    </div>
                </div>

                <div class="row gx-5 py-1 border-bottom mt-2">
                    <div class="col-12 bold border-end">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="8" class="form-control form-control-lg">{{old('notes')}}</textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-lg-12">
                        <a href="javascript:void(0)"class="btn btn-action sister block js-submit-appointment"> Update Appointment</a>
                    </div>
                </div>

            </div>
        </div>
    {{--END Prospect Progress--}}



@endsection


@section('scripts')
    <script>
        $(function(){

            // $('.js-confirm').attr("disabled", true);
            // $('.js-cancelled').attr("disabled", true);
            // $('.js-not-interested').attr("disabled", true);

            confirm()
            cancelled()
            notInterested()

            function confirm(){
                //toggles between Confirm and Cancelled
                $('.js-confirm').click(function(){
                    $(this).val(1)
                    $('.js-confirm-status').removeClass('hide');
                    $('.js-not-interested-status').addClass('hide');
                    $('.js-cancel-status').addClass('hide');
                    $('.js-appointment-status').addClass('hide');

                    $('.js-appointment-status').html('');
                    $('#appointment_status').removeAttr('checked');
                    $('.js-submit-appointment').removeClass('disabled');

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

                    } else {
                    // prevent from being unchecked
                        this.checked=!this.checked;
                    }

                });
            }

            function cancelled(){
                //Toggles between Cancelled and Confirm
                $('.js-cancelled').click(function(e){
                    $(this).val(1)
                    $('.js-cancel-status').removeClass('hide');
                    $('.js-confirm-status').addClass('hide');
                    $('.js-not-interested-status').addClass('hide');
                    $('.js-appointment-status').addClass('hide');

                    $('.js-appointment-status').html('');
                    $('#appointment_status').removeAttr('checked');
                    $('.js-submit-appointment').removeClass('disabled');

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
            }

            function notInterested(){
                //Mark if customer is or not interested
                $('.js-not-interested').click(function(){
                    $(this).val(1)
                    $('.js-not-interested-status').removeClass('hide');
                    $('.js-confirm-status').addClass('hide');
                    $('.js-cancel-status').addClass('hide');
                    $('.js-appointment-status').addClass('hide');


                    $('.js-appointment-status').html('');
                    $('#appointment_status').removeAttr('checked');
                    $('.js-submit-appointment').removeClass('disabled');

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

                    } else {
                    // prevent from being unchecked
                        this.checked=!this.checked;
                    }




                });
            }

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

                $('.js-confirm, .js-cancelled, .js-not-interested').attr("disabled", true);
                $('.js-confirm, .js-cancelled, .js-not-interested').prop('checked', false);
                $('.js-appointment-status').addClass('alert-danger text-danger').removeClass('hide').html('A Slot Time is required');
                $('.js-confirm-status').addClass('hide');
                $('.js-cancel-status').addClass('hide');
                $('.js-not-interested-status').addClass('hide');

                $('.js-submit-appointment').addClass('disabled');

                var dealership_id   =   $(this).attr('dealership-id');
                var date_id         =   $(this).attr('date-id');
                var event_id        =   $(this).attr('event-id');
                //alert(event_id + " - " + date_id + " - " + dealership_id);

                $.ajax({
                    url: '/exec/prospect/get-times?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id,
                        success:function(response){
                            $('.js-appointment-time').html(response);
                        }
                });
            });

            //Time Slots
            $('#time-group').on('click', '.js-time', function(){
                $('#time-group .js-time').removeClass('current-time active');
                $(this).addClass('current-time active');

                $('.js-confirm, .js-cancelled, .js-not-interested').attr("disabled", false);
                $('.js-appointment-status').addClass('hide').html('');

                $('.js-submit-appointment').removeClass('disabled');

                var dealership_id   =   $(this).attr('dealership-id');
                var date_id         =   $(this).attr('date-id');
                var event_id        =   $(this).attr('event-id');
                var time_id         =   $(this).attr('time-id');
                //alert(time_id + " - " +event_id + " - " + date_id + " - " + dealership_id);

                $.ajax({
                    url: '/exec/prospect/get-execs?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id+'&time_id='+time_id,
                        success:function(response){
                            $('.js-appointment-exec').html(response);
                        }
                });

            });

            //Execs
            $('#exec-group').on('click', '.js-exec', function(){
                $('#exec-group .js-exec').removeClass('current-exec active');
                $(this).addClass('current-exec active');
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
            var reg_number = $('#reg_number').val();
            var reg_number = reg_number.replace(/ /g, '');


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


        $('.js-submit-appointment').click(function(){
            $('.js-submit-appointment').addClass('disabled');
            $('.js-spinner').removeClass('hide');

            var dealership_id           =  $('#dealership_id').val();
            var event_id                =  $('#eventId').val();

            var title                   =   $('#title').val();
            var name                    =   $('#name').val();
            var surname                 =   $('#surname').val();
            var email                   =   $('#email').val();
            var home_phone              =   $('#home_phone').val();
            var mobile                  =   $('#mobile').val();
            var address_1               =   $('#address_1').val();
            var address_2               =   $('#address_2').val();
            var address_3               =   $('#address_3').val();
            var address_4               =   $('#address_4').val();
            var address_5               =   $('#address_5').val();
            var post_code               =   $('#post_code').val();

            // alert(title + ", " + name + ", " + surname + ", " + email + ", " + home_phone + ", " + mobile + ", " + address_1 + ", " + address_2 + ", " + address_3 + ", " + address_4 + ", " + address_5 + ", " + post_code)


            var date                    =   $('.current-date').attr('date');
            var time_id                 =   $('.current-time').attr('time-id');
            var exec_id                 =   $('.current-exec').attr('exec-id');


            if ($('#friend_interest_yes').is(":checked")){
                var friend_interest         =   1;
            }else{
                var friend_interest         =   0;
            }

            var friend_name             =   $('#friend_name').val();
            var friend_model_interest   =   $('#friend_model_interest').val();

            //alert(friend_interest + " - " +friend_name + " - " +friend_model_interest)

            var registration            =   $('#registration').val();
            var make                    =   $('#make').val();
            var colour                  =   $('#colour').val();
            var fuel_type               =   $('#fuel_type').val();
            var mileage                 =   $('#mileage').val();

            var model_interest          =   $('#model_interest').val();
            var drink                   =   $('#drink').val();
            var preference              =   $('#preference').val();

            var confirm                 =   $('#confirm').val();
            var cancelled               =   $('#cancelled').val();
            var not_interested          =   $('#not_interested').val();

            var call_attempts           =   $('#call_attempts').val();
            var call_made               =   $('#call_made').val();
            var call_back               =   $('#call_back').val();
            var message_left            =   $('#message_left').val();

            var vehicles                =   $('.js-select-vehicles img.active');
            var vehicles                =   $.map(vehicles, e => $(e).attr('data-vehicle'));

            var notes                   =   $('#notes').val();

            if($('.no-part-exchange  h2').hasClass('active')){
                var part_exchange =   0;
            }else{
                var part_exchange =   1;
            }

            if($('#appointment_status').prop('checked')){
                $('#appointment_status').prop('checked', function(_, checked) {
                    $('.js-appointment-status').removeClass('hide');
                });
            }

            //It makes sure any warnings disapear if any times are entered
            $('body').mousedown(function() {
                $('#title').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('#name').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('#surname').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('#email').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('#mobile').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('#address_1').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('#post_code').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('#friend_name').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                $('.js-appointment-time').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
            });

            //Validates required prospect details
            if(title == "" || name == "" || surname == "" || email == "" || mobile == "" || post_code == ""){
                var position = $('#title').offset();
                $('html, body').animate({scrollTop: position.top}, "slow");
                //validates title
                if(title == ""){
                    $('#title').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Title needs to be selected')
                }else{
                    $('#title').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                }
                //validates name
                if(name == ""){
                    $('#name').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Prospect\'s Name required')
                }else{
                    $('#name').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                }

                //validates Surname
                if(surname == ""){
                    $('#surname').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Surname required')
                }else{
                    $('#surname').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                }

                //validates Surname
                if(email == ""){
                    $('#email').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Email required')
                }else{
                    $('#email').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                }
                if( !validateEmail(email)) {
                    var position = $('#title').offset();
                    $('html, body').animate({scrollTop: position.top}, "slow");
                    $('#email').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Email needs to be Valid')
                }

                //validates Mobile
                if(mobile == ""){
                    $('#mobile').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Mobile required')
                }else{
                    //match('[0-9]{11}')
                    if(!mobile.match(/^((\+44\s?|0)7([45789]\d{2}|624)\s?\d{3}\s?\d{3})$/))  {
                        var position = $('#title').offset();
                        $('html, body').animate({scrollTop: position.top}, "slow");
                        $('#mobile').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Invalid mobile number ')
                    }else{
                        $('#mobile').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                    }
                }

                //validates Address 1
                if(address_1 == ""){
                    $('#address_1').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Address required')
                }else{
                    $('#address_1').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                }

                //validates Post Code
                if(post_code == ""){
                    $('#post_code').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Post Code required')
                }else{
                    $('#post_code').removeClass('border-danger').next('.js-error').removeClass('pt-1').html('');
                }

            }else{
                //Checks if Time was selected
                if($(".current-time")[0]){

                    if($('#friend_interest_yes').is(":checked") && $('#friend_name').val() == ""){
                        if($('#friend_name').val() == ""){
                            //scrool to where the error is
                            var friendPosition = $('#friend_name').offset();
                            $('html, body').animate({scrollTop: friendPosition.top}, "slow");
                            $('#friend_name').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Friend Name\'s required')
                        }
                    }else{

                        //alert(event_id + " - " +dealership_id + " - " +part_exchange + " - " +registration + " - " + make + " - " + colour + " - " + fuel_type + " - " + mileage + " - " + book_id + " - " + date + " - " + time_id + " - " + exec_id + " - " + vehicles + " - " + model_interest + " - " + drink + " - " + preference+ " - " + notes )
                        fetch('/exec/prospects/store',{
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({
                                    title: title,
                                    name: name,
                                    surname: surname,
                                    email: email,
                                    home_phone: home_phone,
                                    mobile: mobile,
                                    address_1: address_1,
                                    address_2: address_2,
                                    address_3: address_3,
                                    address_4: address_4,
                                    address_5: address_5,
                                    post_code: post_code,

                                    dealership_id: dealership_id,
                                    event_id: event_id,
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

                                    confirm: confirm,
                                    cancelled: cancelled,
                                    not_interested: not_interested,

                                    call_attempts: call_attempts,
                                    call_made: call_made,
                                    call_back: call_back,
                                    message_left: message_left,

                                    drink: drink,
                                    preference: preference,
                                    vehicles: vehicles,
                                    notes: notes

                                }),
                            })
                            .then((response) => response.json())
                            .then((response) => {

                                //Checks if the email already exists
                                if(response == "exists"){
                                    var position = $('#email').offset();
                                    $('html, body').animate({scrollTop: position.top}, "slow");
                                    $('#email').addClass('border-danger').next('.js-error').addClass('pt-1').html('* Email Already in the current Event')
                                }else{

                                      console.log(response);

                                    //Notifies user that prospect was registered and an appointment has been made
                                    $.confirm({
                                        title: '<span class="text-brand">Success!</span>',
                                        content: 'Prospect has been registered and appointment was also created! <br><br>You will now be redirected to to prospects page!',
                                        buttons: {
                                            confirm: function (e) {
                                                $.ajax({
                                                    success: function (response)
                                                    {
                                                            window.location.href = '/exec/prospects';

                                                    }
                                                });
                                            }
                                        }
                                    });

                                }

                            })
                            .catch(error => console.log('Error:' + error))
                    }

                }else{

                    //scrool to where the error is
                    var divPosition = $('#time-group').offset();
                    $('html, body').animate({scrollTop: divPosition.top}, "slow");
                    $('.js-appointment-time').addClass('border-danger p-2').next('.js-error').html('* Time Slot needs to be selected')



                }
            }

            function validateEmail($email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test( $email );
            }


        })


</script>
@endsection

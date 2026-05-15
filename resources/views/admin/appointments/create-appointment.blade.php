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
                <i class="fas fa-book-reader fs-110"></i> Prospect Appointment for [{{$dealership->name}}]
                <span class="h1-button" style="">
                    <a href="{{route('admin.appointment.prospect', [$event_id, $dealership_id] )}}" class="btn btn-border sister"><i class="fas fa-angle-double-left mr-2"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <input type="hidden" id="event_id" name="event_id" value="{{$event_id}}" >
    <input type="hidden" id="dealership_id" name="dealership_id" value="{{$dealership->id}}" >

    {{--Prospect Details--}}
        <div class="s-card shadow">
            <div class=" s-card-header bg-brother border-0 border-bottom">
                <i class="fas fa-address-card mr-1"></i>   Prospect Details
            </div>

            <div class="s-card-body px-3 ">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="title" class="bold">Title<span class="text-danger">*</span></label>
                        <input id="title" type="text" class="form-control form-control-lg" book-title="{{$prospect->title}}" value="{{$prospect->title}}"  disabled="">
                    </div>

                    <div class="col-lg-4">
                        <label for="name" class="bold">Name <span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control form-control-lg" book-id="{{$prospect->id}}" value="{{$prospect->name}}"  disabled="">
                    </div>

                    <div class="col-lg-4">
                        <label for="surname" class="bold">Surname <span class="text-danger">*</span></label>
                        <input id="surname" type="text" class="form-control form-control-lg" value="{{$prospect->surname}}"  disabled="">
                    </div>
                </div>

                <div class="row py-2">
                    <div class="col-lg-4">
                        <label for="address_1" class="bold">Address 1:  </label>
                        <input  type="text" id="address_1" class="form-control form-control-lg" value="{{$prospect->address_1}}"  disabled>
                    </div>

                    <div class="col-lg-4">
                        <label for="address_2" class="bold">Address 2:  </label>
                        <input  type="text" id="address_2" class="form-control form-control-lg" value="{{$prospect->address_2}}"  disabled>
                    </div>

                    <div class="col-lg-4">
                        <label for="address_3" class="bold">Address 3:  </label>
                        <input  type="text" id="address_3" class="form-control form-control-lg" value="{{$prospect->address_3}}"  disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <label for="address_4" class="bold">Address 4:  </label>
                        <input  type="text" id="address_4" class="form-control form-control-lg" value="{{$prospect->address_4}}"  disabled>
                    </div>

                    <div class="col-lg-4">
                        <label for="address_5" class="bold">Address 2:  </label>
                        <input  type="text" id="address_5" class="form-control form-control-lg" value="{{$prospect->address_5}}"  disabled>
                    </div>

                    <div class="col-lg-4">
                        <label class="bold">Post Code</label>
                        <input type="text"  id="post_code" class="form-control form-control-lg "  value="{{$prospect->post_code}}" disabled>
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-lg-4">
                        <label class="bold">Email  </label>
                        <input  type="email" id="email" class="form-control form-control-lg" value="{{$prospect->email}}"  disabled>
                    </div>

                    <div class="col-lg-4">
                        <label class="bold">Home Phone</label>
                        <input type="text" id="home_phone" class="form-control form-control-lg "  value="{{$prospect->home_phone}}" disabled>
                    </div>

                    <div class="col-lg-4">
                        <label class="bold">Mobile Number</label>
                        <input type="text" id="mobile" class="form-control form-control-lg "  value="{{$prospect->mobile}}" disabled>
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-lg-4">
                        <label for="vehicle_reg" class="bold">Vehicle Registration</label>
                        <input type="text" id="vehicle_reg" class="form-control form-control-lg " value="{{$prospect->vehicle_reg}}" disabled >
                    </div>

                    <div class="col-lg-4">
                        <label for="vehicle_description" class="bold">Vehicle Decription</label>
                        <input type="text" id="vehicle_description" class="form-control form-control-lg " value="{{$prospect->vehicle_description}}" disabled >
                    </div>
                </div>

                @admin('renewals')
                    <div class="row mt-3">

                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-action sister block js-edit-prospect"><i class="far fa-edit mr-1"></i> Edit Prospect</a>
                            <a href="javascript:void(0)" class="btn btn-action brand block js-save-prospect hide"><i class="fas fa-save mr-1"></i> Save Prospect</a>
                        </div>

                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-action warning block js-cancel-prospect hide"><i class="fas fa-times mr-1"></i> Dont Save</a>
                        </div>
                    </div>
                @endadmin

            </div>
        </div>
    {{--END Prospect Details--}}

    {{--Booking Details--}}
        <div class="s-card shadow mt-5">
            <div class="s-card-header bg-brand"><i class="fas fa-address-card mr-1"></i>   Booking Details </div>

            <div class="s-card-body px-3 py-0 alert-brother border-0">
                <div class="row ">
                    <div class="col-lg-4 mt-3">
                        <div id="date-group" class="row justify-content-center">
                            <label class="ps-3 bold"><i class="fas fa-calendar-alt"></i> Select Date <span class="text-danger">*</span></label>
                            @foreach($dates as $date)
                                <div class="col-lg-3 p-1">
                                    <div class="js-appointment-date" date="{{$date->date}}" date-id="{{$date->id}}" event-id="{{$date->event_id}}" dealership-id="{{$date->dealership_id}}">
                                        {{\Carbon\Carbon::parse($date->date)->format('d M')}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4 mt-3">
                        <div id="time-group" class="row justify-content-center">

                            <div class="row justify-content-center js-appointment-time"> </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-3">
                        <div id="exec-group" class="row justify-content-center">
                            <div  class="row justify-content-center js-appointment-exec"> </div>
                            <div class="js-error p-2 text-danger text-center bold"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row justify-content-center mt-1">
                        <div class="col-lg-4 text-center ">
                            <label for="guest_friend" class="bold alert-sister block py-2 "> Is Prospect bringing a friend?</label>
                            <div class="bold mt-2">
                                <div class="form-check form-check-inline">
                                    <label for="friend_interest_yes" class="form-check-label">Yes</label>
                                    <input type="checkbox" id="friend_interest_yes" class="form-check-input friend_interest" name="friend_interest" value="1" >
                                </div>

                                <div class="form-check form-check-inline">
                                    <label for="friend_interest_no" class="form-check-label">No</label>
                                    <input type="checkbox" id="friend_interest_no" class="form-check-input friend_interest" name="friend_interest" value="0" >
                                </div>
                            </div>

                            <div class="row justify-content-center pb-3">
                                <div class="col-lg-12 js-friend hide mt-1 text-start">
                                    <div class="border-top mb-1"></div>
                                    <label for="friend_name" class="bold">Friend Name  </label>
                                    <input placeholder="Enter your friends name" id="friend_name" type="text" class="form-control form-control-lg" name="friend_name" value="" autocomplete="off">
                                    <div class="js-error p-1 text-danger text-center bold"></div>
                                    <label for="model_interest" class="bold">Friend Model Interest</label>
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
            <div class=" s-card-header bg-brother"><i class="fas fa-car mr-1"></i>   Part Exchange </div>

            <div class="s-card-body px-3 py-4">
                <div class="row">
                    <div class="col-lg-4 my-3">
                        <div class="v-reg mt-1">
                            <span>Registration Number:</span>
                            <input type="text" id="reg_number" name="reg_number" autocomplete="off">
                        </div>
                        <a href="javascript:void(0)" class="btn btn-action brother block mt-0 js-get-vehicle">Get Vehicle Details</a>
                    </div>

                    <div class="col-lg-4">
                        <div class="show-vehicle-details mt-1 hide"></div>
                    </div>

                    <div class="col-lg-4 mt-3 no-part-exchange ">
                        <div class="col-lg-12 text-center">
                            <h2 class="fs-110 bold js-part-exchange active">Customer doesn't want to part exchange a vehicle</h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    {{--END Part Exchange--}}

    <div class="s-card shadow mt-5">
        <div class=" s-card-header bg-brother"><i class="fas fa-sliders-h me-2"></i>   Booking Preferences </div>

        <div class="s-card-body px-3 pb-3">
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

            <div class="col-12 my-3 py-2 px-3 alert-brother">
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

                <div class="row mt-2">
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
            <div class="s-card-header bg-brother"><i class="fas fa-address-card mr-1"></i>   Prospect Progress </div>

            <div class="s-card-body alert-brother px-3 pb-3">
                <div class="row pb-3">
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

                <div class="row border-top border-left-0 border-right-0 border-bottom-0 py-2 alert-brand">
                    <div class="col-lg-4 bold border-end pb-1 pt-2">
                        <div class="form-check form-check-inline">
                            <label for="call_made" class="form-check-label">Call Made</label>
                            <input type="checkbox" id="call_made" class="form-check-input js-call-made" name="call_made" value="" >
                            <span class="js-error p-2 text-danger text-center"></span>
                        </div>

                    </div>

                    <div class="col-lg-4 bold border-end pb-1 pt-2">
                        <div class="form-check form-check-inline">
                            <label for="call_back" class="form-check-label">Call back required</label>
                            <input type="checkbox" id="call_back" class="form-check-input js-call-back" name="call_back" value="" >
                        </div>
                    </div>

                    <div class="col-lg-4 bold border-start pb-1 pt-2">
                        <div class="form-check form-check-inline">
                            <label for="message_left" class="form-check-label">Message Left</label>
                            <input type="checkbox" id="message_left" class="form-check-input js-message-left" name="message_left" value="" >
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

                <div class="row gx-5 border-bottom mt-2">
                    <div class="col-12 bold border-end">
                        <label for="notes">Notes</label>
                        <textarea name="notes" id="notes" rows="8" class="form-control form-control-lg">{{old('notes')}}</textarea>
                        <div class="js-error p-2 text-danger text-center bold"></div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <a href="javascript:void(0)"class="btn btn-action sister block js-submit-appointment">Save Appointment</a>
                        <a href="javascript:void(0)"class="btn btn-action brother block js-submit-not-interested hide">Save Appointment</a>
                        <a href="javascript:void(0)"class="btn btn-action warning block js-submit-in-progress hide">Save Appointment</a>

                    </div>
                </div>

            </div>
        </div>
    {{--END Prospect Progress--}}



@endsection


@section('scripts')
    <script>

        $(function(){
            $('.js-cancel-prospect').click(function(){
                location.reload();
            })

            $('.js-edit-prospect').click(function(){
                $(this).addClass('hide');
                $('.js-save-prospect').removeClass('hide');
                $('.js-cancel-prospect').removeClass('hide');

               var title                = $('#title').removeAttr('disabled');
               var name                 =  $('#name').removeAttr('disabled');
               var surname              =  $('#surname').removeAttr('disabled');

               var address_1            =  $('#address_1').removeAttr('disabled');
               var address_2            =  $('#address_2').removeAttr('disabled');
               var address_3            =  $('#address_3').removeAttr('disabled');
               var address_4            =  $('#address_4').removeAttr('disabled');
               var address_5            =  $('#address_5').removeAttr('disabled');
               var post_code            =  $('#post_code').removeAttr('disabled');


               var book_id              =  $('#name').attr('book-id');
               var vehicle_reg          =  $('#vehicle_reg').removeAttr('disabled');
               var vehicle_description  =  $('#vehicle_description').removeAttr('disabled');
               var email                =  $('#email').removeAttr('disabled');
               var home_phone           =  $('#home_phone').removeAttr('disabled');
               var mobile               =  $('#mobile').removeAttr('disabled');

                //Saves Prospect
                $('.js-save-prospect').click(function(){
                    $(this).addClass('disabled');

                    fetch('/dashboard/customers/update-prospect',{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            book_id: book_id,
                            title:title.val(),
                            name:name.val(),
                            surname:surname.val(),
                            address_1:address_1.val(),
                            address_2:address_2.val(),
                            address_3:address_3.val(),
                            address_4:address_4.val(),
                            address_5:address_5.val(),
                            post_code:post_code.val(),

                            email:email.val(),
                            home_phone:home_phone.val(),
                            mobile:mobile.val(),
                            vehicle_reg:vehicle_reg.val(),
                            vehicle_description:vehicle_description.val(),

                        }),

                    })
                    .then((response) => response.json())
                    .then((response) => {
                        //console.log(response);
                        location.reload();


                    })
                    .catch(error => console.log('Error:' + error))

                })

            })
        })


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
                $('.js-error').removeClass('text-danger').html('').prev().removeClass('border-danger');
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
                $('.js-error').removeClass('text-danger').html('').prev().removeClass('border-danger');
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
            $('.js-in-progress').click(function(e){
                $('.js-error').removeClass('text-danger').html('').prev().removeClass('border-danger');
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

            // Adds a value to the checkbox on click
            $('#call_back').click(function(){
                if($('#call_back').is(':checked'))
                {
                    $(this).val(1)
                }else
                {
                    $(this).val(0)
                }
            });

            // Adds a value to the checkbox on click
            $('#call_made').click(function(){
                if($('#call_made').is(':checked'))
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

            //Time Slots
            $('#time-group').on('click', '.js-time', function(){
                $('#time-group .js-time').removeClass('current-time active');
                $(this).addClass('current-time active');

                var dealership_id   =   $(this).attr('dealership-id');
                var date_id         =   $(this).attr('date-id');
                var event_id        =   $(this).attr('event-id');
                var time_id         =   $(this).attr('time-id');
                //alert(time_id + " - " +event_id + " - " + date_id + " - " + dealership_id);

                $.ajax({
                    url: '/dashboard/appointments/get-execs?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id+'&time_id='+time_id,
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


        $('.js-submit-appointment').addClass('disabled');

        $('.js-submit-appointment').click(function(){

            $('.pop-up-wrapper-spin ').removeClass('hide')

            var dealership_id = $('#dealership_id').val();
            var event_id = $('#event_id').val();


            var book_id = $('#name').attr('book-id');
            var date = $('.current-date').attr('date');
            var time_id = $('.current-time').attr('time-id');
            var exec_id = $('.current-exec').attr('exec-id');

            var call_attempts = $('#call_attempts').val();
            var call_made = $('#call_made').val();
            var call_back = $('#call_back').val();
            var message_left = $('#message_left').val();



            if ($('#friend_interest_yes').is(":checked")){
                var friend_interest = 1;
            }else{
                var friend_interest = 0;
            }

            var friend_name = $('#friend_name').val();
            var friend_model_interest = $('#friend_model_interest').val();

            //alert(call_attempts + " - " +call_made + " - " +call_back+ " - " +message_left)

            var registration = $('#registration').val();
            var make = $('#make').val();
            var colour = $('#colour').val();
            var fuel_type = $('#fuel_type').val();
            var mileage = $('#mileage').val();

            var model_interest = $('#model_interest').val();
            var drink = $('#drink').val();
            var preference = $('#preference').val();


            var vehicles = $('.js-select-vehicles img.active');
            var vehicles = $.map(vehicles, e => $(e).attr('data-vehicle'));

            var notes = $('#notes').val();

            if($('.no-part-exchange  h2').hasClass('active')){
                var part_exchange =   0;
            }else{
                var part_exchange =   1;
            }

            //Checks if Exec was selected
            if($(".current-exec")[0]){

                if($('#friend_interest_yes').is(":checked") && $('#friend_name').val() == ""){
                    if($('#friend_name').val() == ""){
                        //scrool to where the error is
                        var friendPosition = $('#friend_name').offset();
                        $('html, body').animate({scrollTop: friendPosition.top}, "slow");
                        $('#friend_name').addClass('border-danger').next('.js-error').addClass('text-danger').html('* Friend Name\'s required')

                    }

                }else{

                    //alert(event_id + " - " +dealership_id + " - " +part_exchange + " - " +registration + " - " + make + " - " + colour + " - " + fuel_type + " - " + mileage + " - " + book_id + " - " + date + " - " + time_id + " - " + exec_id + " - " + vehicles + " - " + model_interest + " - " + drink + " - " + preference+ " - " + notes )

                    fetch('/dashboard/appointment/store',{
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

                            date: date,
                            time_id: time_id,
                            exec_id: exec_id,

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

                            call_attempts: call_attempts,
                            call_made: call_made,
                            call_back: call_back,
                            message_left: message_left,

                            notes: notes

                        }),
                    })
                    .then((response) => response.json())
                    .then((response) => {
                        console.log(response);
                        $('.pop-up-wrapper-spin ').addClass('hide')
                        //alert('Appointment has been created, you will be redirected to Prospects page!')
                        //window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id;

                        //Notifies user that changes have been saved
                        /**/
                        $.confirm({
                            title: '<span class="text-brand">Success!</span>',
                            content: 'Appointment has been created',

                            buttons: {
                                heyThere: {
                                    text: 'Go to Prospects', // text for button
                                    btnClass: 'btn-action sister fs-80', // class for the button

                                    action: function(heyThereButton){
                                        window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;

                                    }
                                },
                            }
                        });


                    })
                    .catch(error => console.log('Error:' + error))
                }

            }else{
                //scrool to where the error is
                var timePosition = $('#exec-group').offset();
                $('html, body').animate({scrollTop: timePosition.top}, "slow");
                $('.js-appointment-exec').addClass('border-danger').next('.js-error').addClass('text-danger').html('* Exec needs to be selected')

            }

        })

        $('.js-submit-not-interested').click(function(){

            $('.pop-up-wrapper-spin ').removeClass('hide')

            var dealership_id           =   $('#dealership_id').val();
            var event_id                =   $('#event_id').val();
            var book_id                 =   $('#name').attr('book-id');
            var notes                   =   $('#notes').val();
            var exec_id                 =   $('.current-exec').attr('exec-id');

            var call_attempts           =   $('#call_attempts').val();
            var call_made               =   $('#call_made').val();
            var call_back               =   $('#call_back').val();
            var message_left            =   $('#message_left').val();

            //alert(message_left + " - " +call_back + " - " +call_made +  " - " + call_attempts )

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to mark Prospect as Not Interested',
                buttons: {
                    confirm: function (e) {
                        $.ajax({
                            success: function (response)
                            {

                                fetch('/dashboard/appointment/not-interested',{
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
                                        exec_id: exec_id,

                                        call_attempts: call_attempts,
                                        call_made: call_made,
                                        call_back: call_back,
                                        message_left: message_left,
                                        notes: notes

                                    }),
                                })
                                .then((response) => response.json())
                                .then((response) => {
                                   console.log(response);

                                   $('.pop-up-wrapper-spin ').addClass('hide')
                                        $.confirm({
                                            title: '<span class="text-brand">Success!</span>',
                                            content: 'Prospect Saved has been save Not Interested',

                                            buttons: {
                                                tryAgain: {
                                                    text: 'Prospects page',
                                                    btnClass: 'btn-action brand fs-80',
                                                    action: function(){
                                                        window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;
                                                    }

                                                },
                                                heyThere: {
                                                    text: 'Appointments page', // text for button
                                                    btnClass: 'btn-action sister fs-80', // class for the button

                                                    action: function(heyThereButton){
                                                        window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;

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
            var event_id                =   $('#event_id').val();
            var book_id                 =   $('#name').attr('book-id');
            var notes                   =   $('#notes').val();
            //var exec_id                 =   $('.current-exec').attr('exec-id');
            var call_attempts           =   $('#call_attempts').val();
            var call_made               =   $('#call_made').val();
            var call_back               =   $('#call_back').val();
            var message_left            =   $('#message_left').val();


            //    / alert(dealership_id + " - "+event_id + " - "+ book_id + " - "+notes + " - "+ call_attempts + " - "+ call_made + " - "+ call_back + " - "+message_left  )


            if(!$('#call_made').prop('checked') && !$('#call_back').prop('checked')){
                    //scrool to where the error is
                    var call_made = $('#call_made').offset();
                    $('html, body').animate({scrollTop: notes.top}, "slow");
                    $('#call_made').addClass('border-danger').next('.js-error').addClass('text-danger').html('* You need to make a call.')

            } else if($('#notes').val() == ""){
                //scrool to where the error is
                var notes = $('#notes').offset();
                $('html, body').animate({scrollTop: notes.top}, "slow");
                $('#notes').addClass('border-danger').next('.js-error').addClass('text-danger').html('* You\'re required to add notes.')

            }else{

                $('.pop-up-wrapper-spin ').removeClass('hide')

                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to submit changes?',
                    buttons: {

                        confirm: function (e) {
                            $.ajax({
                                success: function (response)
                                {


                                    fetch('/dashboard/appointment/in-progress',{
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
                                            //exec_id: exec_id,

                                            call_attempts: call_attempts,
                                            call_made: call_made,
                                            call_back: call_back,
                                            message_left: message_left,
                                            notes: notes

                                        }),
                                    })
                                    .then((response) => response.json())
                                    .then((response) => {
                                        console.log(response);

                                        $('.pop-up-wrapper-spin ').addClass('hide')
                                        /**/
                                        $.confirm({
                                            title: '<span class="text-brand">Success!</span>',
                                            content: 'Changes has been made!',

                                            buttons: {
                                                tryAgain: {
                                                    text: 'Prospects page',
                                                    btnClass: 'btn-action brand fs-80',
                                                    action: function(){
                                                        window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;
                                                    }

                                                },
                                                heyThere: {
                                                    text: 'Appointments page', // text for button
                                                    btnClass: 'btn-action sister fs-80', // class for the button

                                                    action: function(heyThereButton){
                                                        window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;

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
@endsection

@extends('_layouts._dashboard')


@section('content')
    <div class="pop-up-wrapper-spin d-flex justify-content-center hide">
        <div class="align-self-center text-center">
            <p class="text-white bold"> Please be patient, your request is being processed! </p>
            <i class="fas fa-spinner fa-spin fs-300 text-white"></i>
        </div>
    </div>

    @if($appointment->completed == 1)
        <div class="alert alert-success rounded-0">
            <i class='far fa-laugh'></i> Appointment has been completed. You can view it but not able to make any changes.
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h1 class="display-4">
                <i class="fas fa-book-reader fs-110"></i> Edit Prospect Appointment for [{{$dealership->name}}]
                <span class="h1-button" style="">
                    <a href="{{route('admin.appointment.prospect', [$event_id, $dealership_id] )}}" class="btn btn-border sister"><i class="fas fa-angle-double-left mr-1"></i> Back</a>
                </span>
            </h1>
        </div>
    </div>

    @include('admin.inc._messages')

    <form action="{{route('customer.update.prospect')}}" method="post">
        @csrf
        {{-- @method('patch') --}}

        <input type="hidden" id="event_id" name="event_id" value="{{$event_id}}" >
        <input type="hidden" id="dealership_id" name="dealership_id" value="{{$dealership->id}}" >
        <input type="hidden" id="book_id" name="book_id" value="{{$appointment->book_id}}" >


        {{--Prospect Details--}}
            <div class="s-card shadow">
                <div class="s-card-header bg-brother border-0 border-bottom">
                    <i class="fas fa-address-card mr-1"></i>   Prospect Details
                </div>

                <div class="s-card-body px-3 pb-3">
                    <div class="row pt-2">
                        <div class="col-lg-4">
                            <label for="title" class="bold">Title<span class="text-danger">*</span></label>
                            <input id="title" type="text" name="title" class="form-control form-control-lg" book-title="{{$prospect->title}}" value="{{$prospect->title}}"  disabled="" required>
                        </div>

                        <div class="col-lg-4">
                            <label for="name" class="bold">Name </label>
                            <input id="name" type="text" name="name" class="form-control form-control-lg" book-id="{{$prospect->id}}" value="{{$prospect->name}}"  disabled="" >
                        </div>

                        <div class="col-lg-4">
                            <label for="surname" class="bold">Surname <span class="text-danger">*</span></label>
                            <input id="surname" type="text" name="surname" class="form-control form-control-lg" value="{{$prospect->surname}}"  disabled="" required>
                        </div>
                    </div>

                    <div class="row py-2">
                        <div class="col-lg-4">
                            <label for="address_1" class="bold">Address 1:  </label>
                            <input  type="text" id="address_1" name="address_1" class="form-control form-control-lg" value="{{$prospect->address_1}}"  disabled>
                        </div>

                        <div class="col-lg-4">
                            <label for="address_2" class="bold">Address 2:  </label>
                            <input  type="text" id="address_2" name="address_2" class="form-control form-control-lg" value="{{$prospect->address_2}}"  disabled>
                        </div>

                        <div class="col-lg-4">
                            <label for="address_3" class="bold">Address 3:  </label>
                            <input  type="text" id="address_3" name="address_3" class="form-control form-control-lg" value="{{$prospect->address_3}}"  disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="address_4" class="bold">Address 4:  </label>
                            <input  type="text" id="address_4" name="address_4" class="form-control form-control-lg" value="{{$prospect->address_4}}"  disabled>
                        </div>

                        <div class="col-lg-4">
                            <label for="address_5" class="bold">Address 2:  </label>
                            <input  type="text" id="address_5" name="address_5" class="form-control form-control-lg" value="{{$prospect->address_5}}"  disabled>
                        </div>

                        <div class="col-lg-4">
                            <label class="bold">Post Code</label>
                            <input type="text"  id="post_code" name="post_code" class="form-control form-control-lg "  value="{{$prospect->post_code}}" disabled>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-lg-4">
                            <label class="bold">Email  </label> <span class="text-danger">*</span>
                            <input  type="email" id="email" name="email" class="form-control form-control-lg" value="{{$prospect->email}}"  disabled required>
                        </div>

                        <div class="col-lg-4">
                            <label class="bold">Home Phone</label>
                            <input type="text" id="home_phone" name="home_phone" class="form-control form-control-lg "  value="{{$prospect->home_phone}}" disabled>
                        </div>

                        <div class="col-lg-4">
                            <label class="bold">Mobile Number</label>
                            <input type="text" id="mobile" name="mobile" class="form-control form-control-lg "  value="{{$prospect->mobile}}" disabled>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-lg-4">
                            <label for="vehicle_reg" class="bold">Vehicle Registration</label>
                            <input type="text" id="vehicle_reg" name="vehicle_reg" class="form-control form-control-lg " value="{{$prospect->vehicle_reg}}" disabled >
                        </div>

                        <div class="col-lg-4">
                            <label for="vehicle_description" class="bold">Vehicle Decription</label>
                            <input type="text" id="vehicle_description" name="vehicle_description" class="form-control form-control-lg " value="{{$prospect->vehicle_description}}" disabled >
                        </div>
                    </div>

                    @admin('super-admin,renewals')
                        <div class="row mt-3">

                            <div class="col-6">
                                <a href="javascript:void(0)" class="btn btn-action sister block js-edit-prospect"><i class="far fa-edit mr-1"></i> Edit Prospect</a>

                                <button type="submit" class="btn btn-action brand block js-save-prospect hide" >Save Prospect</button>
                                {{-- <a href="javascript:void(0)" class="btn btn-action brand block js-save-prospect hide"><i class="fas fa-save mr-1"></i> Save Prospect</a> --}}
                            </div>

                            <div class="col-6">
                                <a href="javascript:void(0)" class="btn btn-action warning block js-cancel-prospect hide"><i class="fas fa-times mr-1"></i> Dont Save</a>
                            </div>
                        </div>
                    @endadmin

                </div>
            </div>
        {{--END Prospect Details--}}

    </form>

    <form action="{{route('admin.appointment.update')}}" method="post">

        <input type="hidden" id="appointment_id" name="appointment_id" value="{{$appointment->id}}" >
        <input type="hidden" id="event_id" name="event_id" value="{{$event_id}}" >
        <input type="hidden" id="dealership_id" name="dealership_id" value="{{$dealership->id}}" >
        <input type="hidden" id="book_id" name="book_id" value="{{$appointment->book_id}}" >

        <input type="hidden" id="date" name="date" value="{{$appointment->date}}" >
        <input type="hidden" id="event_time_id" name="event_time_id" value="{{$appointment->event_time_id}}" >
        <input type="hidden" id="exec_id" name="exec_id" value="{{$appointment->exec_id}}" >

        @csrf
        {{--Booking Details--}}
            <div class="s-card shadow mt-5">
                <div class=" s-card-header bg-brand"><i class="fas fa-address-card mr-1"></i>   Booking Details </div>

                <div class="s-card-body px-3 alert-brother border-0">
                    <div class="row">
                        <div class="col-lg-4">
                            <div id="date-group" class="row justify-content-center">
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

                        <div class="col-lg-4 ">
                            <div id="time-group" class="row justify-content-center ">
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
                        </div>

                        <div class="col-lg-4 ">
                            <div id="exec-group" class="row justify-content-center ">

                                <div  class="row justify-content-center js-appointment-exec">
                                    <label class="pl-3 bold"><i class="fas fa-user-tie"></i> Select Exec <span class="text-danger">*</span></label>
                                    @foreach($execs->exec($appointment->event_time_id) as $exec)
                                        <div class="col-12 p-0">
                                            <div class="js-exec @if($exec->id == $appointment->exec_id) current-exec active @endif @if(execAdminAppointment($appointment->event_time_id, $exec->id)) js-booked @endif
                                                        " time-id="{{$appointment->event_time_id}}" exec-id="{{$exec->id}}" event-id="{{$event_id}}" appointment-id="{{$appointment->id}}"  dealership-id="{{$dealership->id}}" >
                                                    {{$exec->name}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="js-error p-2 text-danger text-center bold"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row justify-content-center pb-2">
                            <div class="col-lg-4 text-center ">
                                <label for="guest_friend" class="bold alert-sister block py-2 "> Is Prospect bringing a friend?</label>
                                <div class="bold mt-1">

                                    <div class="form-check form-check-inline">
                                        <label for="friend_interest_yes" class="form-check-label">Yes</label>
                                        <input type="checkbox" id="friend_interest_yes" class="form-check-input friend_interest" name="friend_interest" value="1"
                                            @if($appointment->friend_interest == 1) checked @endif
                                        >
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label for="friend_interest_no" class="form-check-label">No</label>
                                        <input type="checkbox" id="friend_interest_no" class="form-check-input friend_interest" name="friend_interest" value="0"
                                            @if($appointment->friend_interest == 0) checked @endif
                                        >
                                    </div>

                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-12 js-friend @if($appointment->friend_interest == 0) hide @endif mt-1 text-start">
                                        <div class="border-top mb-1"></div>
                                        <label for="friend_name" class="bold">Friend Name  </label>
                                        <input placeholder="Enter your friends name" id="friend_name" type="text" class=" form-control form-control-lg" name="friend_name" value="{{$appointment->friend_name}}" autocomplete="off">
                                        <div class="js-error p-1 text-danger text-center bold"></div>
                                        <label for="model_interest" class="bold">Friend Model Interest</label>
                                        <input placeholder="Friend Model Interest" id="friend_model_interest" type="text" class="form-control form-control-lg " name="friend_model_interest" value="{{$appointment->friend_model_interest}}" autocomplete="off">
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

                <div class="s-card-body px-3 pt-2 py-0">
                    <div class="row">
                        <div class="col-lg-4 my-3">
                            <div class="v-reg mt-1">
                                <span>Registration Number:</span>
                                <input type="text" id="reg_number" name="reg_number" autocomplete="off">
                            </div>
                            <a href="javascript:void(0)" class="btn btn-action sister block mt-0 js-get-vehicle">Get Vehicle Details</a>
                        </div>

                        <div class="col-lg-4">
                            <div class="show-vehicle-details mt-3 @if($appointment->registration == "") hide @endif">
                                <div class="fs-100 p-4 alert-warning text-dark" style="margin-top: -5px">
                                    <div class="mb-2">
                                        <span class="bold">Registration:</span> {{$appointment->registration}}
                                        <input type="hidden" name="registration_number" id="registration" class="form-control" value="">
                                    </div>
                                    <div class="mb-2">
                                        <span class="bold">Make:</span> {{$appointment->make}}
                                        <input type="hidden" name="make" id="make" class="form-control" disabled="">
                                    </div>
                                    <div class="mb-2">
                                        <span class="bold">Colour:</span> {{$appointment->colour}}
                                        <input type="hidden" name="colour" id="colour" class="form-control" disabled="">
                                    </div>
                                    <div class="mb-2">
                                        <span class="bold">Fuel Type:</span> {{$appointment->fuel_type}}
                                        <input type="hidden" name="fuel_type" id="fuel_type" class="form-control" disabled="">
                                    </div>
                                </div>

                                <div class="v-mileage mt-4">
                                    <input type="text" name="mileage" id="mileage" class="form-control" value="{{$appointment->mileage}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 no-part-exchange ">
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
                <div class=" s-card-header bg-brother"><i class="fas fa-sliders-h mr-1"></i>   Booking Preferences </div>

                <div class="s-card-body px-3 pt-1">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <label for="mobile" class="bold">Drink Preference</label>
                            <span class="arrow-down"><i class="fas fa-caret-down"></i></span>
                            <select name="drink" id="drink" class="form-control form-control-lg">
                                <option value="">--Select one--</option>
                                <option value="tea" @if($appointment->drink == "tea") selected @endif>Tea</option>
                                <option value="coffee" @if($appointment->drink == "coffee") selected @endif>Coffee</option>
                                <option value="water" @if($appointment->drink == "water") selected @endif>Water</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mt-2">
                            <label for="preference" class="bold">Milk/Sugar etc</label>
                            <input   id="preference" type="text" class="form-control form-control-lg" name="preference" value="{{$appointment->preference}}" autocomplete="off" >
                        </div>
                    </div>

                    <div class="col-12 my-3 py-2 px-3 alert-brother">
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

                        <div class="row mt-2">
                            <div class="col-12 bold">
                                <label for="model_interest">Vehicles</label>
                                <div class="row text-center js-models">


                                    @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                                        <div class="col-lg-2 mb-2">
                                            <lable class="mb-2 bg-white js-select-vehicles cursor">
                                                <img class="border block


                                                    @if(isset($appointment->vehicles))
                                                        @php $obj = json_decode($appointment->vehicles, true); @endphp
                                                        @if (is_array($obj) || is_object($obj))
                                                            @foreach($obj as $key => $value)
                                                                @if($value == $vehicle->id) active @endif
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                " data-vehicle="{{$vehicle->id}}"  src="{{asset('assets/images/public/general')}}/{{$vehicle->filename}}" alt="">

                                                <input type="checkbox" name="vehicles[]" class="checkbox hide" value="{{$vehicle->id}}"
                                                    @if(isset($appointment->vehicles))
                                                        @php $obj = json_decode($appointment->vehicles, true); @endphp
                                                        @if (is_array($obj) || is_object($obj))
                                                            @foreach($obj as $key => $value)
                                                                @if($value == $vehicle->id) checked @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                >


                                            </lable>
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
                                <input type="checkbox" id="call_made" class="form-check-input js-call-made" name="call_made" value="@if($appointment->call_made == 1) 1 @else 0 @endif" @if($appointment->call_made == 1) checked @endif >
                            </div>
                            <span class="js-error p-2 text-danger text-center"></span>
                        </div>

                        <div class="col-lg-4 bold  border-end pb-1 pt-2">
                            <div class="form-check form-check-inline">
                                <label for="call_back" class="form-check-label">Call back required</label>
                                <input type="checkbox" id="call_back" class="form-check-input js-call-back" name="call_back" value="@if($appointment->call_back == 1) 1 @else 0 @endif" @if($appointment->call_back == 1) checked @endif >
                            </div>
                        </div>

                        <div class="col-lg-4 bold  pb-1 pt-2">
                            <div class="form-check form-check-inline">
                                <label for="message_left" class="form-check-label">Message Left</label>
                                <input type="checkbox" id="message_left" class="form-check-input js-call-message" name="message_left" value="{{$appointment->message_left}}"
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

                    @if($appointment->completed != 1)
                        <div class="row mt-3">

                            <div class="col-12 text-center mb-3 js-send-notification"></div>

                            <div class="col-lg-12">
                                <button type="submit" name="btn_submit_appointment" class="btn btn-action brother block js-submit-appointment @if($appointment->confirm == 1) @else hide @endif">Save Appointment</button>
                                <button type="submit" name="btn_not_interested" class="btn btn-action sister block js-submit-not-interested @if($appointment->not_interested == 1) @else hide @endif">Save Appointment</button>
                                <button type="submit" name="btn_cancelled" class="btn btn-action danger block js-submit-cancelled @if($appointment->cancelled == 1) @else hide @endif">Save Appointment</button>
                                <button type="submit" name="btn_in_progress" class="btn btn-action warning block js-submit-in-progress  @if($appointment->confirm == 0 && $appointment->cancelled == 0 && $appointment->not_interested == 0) @else hide @endif">Save Appointment</button>
                            </div>

                        </div>
                    @endif

                </div>
            </div>
        {{--END Prospect Progress--}}
    </form>

@endsection


@section('scripts')
    <script>
        $(function(){
            $('.js-select-vehicles img').click(function(){
                $(this).toggleClass('active')
                $(this).next('.checkbox').trigger('click');
            })
        })
    </script>


    @if($appointment->completed != 1)
        <script>

            $(function(){
                $('.js-cancel-prospect').click(function(){
                    location.reload();
                })

                $('.js-edit-prospect').click(function(){
                    $(this).addClass('hide');
                    $('.js-save-prospect').removeClass('hide');
                    $('.js-cancel-prospect').removeClass('hide');

                    var title = $('#title').removeAttr('disabled');
                    var name = $('#name').removeAttr('disabled');
                    var surname = $('#surname').removeAttr('disabled');

                    var address_1 = $('#address_1').removeAttr('disabled');
                    var address_2 = $('#address_2').removeAttr('disabled');
                    var address_3 = $('#address_3').removeAttr('disabled');
                    var address_4 = $('#address_4').removeAttr('disabled');
                    var address_5 = $('#address_5').removeAttr('disabled');
                    var post_code = $('#post_code').removeAttr('disabled');


                    var book_id = $('#name').attr('book-id');
                    var vehicle_reg = $('#vehicle_reg').removeAttr('disabled');
                    var vehicle_description = $('#vehicle_description').removeAttr('disabled');
                    var email = $('#email').removeAttr('disabled');
                    var home_phone = $('#home_phone').removeAttr('disabled');
                    var mobile = $('#mobile').removeAttr('disabled');

                })
            })



            $(function(){

                //toggles between call made and call back required (unchecks call_back)
                $('.js-call-made').click(function(){
                    $(this).val(1)
                    $('.js-call-back').val(0)
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
                    $('.js-call-made').val(0)
                    if($('.js-call-made').prop('checked')){
                        $('.js-call-made').prop('checked', function(_, checked) {
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

                //Empties vehicles details container if clicled no vehicle exchange
                $('.js-part-exchange').click(function(){
                    $('.show-vehicle-details').html('');
                    $('#reg_number').val('')
                    $('.v-reg span').removeClass('slide-up')

                    $(this).addClass('active');
                });

                //toggles between Confirm and Cancelled
                $('.js-confirm').click(function(){
                    let send_notification = '<div class="form-check form-check-inline">' +
                                                '<label for="send_prospect_email" class="form-check-label me-2 bold cursor">Send Prospect Confirmation Email</label>' +
                                                '<input type="checkbox" id="send_prospect_email" class="form-check-input cursor" name="send_prospect_email" value="">' +
                                            '</div>'
                    $('.js-send-notification').html(send_notification)

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

                //Toggles between Cancelled and Confirm
                $('.js-cancelled').click(function(e){
                    $(this).val(1)
                    $('.js-send-notification').html('')

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

                //Mark if customer is or not interested
                $('.js-not-interested').click(function(){
                    $(this).val(1)
                    $('.js-send-notification').html('')
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
                    $('.js-send-notification').html('')
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
                    $('.js-appointment-exec').html("");
                    $('#date-group .js-appointment-date ').removeClass('current-date active');
                    $(this).addClass('current-date active');

                    var dealership_id = $(this).attr('dealership-id');
                    var date_id = $(this).attr('date-id');
                    var date = $(this).attr('date');
                    var event_id = $(this).attr('event-id');
                    var appointment_id = $(this).attr('appointment-id');

                    $('#date').val(date)
                    $('#event_time_id').val("")

                    //alert(event_id + " - " + date_id + " - " + dealership_id);

                    $.ajax({
                        url: '/dashboard/appointments/get-edit-times?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id +'&appointment_id='+appointment_id,
                            success:function(response){
                                $('.js-appointment-time').html(response);
                            }
                    });
                });

                //Time Slots
                $('#time-group').on('click', '.js-time', function(){
                    $('#time-group .js-time').removeClass('current-time active');
                    $(this).addClass('current-time active');

                    var dealership_id = $(this).attr('dealership-id');
                    var date_id = $(this).attr('date-id');
                    var event_id = $(this).attr('event-id');
                    var time_id = $(this).attr('time-id');
                    var appointment_id = $(this).attr('appointment-id');
                    var book_id = $(this).attr('book-id');
                    //alert(time_id + " - " +event_id + " - " + date_id + " - " + dealership_id + " - " + appointment_id + " - " + book_id);

                    $('#event_time_id').val(time_id)
                    $('#exec_id').val("")

                    $.ajax({
                        url: '/dashboard/appointments/get-edit-execs?event_id='+event_id +'&date_id='+date_id +'&dealership_id='+dealership_id+'&time_id='+time_id+'&appointment_id='+appointment_id+'&book_id='+book_id,
                            success:function(response){
                                //console.log(response);
                                $('.js-appointment-exec').html(response);
                            }
                    });

                });

                //Execs
                $('#exec-group').on('click', '.js-exec', function(){
                    if(!$(this).hasClass('js-booked')){
                        $('#exec-group .js-exec').removeClass('current-exec active');
                        $(this).addClass('current-exec active');
                        $('.js-error').html('');
                    }

                    var exec_id = $(this).attr('exec-id');

                    $('#exec_id').val(exec_id)
                });


            });

            //toggles class .active when selecting vehicles
            $('.js-models a img').click(function(){
                // alert(0);
                $(this).toggleClass('active');
            });


            // $('.js-submit-not-interested').click(function(){

            //     var dealership_id = $('#dealership_id').val();
            //     var event_id =   $('#event_id').val();
            //     var book_id = $('#name').attr('book-id');
            //     var notes = $('#notes').val();
            //     var exec_id = $('.current-exec').attr('exec-id');
            //     var call_attempts = $('#call_attempts').val();
            //     var call_made = $('#call_made').val();
            //     var call_back = $('#call_back').val();
            //     var message_left = $('#message_left').val();
            //     $.confirm({
            //         title: 'Confirm!',
            //         content: 'Are you sure you want to mark Prospect as Not Interested',
            //         buttons: {
            //             confirm: function (e) {
            //                 $.ajax({
            //                     success: function (response)
            //                     {

            //                         fetch('/dashboard/appointment/not-interested',{
            //                             method: 'POST',
            //                             headers: {
            //                                 'Content-Type': 'application/json',
            //                                 'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
            //                                 'X-Requested-With': 'XMLHttpRequest',
            //                             },
            //                             body: JSON.stringify({
            //                                 dealership_id: dealership_id,
            //                                 event_id: event_id,
            //                                 book_id: book_id,
            //                                 exec_id: exec_id,

            //                                 call_attempts: call_attempts,
            //                                 call_made: call_made,
            //                                 call_back: call_back,
            //                                 message_left: message_left,
            //                                 notes: notes

            //                             }),
            //                         })
            //                         .then((response) => response.json())
            //                         .then((response) => {
            //                             console.log(response);

            //                             $('.pop-up-wrapper-spin ').removeClass('hide')
            //                             /**/
            //                             $.confirm({
            //                                 title: '<span class="text-brand">Success!</span>',
            //                                 content: 'Prospect Saved has been save Not Interested',

            //                                 buttons: {
            //                                     tryAgain: {
            //                                         text: 'Prospects page',
            //                                         btnClass: 'btn-action brand fs-80',
            //                                         action: function(){
            //                                             window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;
            //                                         }

            //                                     },
            //                                     heyThere: {
            //                                         text: 'Appointments page', // text for button
            //                                         btnClass: 'btn-action sister fs-80', // class for the button

            //                                         action: function(heyThereButton){
            //                                             window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;

            //                                         }
            //                                     },
            //                                 }
            //                             });

            //                         })
            //                         .catch(error => console.log('Error:' + error))

            //                     }
            //                 });
            //             },
            //             cancel: function () {
            //                 location.reload();
            //             }
            //         }
            //     });
            // });

            // $('.js-submit-cancelled').click(function(){

            //     $('.pop-up-wrapper-spin ').removeClass('hide')

            //     var dealership_id = $('#dealership_id').val();
            //     var event_id = $('#event_id').val();
            //     var book_id = $('#name').attr('book-id');
            //     var notes = $('#notes').val();
            //     var exec_id = $('.current-exec').attr('exec-id');
            //     var call_attempts = $('#call_attempts').val();
            //     var call_made = $('#call_made').val();
            //     var call_back = $('#call_back').val();
            //     var message_left = $('#message_left').val();

            //     $.confirm({
            //         title: 'Confirm!',
            //         content: 'Are you sure you want to CANCEL Prospect appointment',
            //         buttons: {
            //             confirm: function (e) {
            //                 $.ajax({
            //                     success: function (response)
            //                     {
            //                         fetch('/dashboard/appointment/cancelled',{
            //                             method: 'POST',
            //                             headers: {
            //                                 'Content-Type': 'application/json',
            //                                 'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
            //                                 'X-Requested-With': 'XMLHttpRequest',
            //                             },
            //                             body: JSON.stringify({
            //                                 dealership_id: dealership_id,
            //                                 event_id: event_id,
            //                                 book_id: book_id,
            //                                 exec_id: exec_id,

            //                                 call_attempts: call_attempts,
            //                                 call_made: call_made,
            //                                 call_back: call_back,
            //                                 message_left: message_left,
            //                                 notes: notes

            //                             }),
            //                         })
            //                         .then((response) => response.json())
            //                         .then((response) => {
            //                             console.log(response);

            //                             $('.pop-up-wrapper-spin ').addClass('hide')
            //                             /**/
            //                             $.confirm({
            //                                 title: '<span class="text-brand">Success!</span>',
            //                                 content: 'Prospect Saved has been save Not Interested',

            //                                 buttons: {
            //                                     tryAgain: {
            //                                         text: 'Prospects page',
            //                                         btnClass: 'btn-action brand fs-80',
            //                                         action: function(){
            //                                             window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;
            //                                         }

            //                                     },
            //                                     heyThere: {
            //                                         text: 'Appointments page', // text for button
            //                                         btnClass: 'btn-action sister fs-80', // class for the button

            //                                         action: function(heyThereButton){
            //                                             window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;

            //                                         }
            //                                     },
            //                                 }
            //                             });

            //                         })
            //                         .catch(error => console.log('Error:' + error))

            //                     }
            //                 });
            //             },
            //             cancel: function () {
            //                 location.reload();
            //             }
            //         }
            //     });

            // });

            // $('.js-submit-in-progress').click(function(){

            //     var dealership_id = $('#dealership_id').val();
            //     var event_id = $('#event_id').val();
            //     var book_id = $('#name').attr('book-id');
            //     var notes = $('#notes').val();
            //     var exec_id = $('.current-exec').attr('exec-id');
            //     var call_attempts = $('#call_attempts').val();
            //     var call_made = $('#call_made').val();
            //     var call_back = $('#call_back').val();
            //     var message_left = $('#message_left').val();

            //     if(!$('#call_made').prop('checked') && !$('#call_back').prop('checked')){
            //             //scrool to where the error is
            //             var call_made = $('#call_made').offset();
            //             $('html, body').animate({scrollTop: notes.top}, "slow");
            //             $('#call_made').addClass('border-danger').next('.js-error').html('* You need to make a call.')

            //     } else if($('#notes').val() == ""){
            //             //scrool to where the error is
            //             var notes = $('#notes').offset();
            //             $('html, body').animate({scrollTop: notes.top}, "slow");
            //             $('#notes').addClass('border-danger').next('.js-error').html('* You\'re required to add notes.')

            //         }else{

            //             $('.pop-up-wrapper-spin ').removeClass('hide')

            //             $.confirm({
            //                 title: 'Confirm!',
            //                 content: 'Are you sure you want to submit changes?',
            //                 buttons: {
            //                     confirm: function (e) {
            //                         $.ajax({
            //                             success: function (response)
            //                             {
            //                                 fetch('/dashboard/appointment/in-progress',{
            //                                     method: 'POST',
            //                                     headers: {
            //                                         'Content-Type': 'application/json',
            //                                         'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
            //                                         'X-Requested-With': 'XMLHttpRequest',
            //                                     },
            //                                     body: JSON.stringify({
            //                                         dealership_id: dealership_id,
            //                                         event_id: event_id,
            //                                         book_id: book_id,
            //                                         exec_id: exec_id,

            //                                         call_attempts: call_attempts,
            //                                         call_made: call_made,
            //                                         call_back: call_back,
            //                                         message_left: message_left,
            //                                         notes: notes

            //                                     }),
            //                                 })
            //                                 .then((response) => response.json())
            //                                 .then((response) => {
            //                                     console.log(response);

            //                                     $('.pop-up-wrapper-spin ').addClass('hide')
            //                                     /**/
            //                                     $.confirm({
            //                                         title: '<span class="text-brand">Success!</span>',
            //                                         content: 'Changes has been made!',

            //                                         buttons: {
            //                                             tryAgain: {
            //                                                 text: 'Prospects page',
            //                                                 btnClass: 'btn-action brand fs-80',
            //                                                 action: function(){
            //                                                     window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;
            //                                                 }

            //                                             },
            //                                             heyThere: {
            //                                                 text: 'Appointments page', // text for button
            //                                                 btnClass: 'btn-action sister fs-80', // class for the button

            //                                                 action: function(heyThereButton){
            //                                                     window.location.href = '/dashboard/appointments/prospects/'+event_id+"/"+dealership_id ;

            //                                                 }
            //                                             },
            //                                         }
            //                                     });

            //                                 })
            //                                 .catch(error => console.log('Error:' + error))
            //                             }
            //                         });
            //                     },
            //                     cancel: function () {
            //                         location.reload();
            //                     }
            //                 }
            //             });
            //         }

            // });

        </script>
    @endif
@endsection

<input type="hidden" id="appointment_id" value="{{$appointment->id}}">
<div class="col-lg-8 js-appointment p-0">
    <div class=" s-card-header alert-brand border-0 border-bottom px-3 py-3 relative">
        <i class="fas fa-book-reader"></i>  Book appointment
        <span class="pop-up-close">X</span>

    </div>
    <div class="s-card-body p-3">
        <div class="row">
            <div class="col-lg-3 mt-3">
                <label for="dealership_id" class="bold">Dealership</label>
                <input   id="dealership_id" type="text" class="form-control form-control-lg " name="dealership_id" dealership-id="{{$dealership->id}}" value="{{$dealership->name}}"  disabled>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="exec_id" class="bold">Sales Exec</label>
                <input   id="exec_id" type="text"  class="form-control form-control-lg " name="exec_id" exec-id="{{$exec->id}}" value="{{$exec->name}}"  disabled>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="book_id" class="bold">Customer Name <span class="text-danger">*</span></label>
                <input   id="book_id" type="text"  class="form-control form-control-lg js-appointment-customer" autocomplete="nope" name="book_id" book-id="{{$book->id}}" value="{{$book->name}}"  disabled>
                <span class="js-error text-danger "></span>
                <div class="js-appointment-customer-wraper alert-brand shadow "></div>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="email" class="bold">Email Address</label>
                <input   id="email" type="email" class="form-control form-control-lg " name="email" value="{{$book->email}}" disabled>
            </div>

        </div>

        <div class="row ">
            <div class="col-lg-3 mt-3">
                <label for="vehicle_reg" class="bold">Vehicle Registration</label>
                <input   id="vehicle_reg" type="text" class="form-control form-control-lg " name="vehicle_reg"  value="{{$book->vehicle_reg}}" disabled >
            </div>

            <div class="col-lg-3 mt-3">
                <label for="post_code" class="bold">Post Code</label>
                <input   id="post_code" type="text" class="form-control form-control-lg " name="post_code" value="{{$book->post_code}}" disabled >
            </div>


            <div class="col-lg-3 mt-3">
                <label for="home_phone" class="bold">Home Phone</label>
                <input   id="home_phone" type="text" class="form-control form-control-lg " name="home_phone"  value="{{$book->home_phone}}" disabled>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="mobile" class="bold">Mobile Number</label>
                <input   id="mobile" type="text" class="form-control form-control-lg " name="mobile" autocomplete="off" value="{{$book->mobile}}" disabled>
            </div>


        </div>

        <div class="col-12 my-4 p-3 alert-brand">
            <div class="row">
                <div class="col-lg-6">
                    <label for="date" class="bold">Appointments Date <span class="text-danger">*</span></label>
                    <input   id="date" type="text" class="form-control form-control-lg js-appointment-date" name="date" event-id="{{$appointment->event_id}}" date="{{$appointment->date}}" value="{{\Carbon\Carbon::parse($appointment->date)->format('d M Y')}}">
                    <span class="js-error text-danger "></span>
                    <div class="js-appointment-dates-wraper alert-brand  shadow "></div>
                </div>
                <div class="col-lg-6">
                    <label for="time" class="bold">Appointment Time<span class="text-danger">*</span></label>
                    <input id="time" type="text" class="form-control form-control-lg js-appointment-time" name="time" time-id="{{$time->id}}" value="{{$time->time}}" autocomplete="off">
                    <span class="js-error text-danger"></span>
                    <div class="js-appointment-time-wraper alert-brand  shadow "></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mt-3">
                <label for="mobile" class="bold">Drink Preference</label>
                <select name="drink" id="drink" class="form-control form-control-lg">
                    <option value="">--Select one--</option>
                    <option value="tea" @if($appointment->drink == "tea") selected @endif>Tea</option>
                    <option value="coffee" @if($appointment->drink == "coffee") selected @endif>Coffee</option>
                    <option value="water" @if($appointment->drink == "water") selected @endif>Water</option>
                </select>
            </div>

            <div class="col-lg-6 mt-3">
                <label for="preference" class="bold">Milk/Sugar etc</label>
                <input   id="preference" type="text" class="form-control form-control-lg" name="preference" value="{{$appointment->preference}}" autocomplete="off" >
            </div>
        </div>

        <div class="col-12 my-4 p-3 alert-brand">
            <div class="row">
                <div class="col-12 bold">
                    <label for="model_interest">Model Interest</label>
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
                    <div class="row">
                        @foreach($vehicles->where('brand_id', $dealership->brand->id) as $vehicle)
                        <div class="col-6 col-md-4 col-lg-2 mb-4">
                                <a href="javascript:void(0)" class="mb-2 bg-white js-select-vehicles">
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

        <div class="row">
            <div class="col-12 bold">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes"  rows="4"  class="form-control form-control-lg">{{$appointment->notes}}</textarea>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <a href="javascript:void(0)"class="btn btn-action sister block js-update-appointment">Update Appointment</a>
            </div>

        </div>

    </div>
</div>

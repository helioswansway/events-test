<div class="col-lg-8 js-appointment p-0">
    <div class=" s-card-header alert-brand border-0 border-bottom px-3 py-3"><i class="fas fa-book-reader"></i>   Book appointment
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
                <input   id="exec_id" type="text"  class="form-control form-control-lg " name="exec_id" exec-id="{{$exec->id}}" value="{{$exec->name}}" >
            </div>

            <div class="col-lg-3 relative mt-3">
                <label for="book_id" class="bold">Customer Name <span class="text-danger">*</span></label>
                <input   id="book_id" type="text"  class="form-control form-control-lg js-appointment-customer" autocomplete="nope" name="book_id" book-id="" value=""  >
                <span class="js-error text-danger "></span>
                <div class="js-appointment-customer-wraper alert-light shadow "></div>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="email" class="bold">Email Address</label>
                <input   id="email" type="email" class="form-control form-control-lg " name="email" value="" required disabled>
            </div>

        </div>

        <div class="row ">
            <div class="col-lg-3 mt-3">
                <label for="vehicle_reg" class="bold">Vehicle Registration</label>
                <input   id="vehicle_reg" type="text" class="form-control form-control-lg " name="vehicle_reg"  value="" disabled>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="post_code" class="bold">Post Code</label>
                <input   id="post_code" type="text" class="form-control form-control-lg " name="post_code" value=" " disabled>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="home_phone" class="bold">Home Phone</label>
                <input   id="home_phone" type="text" class="form-control form-control-lg " name="home_phone"  value="" disabled>
            </div>

            <div class="col-lg-3 mt-3">
                <label for="mobile" class="bold">Mobile Number</label>
                <input   id="mobile" type="text" class="form-control form-control-lg " name="mobile" autocomplete="off" value=" " disabled >
            </div>


        </div>

        <div class="col-12 my-4 p-3 alert-brand">
            <div class="row">
                <div class="col-lg-6 mt-3">
                    <label for="date" class="bold">Appointments Date <span class="text-danger">*</span></label>
                    <input   id="event_date" type="text" class="form-control form-control-lg js-appointment-date" name="date" event-id="" date-id="" value="" disabled>
                    <span class="js-error text-danger "></span>
                    {{--
                        <div class="js-appointment-dates-wraper alert-brand  shadow "></div>
                    --}}
                </div>

                <div class="col-lg-6 mt-3">
                    <label for="time" class="bold">Appointment Time <span class="text-danger">*</span></label>
                    <input id="event_time" type="text" class="form-control form-control-lg js-appointment-time" name="time" time-id="" value="" disabled>
                    <span class="js-error text-danger "></span>
                    {{--
                        <div class="js-appointment-time-wraper alert-brand  shadow "></div>
                    --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mt-3">
                <label for="mobile" class="bold">Drink Preference</label>
                <select name="drink" id="drink" class="form-control form-control-lg">
                    <option value="">--Select one--</option>
                    <option value="tea">Tea</option>
                    <option value="coffee">Coffee</option>
                    <option value="water">Water</option>
                </select>
            </div>

            <div class="col-lg-6 mt-3">
                <label for="preference" class="bold">Milk/Sugar etc</label>
                <input   id="preference" type="text" class="form-control form-control-lg" name="preference" value="" autocomplete="off" >
            </div>
        </div>

        <div class="col-12 my-4 p-3 alert-brand">
            <div class="row">
                <div class="col-12 bold">
                    <label for="model_interest">Model Interest</label>
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
                <textarea name="notes" id="notes"  rows="4"  class="form-control form-control-lg"></textarea>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-lg-12">
                <a href="javascript:void(0)"class="btn btn-action sister block js-submit-appointment">Submit Appointment</a>
            </div>
        </div>

    </div>
</div>

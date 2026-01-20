<div class="col-lg-8 js-appointment p-0">
    <input type="hidden" name="appointment_id" class="js-appointment-id" appointment-id="{{$appointment->id}}">
    <input type="hidden" name="event_id" class="js-event-id" event-id="{{$event_id}}">

    <div class=" s-card-header alert-brand border-0 border-bottom px-3 "><i class="fas fa-clipboard-list"></i>   Create Sale
        <span class="pop-up-close">X</span>
    </div>
    <div class="s-card-body px-2 py-3">
        <div class="row">
            <div class="col-lg-4 ">
                <label  class="bold">Dealership</label>
                <input type="text" class="form-control form-control-lg js-dealership-id" dealership-id="{{$dealership->id}}"  value="{{$dealership->name}}" disabled>
            </div>

            <div class="col-lg-4">
                <label class="bold">Sales Exec</label>
                <input   type="text" class="form-control form-control-lg js-exec-id" event-id="{{$event_id}}" exec-id="{{$exec->id}}"  value="{{$exec->name}}" disabled>
            </div>

            <div class="col-lg-4">
                <label  class="bold">Customer Name</label>
                <input  type="text" class="form-control form-control-lg js-book-id"  book-id="{{$prospect->id}}"  value="{{$prospect->name}} {{$prospect->surname}}" disabled>
            </div>



            <div class="col-lg-4 mt-3">
                <label for="order_number" class="bold">Order/Reg Number</label>
                <input   id="order_number" type="text" class="form-control form-control-lg js-order-number" name="order_number"  value="" >
                <span class="js-error text-danger "></span>
            </div>

            <div class="col-lg-4 mt-3">
                <label for="from_appointment" class="bold">From Appointment</label>
                <select name="from_appointment" class="form-control form-control-lg js-from-appointment" id="from_appointment">
                    <option value="">--Please select--</option>
                    <option value="from_appointment" >From Appointment</option>
                    <option value="walk_in" > Walk In </option>
                </select>
                <span class="js-error text-danger "></span>
            </div>

            <div class="col-lg-4 mt-3">
                <label for="sale_type" class="bold">Sale Type</label>
                <select name="sale_type" id="sale_type" class="form-control form-control-lg js-sale-type">
                    <option value="">--Please select--</option>
                    <option value="new" >New</option>
                    <option value="used" > Used </option>
                </select>
                <span class="js-error text-danger "></span>
            </div>

        </div>

        <div class="row ">
            <div class="col-12 bold mt-3">
                Sold add-on products:
            </div>
            <div class="col-lg-4 mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="sold_vehicle" id="sold_vehicle"  value="1">
                    <label class="form-check-label" for="sold_vehicle">Sold a vehicle</label>
                </div>
            </div>

            <div class="col-lg-4 mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="finance" id="finance" value="1">
                    <label class="form-check-label" for="finance">Finance</label>
                </div>
            </div>

            <div class="col-lg-4 mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="paint_protection" id="paint_protection" value="1">
                    <label class="form-check-label" for="paint_protection">Paint Protection</label>
                </div>
            </div>

            <div class="col-lg-4 mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="smart" id="smart" value="1">
                    <label class="form-check-label" for="smart">Smart</label>
                </div>
            </div>

            <div class="col-lg-4  mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="gap" id="gap" value="1">
                    <label class="form-check-label" for="gap">GAP</label>
                </div>
            </div>

            <div class="col-lg-4 mt-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="warranty" id="warranty" value="1">
                    <label class="form-check-label" for="warranty">Warranty</label>
                </div>
            </div>

        </div>


        <div class="row py-4">
            <div class="col-12 px-4">
                <div class="row alert-sister py-3">
                    <div class="col-12 bold ">
                        Part Exchange:
                    </div>

                    <div class="col-lg-4 mt-1">
                        <div class="form-check">
                            <div class="row">
                                <div class="col-2">
                                    <input class="form-check-input js-part-exchange_yes" type="radio" name="part_exchange" id="part_exchange_yes" value="1">
                                    <label class="form-check-label" for="part_exchange_yes">Yes</label>
                                </div>
                                <div class="col">
                                    <input class="form-check-input js-part-exchange_no" type="radio" name="part_exchange" id="part_exchange_no" value="0">
                                    <label class="form-check-label" for="part_exchange_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <span class="js-exchange-error col-12 text-danger"></span>
                        </div>
                    </div>

                    <span class="col-12 js-span hide">
                        <div class="row">
                            <div class="col-12 bold mt-2">
                                Enter Registration:
                            </div>
                            <div class="col-lg-4 mt-1">
                                <input   id="registration" type="text" class="form-control form-control-lg js-registration" name="registration"  value="" >
                                <span class="js-error text-danger "></span>
                            </div>
                        </div>
                    </span>

                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-lg-12">
                <a href="javascript:void(0)"class="btn btn-action sister block js-submit-sale">Submit Sale</a>
            </div>
        </div>

    </div>
</div>

<input type="hidden" id="appointment_id" value="{{$appointment->id}}">
<div class="col-lg-6 js-appointment p-0">
    <div class=" s-card-header alert-brand border-0 border-bottom p-3  relative">
        <i class="fas fa-book-reader"></i>  Update Date and Time
        <span class="pop-up-close">X</span>

    </div>
    <div class="s-card-body p-3">
        <div class="row ">
            <div class="col-lg-6 mt-3 relative">
                <label for="date" class="bold">Appointments Date <span class="text-danger">*</span></label>
                <input   id="date" type="text" class="form-control form-control-lg js-appointment-date" name="date" event-id="{{$appointment->event_id}}" date="{{$appointment->date}}" value="{{\Carbon\Carbon::parse($appointment->date)->format('d M Y')}}">
                <div class="js-appointment-dates-wraper alert-brand  shadow ">
                    @foreach($dates as $d)
                        <span
                            date-id="{{$d->id}}"
                            dealership-id="{{$d->dealership_id}}"
                            event-id="{{$d->event_id}}"
                            date="{{$d->date}}"
                            class="js-date-appointment"
                            >
                            {{\Carbon\Carbon::parse($d->date)->format('d/M/Y')}}
                        </span>
                    @endforeach
                </div>
            </div>

            {{----}}
            <div class="col-lg-6 mt-3 relative">
                <label for="time" class="bold">Appointment Time<span class="text-danger">*</span></label>
                <input id="time" type="text" class="form-control form-control-lg js-appointment-time" name="time" time-id="{{$appointment->eventTime->id}}" value="{{$appointment->eventTime->time}}" autocomplete="off">
                <div class="js-appointment-time-wraper alert-brand  shadow ">
                    @if(count($slots) > 0)
                        @foreach($slots as $slot)
                            @if(slotAppointment($slot->id))
                                <div
                                    slot-id="{{$slot->id}}"
                                    dealership-id="{{$slot->dealership_id}}"
                                    value="{{$slot->time}}"
                                    class="js-slot-appointment text-success ">
                                    <i class="fas fa-check"></i> {{$slot->time}} Booked
                                </div>
                            @else
                                <span
                                    slot-id="{{$slot->id}}"
                                    value="{{$slot->time}}"
                                    class="js-slot-appointment">
                                    {{$slot->time}}
                                </span>
                            @endif
                        @endforeach
                    @else
                        <span class="text-danger text-center bold line-height-30">Sorry! But there's no times available to the Date you've selected</span>
                    @endif

                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-12">
                <a href="javascript:void(0)"class="btn btn-action sister block js-update-date-time" appointment-id="{{$appointment->id}}">Update Date Time</a>
            </div>
        </div>

    </div>
</div>

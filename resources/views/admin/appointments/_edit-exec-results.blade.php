<label class="pl-3 bold"><i class="fas fa-user-tie"></i> Select Exec <span class="text-danger">*</span></label>

@foreach($execs as $exec)
    <div class="col-12 p-0">
        <div class="js-exec @if($exec->execSelected($time_id, $exec->id, $appointment->id)) current-exec active @endif @if(execBookedAppointment($time_id, $exec->id, $date->date))js-update-exec js-booked @endif


        " time-id="{{$time_id}}" exec-id="{{$exec->id}}" event-id="{{$event_id}}" appointment-id="{{$appointment->id}}"  dealership-id="{{$dealership->id}}" >
           {{$exec->name}}
        </div>

    </div>
@endforeach





<label class="pl-3 bold"><i class="fas fa-user-tie"></i> Select Exec <span class="text-danger">*</span></label>
@foreach($execs as $exec)
    <div class="col-12 p-0">
        <div class="@if(execAdminAppointment($time_id, $exec->id)) js-booked @else js-exec @endif" time-id="{{$time_id}}" exec-id="{{$exec->id}}" event-id="{{$event_id}}" date-id="{{$date_id}}" dealership-id="{{$dealership->id}}" >
            {{$exec->name}}
        </div>
    </div>
@endforeach

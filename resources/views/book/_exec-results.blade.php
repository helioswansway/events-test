<label class="pl-3 bold"><i class="fas fa-user-tie"></i> @if($event->show_vehicles == 1) Select Exec @else Select Vehicle @endif <span class="text-danger">*</span></label>
@foreach($execs as $exec)
    <div class="col-12 p-0">
        <div class="@if(execAdminAppointment($time_id, $exec->id)) js-booked @else js-exec @endif" time-id="{{$time_id}}" exec-id="{{$exec->id}}" event-id="{{$event->id}}" date-id="{{$date_id}}" dealership-id="{{$dealership->id}}" >
            {{$exec->name}}
        </div>
    </div>
@endforeach

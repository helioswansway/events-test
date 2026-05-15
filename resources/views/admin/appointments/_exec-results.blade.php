<label class="pl-3 bold"><i class="fas fa-user-tie"></i> Select Exec <span class="text-danger">*</span></label>
@foreach($execs->exec($time_id) as $exec)
    <div class="col-12 p-0">
        <label class="block @if(is_array(old('exec_id')) && in_array($exec->id, old('exec_id')))) active @endif @if(execAdminAppointment($time_id, $exec->id)) js-booked @else js-exec @endif" time-id="{{$time_id}}" exec-id="{{$exec->id}}" event-id="{{$event_id}}" date-id="{{$date_id}}" dealership-id="{{$dealership->id}}" >
            {{$exec->name}}
            <input type="radio" class="hide" name="exec_id" value="{{$exec->id}}"
            @if(is_array(old('exec_id')) && in_array($exec->id, old('exec_id')))) checked @endif
            >
        </label>
    </div>
@endforeach

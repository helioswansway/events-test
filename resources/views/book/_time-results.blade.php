
@if(count($slots) > 0)
    <label  class="pl-3 bold"><i class="fas fa-clock"></i> Select Time Slot <span class="text-danger">*</span></label>

    @foreach($slots as $slot)
        <div class="col-lg-3 p-1">
            <div class="js-time  @if($event->inc_exec == 0) js-no-exec @endif  " time-id="{{$slot->id}}" event-id="{{$event_id}}" date-id="{{$date_id}}" dealership-id="{{$dealership_id}}" >
                {{$slot->time}}
            </div>
        </div>
    @endforeach
@else
    <label  class="pl-3 bold"><i class="fas fa-clock"></i> Select Time Slot <span class="text-danger">*</span></label>
    <div class="text-danger bold">No times slots available for this date</div>
@endif

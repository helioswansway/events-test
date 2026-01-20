
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

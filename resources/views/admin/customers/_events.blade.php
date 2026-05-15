
{{--
    Located on /dashboard/customers/register
    It pulls the event based on the selected dealership
--}}

@if($events->count() > 0)
    @if($events->count() == 1)
    <option value="">--Select Event--</option>
    @else
        <option value="">--Select Event--</option>
    @endif

    @foreach($events as $event)
        <option value="{{$event->id}}">{{$event->name}}</option>
    @endforeach

@else
    <option value="">--Select Event--</option>
@endif


@if($events->count() > 0)
    <option value="">--Select Event--</option>
    @foreach($events as $event)
        <option value="{{$event->id}}">{{$event->name}}</option>
    @endforeach
@else
    <option value="">--Select Event--</option>
@endif

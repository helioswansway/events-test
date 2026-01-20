
@foreach($dates as $date)
    <span
        date-id="{{$date->id}}"
        dealership-id="{{$date->dealership_id}}"
        event-id="{{$date->event_id}}"
        date="{{$date->date}}"
        class="js-date-appointment"
        >
        {{\Carbon\Carbon::parse($date->date)->format('d/M/Y')}}
    </span>

@endforeach


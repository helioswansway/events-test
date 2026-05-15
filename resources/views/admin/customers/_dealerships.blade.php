
{{--
    Located on /dashboard/customers/create
    It pulls all dealerships based on the selected event
--}}

@if($dealerships->count() > 0)
    @if($dealerships->count() == 1)
        <option value="">--Select Dealership--</option>
    @else
        <option value="">--Select Dealership--</option>
    @endif

    @foreach($dealerships as $dealership)

        <option value="{{$dealership->code}}">{{$dealership->name}}</option>
    @endforeach

@endif

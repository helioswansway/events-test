<x-mail::message>
# Hello {{$customer_name}}

## Please see below the details for you registered Event
<br>
<strong>Your Registration Code:</strong> <span style="background-color: #cce5f3; border-color: #b8daee; color: #1879b1;"> &nbsp;&nbsp; {{$customer_number}} &nbsp;&nbsp;</span>
<br><br>
<strong>Event:</strong> <br> {{$dealership_event->event_name}}
<br>
<strong>Dealership:</strong> <br> {{$dealership_event->dealership_name}}

<strong>Event Dates:</strong> <br>
@foreach($event_dates as $date)
    {{$date->date}} <br>
@endforeach


<?php
    $url = config('app.url')."/book/login";
?>

<x-mail::button :url="$url"  color="success">
Register your place today
</x-mail::button>

<center>
    <a href="{{ $url }}">{{ $url }}</a>
</center>

<br> <br>

Regards,<br>
Swansway Motor Group
</x-mail::message>

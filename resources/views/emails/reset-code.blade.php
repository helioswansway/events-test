<x-mail::message>
# Hello {{$customer_name}}

Please se below your requested registration code.

<br>

<strong>Your new registration code:</strong> <span style="background-color: #cce5f3; border-color: #b8daee; color: #1879b1;"> &nbsp;&nbsp; {{$customer_number}} &nbsp;&nbsp;</span>


<?php
    $url = config('app.url')."/book/login";
?>

<x-mail::button :url="$url"  color="success">
Login
</x-mail::button>

<center>
    <a href="{{ $url }}">{{ $url }}</a>
</center>

<br> <br>

Regards,<br>
Swansway Motor Group
</x-mail::message>

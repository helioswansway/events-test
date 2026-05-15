@component('mail::message')

# Password Reset

Keep this Password save in a Password Manager. Passwords are updated every 60 days.
<br><br>
<span style="font-weight:800; color: #f36e35;">{{$value}}</span>
<br><br>
<?php $url = route('admin') ?>
@component('mail::button', ['url' => $url ])
    Login to your admin area
@endcomponent

Regards,<br>
Swansway Group

@endcomponent

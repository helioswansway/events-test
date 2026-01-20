@component('mail::message')

# Password Reset

<h2>An account have been created for you on Swansway Events System.</h2>

<strong>You need to click the on button  bellow and reset your new password.</strong>
<br><br>

<?php $url = route('admin') ?>
@component('mail::button', ['url' => $url ])
    Reset Your Password
@endcomponent

Regards,<br>
Swansway Group

@endcomponent

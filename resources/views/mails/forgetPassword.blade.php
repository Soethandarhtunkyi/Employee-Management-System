@component('mail::message')
# Passwork Reset Link

You can reset your password from bellow link.

@component('mail::button', ['url' => 'http://localhost:8000/reset-password/' . $token])
Here
@endcomponent

Thanks,<br>
Employee Management System
@endcomponent

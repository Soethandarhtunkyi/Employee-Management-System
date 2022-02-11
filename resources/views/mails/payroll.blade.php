@component('mail::message')
# Your Payroll

We have attached your payroll detail.

@component('mail::button', ['url' => 'http://localhost:8000/dashboard'])
More Info
@endcomponent

Thanks,<br>
Employee Management System
@endcomponent

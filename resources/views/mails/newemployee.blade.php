@component('mail::message')
# New Employee Information

We have attached your new employee detail.

@component('mail::table')
| Name | Role | Department |
| ------------- |:-------------:| --------:|
| {{$employee->name}} | {{$employee->role->name}} | {{$employee->department->name}} |
@endcomponent

@component('mail::button', ['url' => 'http://localhost:8000/employee/' . $employee->id])
More Info
@endcomponent

Thanks,<br>
Employee Management System
@endcomponent

@extends('layouts.app')

@section('title', 'Payroll Calculate')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payroll/calculate.css') }}">
@endsection

@section('content')
<div class="container">
  @oldcalculation($calculatedPayroll)
  <div class="alert-errmsg"><i class="fa fa-calculator mr-icon"></i>
    This payroll calculation was not calculated up to today. Please recalculate again to know up to date info.
  </div>
  @endoldcalculation
  <div class="list-card">
    <div class="listcard-header">
      Payroll Calculate
    </div>
    <div class="card-body">
      <ul>
        <li class="row clearfix">
          <p class="float-left label">Name</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->name }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Email</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->email }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Role</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->role->name }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Department</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->department->name }}</p>
        </li>
        <hr>
        <li class="row clearfix">
          <p class="float-left label">Basic Salary</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->salary->basic_salary }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Basic Leave Fine</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->salary->leave_fine }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Basic Overtime Fee</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->salary->overtime_fee }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Actual Working Days</p>
          <p class="float-right value">{{ $monthlyWorkingDays }}</p>
        </li>
        <hr>
        <li class="row clearfix">
          <p class="float-left label title">Calculated Detail</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Employee Working Days</p>
          <p class="float-right value">{{ $calculatedPayroll->employee->working_days }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Employee Working Hours</p>
          <p class="float-right value">{{ $calculatedPayroll->total_working_hours }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Employee Leave Days</p>
          <p class="float-right value">{{ $calculatedPayroll->total_leave_days }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Employee Overtimes</p>
          <p class="float-right value">{{ $calculatedPayroll->total_overtimes }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Total Leave Fines</p>
          <p class="float-right value">-{{ $calculatedPayroll->total_leave_fines }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Total Overtime Fees</p>
          <p class="float-right value">+{{ $calculatedPayroll->total_overtime_fees }}</p>
        </li>
        <li class="row clearfix">
          <p class="float-left label">Total Final Salary</p>
          <p class="float-right value">{{ $calculatedPayroll->salary }}</p>
        </li>
      </ul>
      <div class="clearfix">
        <a href="#" id="back" class="red-btn float-right align">Back</a>
        <a href="{{ route('payrolls-recalculate', [$calculatedPayroll->employee->id]) }}" class="yellow-btn float-right align">Recalculate the Payroll</a>
        <a href="{{ route('payrolls-sendPayrollMail', [$calculatedPayroll->id]) }}" class="blue-btn float-right align">Send Email to Employee</a>
      </div>
    </div>
  </div>
</div>
@endsection

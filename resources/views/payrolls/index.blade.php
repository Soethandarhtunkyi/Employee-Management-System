@extends('layouts.app')

@section('title', 'Payroll Lists')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payroll/calculate.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="list-card">
    <div class="listcard-header mr-table">
      Payroll
    </div>
    <table class="table" id="payrolls">
      <thead>
        <tr>
          <th class="header-cell" scope="col">Name</th>
          <th class="header-cell" scope="col">Email</th>
          <th class="header-cell" scope="col">Basic Salary</th>
          <th class="header-cell" scope="col">Role</th>
          <th class="header-cell" scope="col">Department</th>
          <th class="header-cell" scope="col">Working Days</th>
          <th class="header-cell" scope="col">Leave Days</th>
          <th class="header-cell" scope="col">OT Hours</th>
          <th class="header-cell" scope="col">Operation</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($employees as $employee)
        <tr class="@if ($employee == auth()->user())
          associated
        @endif">
          <td>{{ $employee->name }}</td>
          <td>{{ $employee->email }}</td>
          <td>{{ $employee->salary->basic_salary }}</td>
          <td>{{ $employee->role->name }}</td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->working_days }}</td>
          <td>{{ $employee->leave_days }}</td>
          <td>{{ $employee->overtimes }}</td>
          <td>
            <a href="{{ route('payrolls-calculate', [$employee->id]) }}" class="blue-btn sm-btn cal-btn">Calculate</a>
            <a href="{{ route('payroll-showEditView', [$employee->id]) }}" class="yellow-btn sm-btn payroll-btn">Edit Payroll</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/payrolls/index.js') }}"></script>
@endsection

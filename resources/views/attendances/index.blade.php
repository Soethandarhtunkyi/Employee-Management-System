@extends('layouts.app')

@section('title', 'Attendance Lists')
@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance/attendance.css') }}">
<link rel="stylesheet" href="{{ asset('css/library/daterangepicker.min.css') }}">
@endsection
@section('content')
@if ($status = Session::get(\Carbon\Carbon::today()->format('m-d')))
@endif
<div class="container">
  <div class="clearfix">
    @if ($status == config('constants.Checkedout'))
    <div class="success-msg w-50 mx-auto"><i class="fa fa-calendar-check mr-icon"></i>
      You already have submitted record for today or taken leave.
    </div>
    @else
    <div class="card-submit w-50 mx-auto float-left">
      <div class="cardheader-submit clearfix">
        Attendance Submit Form
        <span class="txt-date">{{ now()->format('d-m-Y') }}</span>
      </div>
      <div class="card-body clearfix">
        <form action="{{ route('attendances-store') }}" method="POST">
          {{ csrf_field() }}
          @if ($status == config('constants.Checkedin'))
          <div class="card-text">Please check out before shutting down your pc.</div>
          @else
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="wfh" value="0">
            <label class="form-check-label" for="wfh">WFH</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="type" id="office" value="1">
            <label class="form-check-label" for="office">Office</label>
          </div>
          <div class="form-check form-check-inline float-end">
            <input class="form-check-input" type="checkbox" id="leave" name="leave" value="1">
            <label class="form-check-label" for="leave">Leave</label>
          </div>
          @endif
          @if ($status == config('constants.Checkedin'))
          <a href="{{ route('attendances-update') }}" class="blue-btn checkout-btn">
            <i class="fa fa-user-check mr-icon"></i>Check Out
          </a>
          @else
          <button type="submit" class="blue-btn checkin-btn">
            <i class="fa fa-user-check mr-icon"></i>Check In
          </button>
          @endif
        </form>
      </div>
    </div>
    @endif
    <div class="card-submit float-right">
      <div class="cardheader-submit clearfix">
        Custom Leave
        <span class="txt-date">{{ now()->format('d-m-Y') }}</span>
      </div>
      <div class="card-body">
        <form action="{{ route('attendances-customLeave') }}" method="POST" id="custom-leave">
          {{ csrf_field() }}
          <input type="date" name="start_date" hidden id="start">
          <input type="date" name="end_date" hidden id="end">
          <div class="row">
            <label for="dates">Leave Duration</label>
            <input type="text" id="dates" class="dates">
          </div>
          <button type="submit" class="blue-btn checkin-btn">
            <i class="fa fa-calendar-times mr-icon"></i>Submit
          </button>
        </form>
      </div>
    </div>
  </div>
  <div class="list-card">
    <div class="listcard-header mr-table">
      Attendance Lists
    </div>
    <table class="table table-hover" id="attendances">
      <thead>
        <tr>
          <th class="header-cell" scope="col">#</th>
          <th class="header-cell" scope="col">Name</th>
          <th class="header-cell" scope="col">Role</th>
          <th class="header-cell" scope="col">Department</th>
          <th class="header-cell" scope="col">Attendance</th>
          <th class="header-cell" scope="col">Type</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($attendances as $attendance)
        <tr class="@if ($attendance->employee_id == auth()->id())
          associated
        @endif">
          <td>{{ $loop->iteration }}</td>
          <td>{{ $attendance->employee->name }}</td>
          <td>{{ $attendance->employee->role->name }}</td>
          <td>{{ $attendance->employee->department->name }}</td>
          <td>{{ $attendance->status }}</td>
          <td>{{ $attendance->type_name }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\CustomLeaveRequest', '#custom-leave'); !!}
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('js/library/jquery.heightLine.js') }}"></script>
<script src="{{ asset('js/attendances/index.js') }}"></script>
<script src="{{ asset('js/library/moment.min.js') }}"></script>
<script src="{{ asset('js/library/daterangepicker.min.js') }}"></script>
@endsection

@extends('layouts.app')

@section('title', 'Employees List')

@section('css')
<link rel="stylesheet" href="{{ asset('css/employee/employeelist.css') }}">
@endsection
@section('content')
<div class="container">
  <div class="list-card">
    <div class="listcard-header">
      Employee Lists
    </div>
    <div class="clearfix">
      <form action="{{ route('employee-showLists') }}" method="GET" class="searchForm">
        <div class="input-group my-5">
          <input type="text" class="rounded-input" placeholder="Name" name="name" value="{{ request()->name ?? request()->name }}">
          <input type="date" placeholder="From" name="start_date" value="{{ request()->start_date ?? request()->start_date }}">
          <input type="date" placeholder="To" name="end_date" value="{{ request()->end_date ?? request()->end_date }}">
          <button class="search-btn" type="submit">Search</button>
        </div>
      </form>
      @can('isManager')
      <div class="operation">
        <a href="{{ route('employees-upload') }}" class="import-btn">Import Data</a>
        <a href="{{ route('employees-download') }}" class="export-btn">Export Data</a>
        <a href="{{ route('employees-create') }}"><i class="fas fa-user-plus mr-icon"></i></a>
      </div>
      @endcan
    </div>
    <div class="card-body">
      <table class="table table-striped task-table">
        <thead>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Role</th>
          <th>Department</th>
          <th>Join date</th>
          <th>Action</th>
        </thead>
        <tbody>
          @if ($employees->count() > 0)
            @foreach ($employees as $employee)
            <tr class="@if ($employee->id == auth()->id())
              associated
            @endif">
              <td>{{ $employee->name }}</td>
              <td>{{ $employee->email }}</td>
              <td>{{ $employee->phone }}</td>
              <td>{{ $employee->role }}</td>
              <td>{{ $employee->department }}</td>
              <td>{{ \Carbon\Carbon::parse ($employee->created_at)->format(config('constants.Date_Format')) }}</td>
              <td>
                <a href="{{ route('employees-show', [$employee->id]) }}" class="blue-btn sm-btn">Show</a>
                @can('update-employee', $employee->id)
                <a href="{{ route('employees-edit', [$employee->id]) }}" class="yellow-btn sm-btn">Edit</a>
                @endcan
                @can('isManager')
                <a href="#" class="delete-btn red-btn sm-btn" data-id="{{ $employee->id }}">Delete</a>
                <form action="{{ route('employees-delete', [$employee->id]) }}" method="POST" id="del-form{{ $employee->id }}">
                  @csrf
                  @method('DELETE')
                </form>
                @endcan
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td valign="top" colspan="7" class="dataTables_empty">No data available in table</td>
            </tr>
          @endif
        </tbody>
      </table>
      {!! $employees->withQueryString()->links() !!}
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/employee/index.js') }}"></script>
@endsection

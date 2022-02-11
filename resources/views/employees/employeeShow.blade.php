@extends('layouts.app')

@section('title', 'Employee Profile')

@section('css')
<link rel="stylesheet" href="{{ asset('css/employee/employeecrud.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="cardcreate">
    <div class="listcard-header">
      {{ $employee->name }}'s Information
    </div>
    <div class="card-body">
      <img class="profile-pic" src="{{ \Illuminate\Support\Facades\Storage::exists('public/employees/' . $employee->profile) ?
        asset(config('path.profile_path') . $employee->profile) : 
        'https://ui-avatars.com/api/?name='.$employee->name}}" alt="Profile" />
      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Name</label>
        </div>
        <div class="float-left input">
          <input type="text" class="form-control" value="{{ $employee->name }}" readonly>
        </div>
      </div>
      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Email Address</label>
        </div>
        <div class="float-left input">
          <input type="text" class="form-control" value="{{ $employee->email }}" readonly>
        </div>
      </div>
      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Phone</label>
        </div>
        <div class="float-left input">
          <input type="text" class="form-control" value="{{ $employee->phone }}" readonly>
        </div>
      </div>
      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Role</label>
        </div>
        <div class="float-left input">
          <input type="text" class="form-control" value="{{ $employee->role->name }}" readonly>
        </div>
      </div>
      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Department</label>
        </div>
        <div class="float-left input">
          <input type="text" class="form-control" value="{{ $employee->department->name }}" readonly>
        </div>
      </div>
      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Address</label>
        </div>
        <div class="float-left input">
          <input type="text" class="form-control" value="{{ $employee->address }}" readonly>
        </div>
      </div>
      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Join Date</label>
        </div>
        <div class="float-left input">
          <input type="text" class="form-control" value="{{ $employee->created_at }}" readonly>
        </div>
      </div>
      <div class="btn-group">
        @can('update-employee', $employee->id)
        <a href="{{ route('employees-edit', [$employee->id]) }}" class="yellow-btn">Edit Profile</a>
        @endcan
        <a href="#" id="back" class="blue-btn">Back</a>
      </div>
    </div>
  </div>
</div>
@endsection

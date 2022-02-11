@extends('layouts.app')

@section('title', 'Employee Edit')

@section('css')
<link rel="stylesheet" href="{{ asset('css/employee/employeecrud.css') }}">
@endsection

@section('content')
<div class="cardcreate">
  <div class="listcard-header">
    Edit Employee Information
  </div>
  <div class="card-body">
    <img class="profile-pic" src="{{ \Illuminate\Support\Facades\Storage::exists('public/employees/' . $employee->profile) ?
      asset(config('path.profile_path') . $employee->profile) : 
      'https://ui-avatars.com/api/?name='.$employee->name}}" id="preview-profile" alt="Profile" />
    <form action="{{ route('employees-update',$employee->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <div class="row clearfix">
        <div class="float-left text">
          <label for="profile">Profile Picture</label>
        </div>
        <div class="float-left input">
          <input type="file" name="profile" class="btn-filechoose" id="profile">
        </div>
      </div>

      <div class="row clearfix">
        <div class="float-left text">
          <label for="name">Name</label>
        </div>
        <div class="float-left input">
          <input type="text" name="name" class="form-control" value="{{ $employee->name }}" placeholder="Enter employee name">
        </div>
      </div>

      <div class="row clearfix">
        <div class="float-left text">
          <label for="email">Email address</label>
        </div>
        <div class="float-left input">
          <input type="email" name="email" class="form-control" value="{{ $employee->email }}" placeholder="Enter employee email">
        </div>
      </div>

      <div class="row clearfix">
        <div class="float-left text">
          <label for="phone">Phone</label>
        </div>
        <div class="float-left input">
          <input type="tel" name="phone" class="form-control" value="{{ $employee->phone }}" placeholder="Enter phone number">
        </div>
      </div>

      <div class="row clearfix">
        <div class="float-left text">
          <label for="role">Role</label>
        </div>
        <div class="float-left input">
          <select name="role_id" class="form-select valid">
            @foreach ($roles as $item)
            @if($employee->role_id == $item->id)
            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
            @else
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endif
            @endforeach
          </select>
        </div>
      </div>

      <div class="row clearfix">
        <div class="float-left text">
          <label for="department">Department</label>
        </div>
        <div class="float-left input">
          <select name="department_id" class="form-select valid">
            @foreach ($departments as $item)
            @if($employee->department_id == $item->id)
            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
            @else
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endif
            @endforeach
          </select>
        </div>
      </div>

      <div class="row clearfix">
        <div class="float-left text">
          <label for="address">Address</label>
        </div>
        <div class="float-left input">
          <textarea name="address" class="form-control" rows="5" placeholder="Enter address">{{ $employee->address }}
          </textarea>
        </div>
      </div>

      <div class="btn-group">
        <input type="submit" value="Update" class="blue-btn">
        <a href="#" id="back" class="red-btn">Cancel</a>
      </div>
    </form>
  </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\EditEmployeeRequest'); !!}
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('js/employee/create.js') }}"></script>
@endsection

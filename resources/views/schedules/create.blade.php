@extends('layouts.app')

@section('title', 'Schedule Create')

@section('css')
<link rel="stylesheet" href="{{ asset('css/project/create.css') }}">
<link rel="stylesheet" href="{{ asset('css/schedule/create.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="listcard-header">Schedule Create</div>
  <div class="box">
    <form action="{{ route('projects-storeSchedule', [$project->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-25">
          <label for="pname">Task Name</label>
        </div>
        <div class="col-75">
          <input type="text" class="form-control" name="name" placeholder="Enter task name">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="github">Description</label>
        </div>
        <div class="col-75">
          <textarea name="description" class="form-control" rows="5" placeholder="Enter task description"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="pname">Start Date</label>
        </div>
        <div class="col-75">
          <input type="date" class="form-control" name="start_date">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="member">End Date</label>
        </div>
        <div class="col-75">
          <input type="date" class="form-control" name="end_date">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="member">Assignee</label>
        </div>
        <div class="col-75">
          <select name="assignee_id" class="form-control">
            @foreach ($project->employees as $employee)
            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="member">Documents</label>
        </div>
        <input type="file" name="file" class="btn-choose">
      </div>
      <div class="row">
        <div class="col-25"></div>
        <div class="col-75">
          <input type="submit" class="blue-btn" value="Create">
          <a href="javascript:void(0)" id="back" class="red-btn">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\StoreScheduleRequest'); !!}
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@endsection

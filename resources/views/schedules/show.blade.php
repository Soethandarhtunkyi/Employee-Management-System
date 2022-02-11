@extends('layouts.app')

@section('title', 'Schedule Detail')

@section('css')
<link rel="stylesheet" href="{{ asset('css/project/create.css') }}">
<link rel="stylesheet" href="{{ asset('css/project/detail.css') }}">
@endsection

@section('content')
<div class="listcard-header half">Schedule Detail</div>
<div class="box">
  <div class="row">
    <div class="col-25">
      <label for="pname">Schedule Name</label>
    </div>
    <div class="col-75">
      <input type="text" value="{{ $schedule->name }}" readonly>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="github">Schedule Description</label>
    </div>
    <div class="col-75">
    <textarea rows="5" class="form-control">{{ $schedule->description }}</textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="member">Document</label>
    </div>
    <div class="col-75">
      <a href="{{ route('projects-downloadFile', [$schedule->id]) }}" class="btn-download">Download<i class="fas fa-download icon-download"></i></a>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="member">Start Date</label>
    </div>
    <div class="col-75">
      <input type="text" value="{{ \Carbon\Carbon::parse($schedule->start_date )->toDateString() }}" readonly>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="member">End Date</label>
    </div>
    <div class="col-75">
      <input type="text" value="{{ \Carbon\Carbon::parse($schedule->end_date )->toDateString() }}" readonly>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="member">Status</label>
    </div>
    <div class="col-75">
      <input type="text" value="{{ $schedule->status_text }}" readonly>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="member">Assignor</label>
    </div>
    <div class="col-75">
      <input type="text" readonly value="{{ $schedule->assignor_id == auth()->id() ? 'Me' : $schedule->assignor->name}}">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="member">Assignee</label>
    </div>
    <div class="col-75">
      <input type="text" readonly value="{{ $schedule->assignee_id == auth()->id() ? 'Me' : $schedule->assignee->name}}">
    </div>
  </div>
  <div class="row clearfix">
    <div class="col-25">
    </div>
    <div class="col-75 btn-group">
      @if ($schedule->status == config('constants.Not_Started'))
      <a href="{{ route('projects-updateStatus', [$schedule->id]) }}" class="blue-btn">Mark as Progress</a>
      @elseif ($schedule->status == config('constants.Progress'))
      <a href="{{ route('projects-updateStatus', [$schedule->id]) }}" class="blue-btn">Mark as Finished</a>
      @endif
      <a href="#" id="back" class="red-btn">Back</a>
    </div>
  </div>
</div>
@endsection

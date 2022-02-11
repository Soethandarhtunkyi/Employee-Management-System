@extends('layouts.app')

@section('title', 'Project Detail')

@section('css')
<link rel="stylesheet" href="{{ asset('css/project/create.css') }}">
<link rel="stylesheet" href="{{ asset('css/project/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/project/index.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="listcard-header half">Project Detail</div>
  <div class="box">
    <div class="row">
      <div class="col-25">
        <label for="pname">Project Name</label>
      </div>
      <div class="col-75">
        <input type="hidden" id="prj-id" value="{{ $project->id }}">
        <input type="text" id="name" value="{{ $project->name }}" readonly>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="github">Github Link</label>
      </div>
      <div class="col-75">
        <a class="git-link" href="{{ $project->link }}" target="_blank">
          <input type="text" id="link" value="{{ $project->link }}" readonly>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="member">Manager Name</label>
      </div>
      <div class="col-75">
        <input type="text" id="link" value="{{ $project->manager->name }}" readonly>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="member">Pending Tasks</label>
      </div>
      <div class="col-75">
        <input type="text" id="link" value="{{ $project->pending_tasks }}" readonly>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="member">Started From</label>
      </div>
      <div class="col-75">
        <input type="text" id="link" value="{{ $project->created_at->diffForHumans() }}" readonly>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="member">Members</label>
      </div>
      <div class="col-75">
        @foreach ($project->employees as $employee)
        <input class="group" type="text" id="link" value="{{ $employee->name }}" readonly>
        <a href="{{ route('employees-show', [$employee->id]) }}" class="yellow-btn sm-btn">
          <span class="fas fa-eye"></span>
        </a>
        @endforeach
      </div>
    </div>
    <div class="btn-group">
      <a href="#" id="back" class="red-btn">Back</a>
    </div>
  </div>
</div>
@can('view-tasks', $project)
@include('projects.sub-views.tasklists')
@endcan
@endsection

@section('script')
<script src="{{ asset('js/schedules/index.js') }}"></script>
@endsection

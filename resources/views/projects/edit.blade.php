@extends('layouts.app')

@section('title', 'Project Edit')

@section('css')
<link rel="stylesheet" href="{{ asset('css/project/create.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="listcard-header">Project Edit</div>
  <div class="box">
    <form action="{{ route('projects-updateProject', [$project->id]) }}" method="POST">
      @csrf
      @method('PATCH')
      <div class="row">
        <div class="col-25">
          <label for="pname">Project Name</label>
        </div>
        <div class="col-75">
          <input type="hidden" id="prj-id" value="{{ $project->id }}">
          <input type="text" id="name" name="name" value="{{ $project->name }}" placeholder="Enter project">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="github">Github Link</label>
        </div>
        <div class="col-75">
          <input type="text" id="link" name="link" value="{{ $project->link }}" placeholder="Enter Github Link">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="member">Existing Members</label>
        </div>
        <div class="col-75">
          <table class="table" id="members">
            <thead>
              <th>Name</th>
              <th>Action</th>
            </thead>
            <tbody id="tmembers">
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="member">Add new Members</label>
        </div>
        <div class="col-75">
          <table class="table" id="non-members">
            <thead>
              <th>Name</th>
              <th>Action</th>
            </thead>
            <tbody id="tnon-members">
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label></label>
        </div>
        <div class="col-75">
          <input type="submit" value="Update" class="blue-btn">
          <a href="javascript:void(0)" id="back" class="red-btn">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\UpdateProjectRequest'); !!}
@endsection

@section('script')
<script src="{{ asset('js/projects/edit.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@endsection

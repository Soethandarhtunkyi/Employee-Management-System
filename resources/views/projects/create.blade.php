@extends('layouts.app')

@section('title', 'Project Create')

@section('css')
<link rel="stylesheet" href="{{ asset('css/project/create.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="listcard-header">Project Create</div>
  <div class="box">
    <form action="javascript:void(0)">
      @csrf
      <div class="row">
        <div class="col-25">
          <label for="pname">Project Name</label>
        </div>
        <div class="col-75">
          <input type="text" id="name" name="name" placeholder="Enter project">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="github">Github Link</label>
        </div>
        <div class="col-75">
          <input type="text" id="link" name="link" placeholder="Enter Github Link">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="member">Members</label>
        </div>
        <div class="col-75">
          <table class="table" id="employees">
            <thead>
              <th>Name</th>
              <th>Action</th>
            </thead>
            <tbody>
              @foreach ($employees as $key => $value)
              <tr>
                <td>{{ $value }}</td>
                <td><a href="javascript:void(0)" data-id="{{ $key }}" class="button-4 sync">Add</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label></label>
        </div>
        <div class="col-75">
          <a href="javascript:void(0)" id="submit-post" class="blue-btn">Create</a>
          <a href="javascript:void(0)" id="back" class="red-btn">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/projects/create.js') }}"></script>
@endsection

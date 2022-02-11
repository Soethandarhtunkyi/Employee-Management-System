@extends('layouts.app')

@section('title', 'Project Lists')

@section('css')
<link rel="stylesheet" href="{{ asset('css/project/index.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="list-card">
    <div class="listcard-header mr-table clearfix">
      Projects
      @can('isManager')
      <a href="{{ route('projects-showCreateView') }}" class="my-button float-right"><i class="fas fa-plus mr-icon"></i></a>
      @endcan
    </div>
    <table class="table" id="projects">
      <thead>
        <tr>
          <th class="header-cell" scope="col">Name</th>
          <th class="header-cell" scope="col">Project Repo</th>
          <th class="header-cell" scope="col">Manager Name</th>
          <th class="header-cell" scope="col">Members</th>
          <th class="header-cell" scope="col">Pending Tasks</th>
          <th class="header-cell" scope="col">Operation</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($projects as $project)
        <tr class="@if ($project->manager_id == auth()->id() || $project->employees->contains(auth()->id()))
          associated
        @endif">
          <td>{{ $project->name }}</td>
          <td><a href="{{ $project->link }}" target="_blank">{{ $project->link }}</a></td>
          <td>{{ $project->manager->name }}</td>
          <td>{{ $project->employees_count }}</td>
          <td>{{ $project->pending_tasks }}</td>
          <td>
            <a href="{{ route('projects-showDetail', [$project->id]) }}" class="blue-btn sm-btn">Detail</a>
            @can('own', $project->manager_id)
            <a href="{{ route('projects-showEditView', [$project->id]) }}" class="yellow-btn sm-btn">Edit</a>
            <a href="javascript:void(0)" class="red-btn sm-btn del-btn" data-id="{{ $project->id }}">Delete</a>
            @endcan
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/projects/index.js') }}"></script>
@endsection

@extends('layouts.app')

@section('title', 'Upload CSV')

@section('css')
<link rel="stylesheet" href="{{ asset('css/employee/employeeupload.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="card-upload">
    <div class="cardheader-upload">Upload Employee Lists</div>
    <form action="{{ route('employees-submit') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <div class="custom-file">
          <input type="file" name="file" class="btn-filechoose" accept=".csv, .xlsx">
        </div>
      </div>
      <div class="btn-group">
        <button class="btn-import">Import data</button>
        <a href="#" id="back" class="red-btn">Cancel</a>
      </div>
    </form>
  </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\ImportEmployeesRequest'); !!}
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard/graph.css') }}">
@endsection

@section('content')
<div class="container clearfix">
  <p class="ttl-dashboard">Dashboard Overview</p>
  <p class="show-date">Date:
    <?php echo (strftime("%d/%m/%Y")); ?>
  </p>

  <div>
    @foreach($totalemployee as $totalemployees)
    <div class="dashboard-card mr-space clearfix">
      <div class="card-col">
        <p class="count-data font-empall" id="value" data-count="{{ $totalemployees->count }}"></p>
        <p class="ttl-card">TOTAL EMPLOYEES</p>
        <a href="http://127.0.0.1:8000/employees/lists">
          <p class="subttl-card">DETAILS</p>
        </a>
      </div>
      <i class="fas fa-users card-icon icon-empall"></i>
    </div>
    @endforeach
    @foreach($newemployee as $newemployees)
    <div class="dashboard-card mr-space clearfix">
      <div class="card-col">
        <p class="count-data font-newemp" id="newem-value" data-count="{{$newemployees->count}}"></p>
        <p class="ttl-card">NEW EMPLOYEES</p>
        <p class="subttl-card">PER MONTH</p>
      </div>
      <i class="fas fa-user-plus card-icon icon-newemp"></i>
    </div>
    @endforeach
    @foreach($employeeleave as $employeeleaves)
    <div class="dashboard-card mr-space clearfix">
      <div class="card-col">
        <p class="count-data font-turnover" id="turnover-value" data-count="{{$employeeleaves->count}}"></p>
        <p class="ttl-card">EMPLOYEES TURNOVER</p>
        <p class="subttl-card">PER MONTH</p>
      </div>
      <i class="fas fa-user-minus card-icon icon-turnover"></i>
    </div>
    @endforeach
    @foreach($officeemployee as $officeemployees)
    <div class="dashboard-card clearfix">
      <div class="card-col">
        <p class="count-data font-office" id="office-value" data-count="{{$officeemployees->count}}"></p>
        <p class="ttl-card">AT OFFICE EMPLOYEES</p>
        <p class="subttl-card">PER DAY</p>
      </div>
      <i class="fas fa-building card-icon icon-office"></i>
    </div>
    @endforeach
  </div>
  <div class="clearfix">
    <div class="card">
      <div class="card-header">
        <i class="fas fa-user-check icon-margin"></i>
        Present Employee
      </div>
      <div class="card-body"><canvas id="pie-chart"></canvas></div>
    </div>

    <div class="card">
      <div class="card-header">
        <i class="fas fa-user-times icon-margin"></i>
        Absent Employee
      </div>
      <div class="card-body"><canvas id="bar-chart"></canvas></div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/graph/library/chart-js.js') }}"></script>
<script src="{{ asset('js/graph/library/jquery.js') }}"></script>
<script src="{{ asset('js/graph/graph.js') }}"></script>
<script>
  chartdata = '<?php echo $chart_data; ?>';
</script>
<script>
  barchartdata = '<?php echo $barchart_data; ?>';
</script>
@endsection
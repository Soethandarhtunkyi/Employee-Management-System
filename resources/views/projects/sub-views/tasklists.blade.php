<div class="list-card">
  <div class="listcard-header schedules clearfix">
    Schedules
    @can('create-task', $project)
    <a href="{{ route('projects-scheduleCreateView', [$project->id]) }}" class="my-button float-right"><i class="fas fa-plus"></i></a>
    @endcan
  </div>
  <table class="table" id="schedules">
    <thead>
      <tr>
        <th class="header-cell" scope="col">Name</th>
        <th class="header-cell" scope="col">Deadline Date</th>
        <th class="header-cell" scope="col">Status</th>
        <th class="header-cell" scope="col">Assignor</th>
        <th class="header-cell" scope="col">Assignee</th>
        <th class="header-cell" scope="col">Operation</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($schedules as $schedule)
      <tr class="@if ($schedule->assignee_id == auth()->id() || $schedule->assignor_id == auth()->id())
        associated
      @endif">
        <td>{{ $schedule->name }}</td>
        <td>{{ \Carbon\Carbon::parse($schedule->end_date )->format(config('constants.Date_Format')) }}</td>
        <td>{{ $schedule->status_text }}</td>
        <td>{{ $schedule->assignor->name }}</td>
        <td>{{ $schedule->assignee->name }}</td>
        <td>
          @can('view-task', $schedule)
          <a href="{{ route('projects-showSchedule', [$schedule->id]) }}" class="blue-btn sm-btn">Detail</a>
          @endcan
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@if ($message = Session::get('success'))
  <div class="success-msg">{{$message}}</div>
@endif

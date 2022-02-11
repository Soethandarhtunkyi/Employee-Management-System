@if (count($errors) > 0)
  <!-- Form Error List -->
  <div class="alert-errmsg">
    <strong>Whoops! Something went wrong!</strong>
    <br><br>
    <ul>
      @foreach ($errors->all() as $error)
        <li class="errline-msg">{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
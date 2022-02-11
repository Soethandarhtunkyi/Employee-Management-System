@extends('layouts.design')

@section('title', 'Forget Password')

@section('content')
<form action="{{ route('forget-password-post') }}" method="POST" class="login-form">
  @csrf
  @include('common.errors')
  <h1 class="login-header">Reset Password</h1>
  <div>
    <input type="text" id="email_address" class="form-control @error('email') is-invalid @enderror" name="email" autofocus value="{{ old('email') }}" placeholder="Email">
    @if ($errors->has('email'))
    <span class="error-msg">{{ $errors->first('email') }}</span>
    @endif
  </div>
  <button type="submit" class="btn btn-primary">
    Send Reset Link
  </button>
  <div class="formFooter">
    <a href="/login" id="back" class="underlineHover">Back to Log in</a>
  </div>
</form>
{!! JsValidator::formRequest('App\Http\Requests\ForgetPasswordRequest'); !!}
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@endsection

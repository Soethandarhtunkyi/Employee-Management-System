@extends('layouts.design')

@section('title', 'Reset Password')

@section('content')
<form action="{{ route('reset-password-post') }}" method="POST" class="login-form">
  @csrf
  @include('common.errors')
  <h1 class="login-header">Reset Password</h1>
  <input type="hidden" name="token" value="{{ $token }}">

  <div>
    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" autofocus value="{{ old('email') }}" placeholder="Email">
    @if ($errors->has('email'))
    <span class="error-msg">{{ $errors->first('email') }}</span>
    @endif
  </div>
  <div>
    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autofocus placeholder="Password">
    @if ($errors->has('password'))
    <span class="error-msg">{{ $errors->first('password') }}</span>
    @endif
  </div>
  <div>
    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autofocus placeholder="Confirm Password">
    @if ($errors->has('password_confirmation'))
    <span class="error-msg">{{ $errors->first('password_confirmation') }}</span>
    @endif
  </div>
  <button type="submit">
    Reset Password
  </button>
</form>
{!! JsValidator::formRequest('App\Http\Requests\PasswordResetRequest'); !!}
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@endsection


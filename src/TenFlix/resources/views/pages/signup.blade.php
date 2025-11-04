@extends('layouts.base')

@section('title','Sign up to ...')

@push('styles')
  <link rel="stylesheet" href="/css/style.css" />
@endpush

@section('body')
  <div class="login">
    <div class="login-header"><h1>Register</h1></div>
    <form id="loginForm">
      <div class="form-group-1">
        <input type="text" id="firstName" placeholder="First Name" required />
      </div>
      <div class="form-group-2">
        <input type="text" id="lastName" placeholder="Last Name" />
      </div>
      <div class="form-group">
        <input type="email" id="email" placeholder="E-mail" required />
      </div>
      <button type="submit" class="submit-btn">Next Step</button>
    </form>

    <div class="signup-link">
      Already have an account? <a href="/login.html">Sign in</a>
    </div>
  </div>
@endsection

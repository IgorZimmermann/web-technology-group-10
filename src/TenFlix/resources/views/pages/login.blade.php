@extends('layouts.base')

@section('title','Login page')

@push('styles')
  <link rel="stylesheet" href="/css/style.css">
@endpush

@section('body')
  <div class="login">
    <div class="login-header">
      <h1>Login</h1>
    </div>

    <form id="loginForm">
      <div class="form-group">
        <input type="text" id="username" placeholder="Username or email" required>
      </div>

      <div class="form-group">
        <input type="password" id="password" placeholder="Password" required>
      </div>

      <button type="submit" class="submit-btn">Submit</button>
    </form>

    <div class="signup-link">
      Don't have an account? <a href="/signup.html">Sign up</a>
    </div>
  </div>
@endsection

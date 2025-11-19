@extends('layouts.base')

@section('title', 'Login page')

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
@endpush

@if (session('success'))
    <div style="background: green; color: white; padding: 10px;">
        {{ session('success') }}{{--  todo: better styling for exception --}}
    </div>
@endif

@section('body')
    <div class="login">
        <div class="login-header">
            <h1>Login</h1>
        </div>

        <form id="loginForm" method="POST" action="/login">
            @csrf
            <div class="form-group">
                <input type="text" name="email" id="username" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name = "password" id="password" placeholder="Password" required>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="/signup.html">Sign up</a>
        </div>
    </div>
@endsection

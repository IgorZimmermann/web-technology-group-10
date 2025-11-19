@extends('layouts.base')

@section('title', 'Sign up to ...')

@push('styles')
    <link rel="stylesheet" href="/css/style.css" />
@endpush

@if ($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('body')
    <div class="login">
        <div class="login-header">
            <h1>Register</h1>
        </div>
        <form id="loginForm" method="POST" action="/signup">
            @csrf
            <div class="form-group-1">
                <input type="text" name="firstName" id="firstName" placeholder="First Name" required />
            </div>
            <div class="form-group-2">
                <input type="text" name="lastName" id="lastName" placeholder="Last Name" />
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="E-mail" required />
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required />
            </div>
            <button type="submit" class="submit-btn">Next Step</button>
        </form>

        <div class="signup-link">
            Already have an account? <a href="/login.html">Sign in</a>
        </div>
    </div>
@endsection

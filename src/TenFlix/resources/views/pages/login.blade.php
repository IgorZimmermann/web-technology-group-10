@extends('layouts.base')

@section('title', 'Login page')

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
@endpush



@section('body')
    <div class="login">
        <div class="login-header">
            <h1>Login</h1>
        </div>
        @if (session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
            Don't have an account? <a href="/signup">Sign up</a>
        </div>
    </div>
@endsection

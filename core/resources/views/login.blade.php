@extends('layouts.master')

@section('page-title', 'Sign In')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo"><img src="https://larapress.org/salam/assets/img/logo.png" width="48px"/></div>
        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Sign in to your Salam account</p>

        @if ($errors->any())
            <div class="alert-pro danger">
                <span>⚠</span>
                <ul style="margin:0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="alert-pro {{ session('type') === 'danger' ? 'danger' : 'success' }}">
                <span>{{ session('type') === 'danger' ? '⚠' : '✓' }}</span>
                {{ session('message') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-pro success"><span>✓</span> {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-pro danger"><span>⚠</span> {{ session('error') }}</div>
        @endif

        <form action="{{ url('/login') }}" method="post">
            @csrf

            <div class="form-group">
                <label class="form-label required">Email address</label>
                <input type="email" name="email" class="form-control-pro" placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label class="form-label" style="margin: 0;" for="password">Password</label>
                    <a href="{{ url('/forgot-password') }}" class="auth-link" style="font-size: 12.5px;">Forgot password?</a>
                </div>
                <input type="password" name="password" id="password" class="form-control-pro" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label class="check-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Keep me signed in</span>
                </label>
            </div>

            <button type="submit" class="btn-pro btn-primary-pro" style="width: 100%; justify-content: center; padding: 11px;">
                Sign In
            </button>
        </form>

        <div class="auth-divider">Don't have an account? <a href="{{ url('/register') }}" class="auth-link">Create one</a></div>
    </div>
</div>
@endsection
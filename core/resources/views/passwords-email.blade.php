@extends('layouts.master')

@section('page-title', 'Reset Password')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">🔑</div>
        <h1 class="auth-title">Forgot your password?</h1>
        <p class="auth-sub">Enter your email and we'll send a reset link</p>

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
        

        <form action="{{ url('/forgot-password') }}" method="post">
            @csrf

            <div class="form-group">
                <label class="form-label required" for="email">Email Address</label>
                <input id="email" type="email" name="email" class="form-control-pro"
                       placeholder="you@example.com" required autofocus>
            </div>

            <button type="submit" class="btn-pro btn-primary-pro" style="width: 100%; justify-content: center; padding: 11px;">
                Send Reset Link
            </button>
        </form>

        <div class="auth-divider">Remember your password? <a href="{{ url('/login') }}" class="auth-link">Sign in</a></div>
    </div>
</div>
@endsection

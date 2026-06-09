@extends('layouts.master')

@section('page-title', 'Verify Email')

@section('content')
<div class="auth-wrap">
    <div class="auth-card" style="text-align: center;">
        <div style="font-size: 48px; margin-bottom: 18px;">✉️</div>
        <h1 class="auth-title">Check your inbox</h1>
        <p class="auth-sub">
            Before continuing, please check your email for a verification link.
        </p>

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

        @if (session('success'))
            <div class="alert-pro success" style="text-align: left;">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        <p style="font-size: 13.5px; color: var(--muted); margin-top: 10px;">
            Didn't receive the email?
            <a href="{{ route('resend') }}" class="auth-link">Send again</a>
        </p>
    </div>
</div>
@endsection

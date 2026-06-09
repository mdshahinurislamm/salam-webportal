@extends('layouts.master')

@section('page-title', 'Create Account')

@section('content')
<div class="auth-wrap">
    <div class="auth-card" style="max-width: 480px;">
        <div class="auth-logo">☪</div>
        <h1 class="auth-title">Create your account</h1>
        <p class="auth-sub">Join Salam — fill in your details below</p>

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

        <form action="{{ url('/register') }}" method="post">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required" for="first_name">First Name</label>
                    <input id="first_name" type="text"
                           name="first_name"
                           class="form-control-pro @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name') }}"
                           placeholder="Ahmad"
                           required autocomplete="given-name" autofocus>
                    @error('first_name')
                        <div class="form-hint" style="color: var(--danger);">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="last_name">Last Name</label>
                    <input id="last_name" type="text"
                           name="last_name"
                           class="form-control-pro"
                           value="{{ old('last_name') }}"
                           placeholder="Hassan"
                           autocomplete="family-name">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required" for="email">Email Address</label>
                <input id="email" type="email"
                       name="email"
                       class="form-control-pro"
                       value="{{ old('email') }}"
                       placeholder="you@example.com"
                       required autocomplete="email">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="age">Age Group</label>
                    <select id="age" name="age" class="form-control-pro">
                        <option value="group_a" {{ old('age') === 'group_a' ? 'selected' : '' }}>Group A</option>
                        <option value="group_b" {{ old('age') === 'group_b' ? 'selected' : '' }}>Group B</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="country">Country</label>
                    <input id="country" type="text"
                           name="country"
                           class="form-control-pro"
                           value="{{ old('country') }}"
                           placeholder="e.g. Bangladesh">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required" for="password">Password</label>
                <input id="password" type="password"
                       name="password"
                       class="form-control-pro"
                       placeholder="Minimum 8 characters"
                       required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="form-label required" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password"
                       name="password_confirmation"
                       class="form-control-pro"
                       placeholder="Repeat your password"
                       required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="check-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Keep me signed in after registration</span>
                </label>
            </div>

            <button type="submit" class="btn-pro btn-primary-pro" style="width: 100%; justify-content: center; padding: 11px;">
                Create Account
            </button>
        </form>

        <div class="auth-divider">Already have an account? <a href="{{ url('/login') }}" class="auth-link">Sign in</a></div>
    </div>
</div>
@endsection

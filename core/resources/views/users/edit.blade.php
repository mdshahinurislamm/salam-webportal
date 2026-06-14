@extends('layouts.master')

@section('page-title', 'Edit User')

@section('content')
<a href="{{ route('users.index') }}" class="back-link">← Back to Users</a>

<div style="max-width: 660px;">
    <div class="page-header">
        <div>
            <div class="page-header-title">Edit Profile</div>
            <div class="page-header-sub">Editing: <strong>{{ $user->first_name }} {{ $user->last_name }}</strong></div>
        </div>
    </div>

    <div class="card-pro" style="margin-bottom: 18px;">
        <div class="card-pro-header">
            <span class="card-pro-title">Account Details</span>
        </div>
        <div class="card-pro-body">
            <form action="{{ route('users.update', $user) }}" method="POST" id="user-form">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="first_name">First Name</label>
                        <input id="first_name" type="text" name="first_name"
                               class="form-control-pro"
                               value="{{ old('first_name', $user->first_name) }}"
                               required>
                    </div>
                    <div class="form-group">
                        <label class="form-label required" for="last_name">Last Name</label>
                        <input id="last_name" type="text" name="last_name"
                               class="form-control-pro"
                               value="{{ old('last_name', $user->last_name) }}"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="email">Email Address</label>
                    <input id="email" type="email" name="email"
                           class="form-control-pro"
                           value="{{ old('email', $user->email) }}"
                           required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label required" for="role">Role</label>
                        <input id="role" type="text" name="role"
                               class="form-control-pro"
                               value="{{ old('role', $user->role) }}"
                               required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="age">Age Group</label>                       

                        <select id="type" name="age" class="form-control-pro">
                            <option value="group_a" {{ old('age', $user->age) === 'group_a' ? 'selected' : '' }}>Group A</option>
                            <option value="group_b" {{ old('age', $user->age) === 'group_b' ? 'selected' : '' }}>Group B</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="country">Country</label>
                    <input id="country" type="text" name="country"
                           class="form-control-pro"
                           value="{{ old('country', $user->country) }}"
                           placeholder="e.g. Bangladesh">
                </div>
            </form>
        </div>
    </div>

    <div class="card-pro" style="margin-bottom: 18px;">
        <div class="card-pro-header">
            <span class="card-pro-title">Change Password</span>
        </div>
        <div class="card-pro-body">
            <p style="font-size: 13px; color: var(--muted); margin: 0 0 16px;">Leave blank to keep the current password.</p>

            <div class="form-group">
                <label class="form-label" for="password">New Password</label>
                <input id="password" type="password" name="password"
                       form="user-form"
                       class="form-control-pro"
                       placeholder="Minimum 8 characters">
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       form="user-form"
                       class="form-control-pro"
                       placeholder="Repeat new password">
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 10px;">
        <button type="submit" form="user-form" class="btn-pro btn-primary-pro">Save Changes</button>
        <a href="{{ route('users.index') }}" class="btn-pro btn-ghost">Cancel</a>
    </div>
</div>
@endsection

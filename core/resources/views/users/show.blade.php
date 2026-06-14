@extends('layouts.master')

@section('page-title', 'User Profile')

@section('content')
<a href="{{ route('users.index') }}" class="back-link">← Back to Users</a>

<div style="max-width: 600px;">
    <div class="card-pro">
        <div class="card-pro-header">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--brand); color: #fff; display: grid; place-items: center; font-size: 18px; font-weight: 700; flex-shrink: 0;">
                    {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 16px;">{{ $user->first_name }} {{ $user->last_name }}</div>
                    <div style="font-size: 12.5px; color: var(--muted);">{{ $user->email }}</div>
                </div>
            </div>
            <span class="badge-pro badge-blue">{{ ucfirst($user->role) }}</span>
        </div>

        <div class="card-pro-body">
            <dl class="detail-list">
                <dt>Full Name</dt>
                <dd>{{ $user->first_name }} {{ $user->last_name }}</dd>

                <dt>Email Address</dt>
                <dd>{{ $user->email }}</dd>

                <dt>Role</dt>
                <dd>{{ ucfirst($user->role) }}</dd>

                <dt>Age</dt>
                <dd>{{ $user->age ?? 'Not specified' }}</dd>

                <dt>Country</dt>
                <dd>{{ $user->country ?? 'Not specified' }}</dd>

                <dt>Member Since</dt>
                <dd>{{ $user->created_at->format('d M Y') }}</dd>
            </dl>

            <div style="display: flex; gap: 10px; padding-top: 6px; border-top: 1px solid var(--border); margin-top: 6px;">
                <a href="{{ route('users.edit', $user) }}" class="btn-pro btn-warning-pro">Edit Profile</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST"
                      onsubmit="return confirm('Permanently delete this user account?');" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-pro btn-danger-pro">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

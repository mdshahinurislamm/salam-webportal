@extends('layouts.master')

@section('page-title', 'Users')

@section('content')
<div class="page-header">
    <div>
        <div class="page-header-title">Registered Users</div>
        <div class="page-header-sub">All accounts on the platform</div>
    </div>
</div>

<div class="card-pro">
    <table class="table-pro">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Country</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--brand-light); color: var(--brand); display: grid; place-items: center; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                                {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div style="font-weight: 500;">{{ $user->first_name }} {{ $user->last_name }}</div>
                        </div>
                    </td>
                    <td style="color: var(--muted); font-size: 13px;">{{ $user->email }}</td>
                    <td>
                        <span class="badge-pro badge-blue">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td style="color: var(--muted); font-size: 13px;">{{ $user->country ?? '—' }}</td>
                    <td style="color: var(--muted); font-size: 12.5px; white-space: nowrap;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="actions-row">
                            <a href="{{ route('users.show', $user) }}" class="btn-pro btn-ghost btn-sm-pro">Profile</a>
                            <a href="{{ route('users.edit', $user) }}" class="btn-pro btn-warning-pro btn-sm-pro">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Delete this user account?');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-pro btn-danger-pro btn-sm-pro">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">👤</div>
                            <p>No users registered yet.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
        <div style="padding: 16px 22px; border-top: 1px solid var(--border);">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection

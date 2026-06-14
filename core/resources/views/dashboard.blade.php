@extends('layouts.master')

@section('page-title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <div class="page-header-title">Welcome back, {{ optional(auth()->user())->first_name }} 👋</div>
        <div class="page-header-sub">Here's what's happening in your admin panel today.</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 28px;">
    <div class="stat-card" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div class="stat-label">PDF Documents</div>
            <div class="stat-value">—</div>
        </div>
        <div class="stat-icon" style="background: #eff6ff;">📄</div>
    </div>
    <div class="stat-card" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div class="stat-label">Banners</div>
            <div class="stat-value">—</div>
        </div>
        <div class="stat-icon" style="background: #fef3c7;">🖼</div>
    </div>
    <div class="stat-card" style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div class="stat-label">Registered Users</div>
            <div class="stat-value">—</div>
        </div>
        <div class="stat-icon" style="background: #f0fdf4;">👥</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
    <div class="card-pro">
        <div class="card-pro-header">
            <span class="card-pro-title">Quick Actions</span>
        </div>
        <div class="card-pro-body" style="display: flex; flex-direction: column; gap: 10px;">
            <a href="{{ route('posts.create') }}" class="btn-pro btn-primary-pro">
                📄 Upload New PDF
            </a>
            <a href="{{ route('banners.create') }}" class="btn-pro btn-ghost">
                🖼 Add Banner
            </a>
            <a href="{{ url('/users') }}" class="btn-pro btn-ghost">
                👤 Manage Users
            </a>
        </div>
    </div>

    <div class="card-pro">
        <div class="card-pro-header">
            <span class="card-pro-title">Recent Activity</span>
        </div>
        <div class="card-pro-body">
            <p style="color: var(--muted); font-size: 13.5px; margin: 0;">
                Activity feed coming soon. Use the sidebar to navigate your content sections.
            </p>
        </div>
    </div>
</div>
@endsection

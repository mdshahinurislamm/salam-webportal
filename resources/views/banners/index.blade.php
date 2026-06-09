@extends('layouts.master')

@section('page-title', 'Banners')

@section('content')
<div class="page-header">
    <div>
        <div class="page-header-title">Banners</div>
        <div class="page-header-sub">Manage promotional and content banners</div>
    </div>
    <a href="{{ route('banners.create') }}" class="btn-pro btn-primary-pro">+ Add Banner</a>
</div>

<div class="card-pro">
    <table class="table-pro">
        <thead>
            <tr>
                <th style="width: 130px;">Preview</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $banner->image) }}"
                             alt="{{ $banner->name }}"
                             style="width: 110px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border);">
                    </td>
                    <td style="font-weight: 600;">{{ $banner->name }}</td>
                    <td>
                        <div class="actions-row">
                            <a href="{{ route('banners.edit', $banner) }}" class="btn-pro btn-warning-pro btn-sm-pro">Edit</a>
                            <form action="{{ route('banners.destroy', $banner) }}" method="POST"
                                  onsubmit="return confirm('Delete this banner?');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-pro btn-danger-pro btn-sm-pro">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-state-icon">🖼</div>
                            <p>No banners yet. <a href="{{ route('banners.create') }}" style="color: var(--brand);">Add the first one.</a></p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($banners->hasPages())
        <div style="padding: 16px 22px; border-top: 1px solid var(--border);">
            {{ $banners->links() }}
        </div>
    @endif
</div>
@endsection

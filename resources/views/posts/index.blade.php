@extends('layouts.master')

@section('page-title', 'PDF Documents')

@section('content')
<div class="page-header">
    <div>
        <div class="page-header-title">PDF Documents</div>
        <div class="page-header-sub">Manage all uploaded PDFs</div>
    </div>
    <a href="{{ route('posts.create') }}" class="btn-pro btn-primary-pro">
        + Upload PDF
    </a>
</div>

<div class="card-pro">
    <table class="table-pro">
        <thead>
            <tr>
                <th>Title &amp; Author</th>
                <th>Type</th>
                <th>Language</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: var(--text);">{{ $post->title }}</div>
                        <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">
                            By {{ $post->user->first_name ?? 'Unknown' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-pro badge-blue">{{ $post->type ?? 'N/A' }}</span>
                    </td>
                    <td style="color: var(--muted); font-size: 13px;">
                        {{ ucfirst($post->languages ?? '—') }}
                    </td>
                    <td>
                        @if($post->is_published)
                            <span class="badge-pro badge-green">● Published</span>
                        @else
                            <span class="badge-pro badge-gray">○ Draft</span>
                        @endif
                    </td>
                    <td style="color: var(--muted); font-size: 12.5px; white-space: nowrap;">
                        {{ $post->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="actions-row">
                            <a href="{{ route('posts.show', $post) }}" class="btn-pro btn-ghost btn-sm-pro">View</a>
                            <a href="{{ route('posts.edit', $post) }}" class="btn-pro btn-warning-pro btn-sm-pro">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                  onsubmit="return confirm('Delete this PDF permanently?');" style="margin:0;">
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
                            <div class="empty-state-icon">📄</div>
                            <p>No PDFs uploaded yet. <a href="{{ route('posts.create') }}" style="color: var(--brand);">Upload the first one.</a></p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($posts->hasPages())
        <div style="padding: 16px 22px; border-top: 1px solid var(--border);">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection

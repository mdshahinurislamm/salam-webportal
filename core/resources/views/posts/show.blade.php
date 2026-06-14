@extends('layouts.master')

@section('page-title', $post->title)

@section('content')
<a href="{{ route('posts.index') }}" class="back-link">← Back to PDFs</a>

<div class="page-header">
    <div>
        <div class="page-header-title">{{ $post->title }}</div>
        <div class="page-header-sub" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-top: 6px;">
            <span>By <strong>{{ $post->user->first_name ?? 'Unknown' }}</strong></span>
            <span style="color: var(--border);">|</span>
            <span>{{ $post->created_at->format('d M Y') }}</span>
            @if($post->type)
                <span style="color: var(--border);">|</span>
                <span class="badge-pro badge-blue">{{ $post->type }}</span>
            @endif
            @if($post->languages)
                <span class="badge-pro badge-gray">{{ ucfirst($post->languages) }}</span>
            @endif
            @if($post->is_published)
                <span class="badge-pro badge-green">● Published</span>
            @else
                <span class="badge-pro badge-gray">○ Draft</span>
            @endif
        </div>
    </div>
    <div class="actions-row">
        <a href="{{ route('posts.edit', $post) }}" class="btn-pro btn-warning-pro">Edit</a>
        <form action="{{ route('posts.destroy', $post) }}" method="POST"
              onsubmit="return confirm('Delete this PDF permanently?');" style="margin:0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-pro btn-danger-pro">Delete</button>
        </form>
    </div>
</div>

@if($post->image)
    <div style="display: flex; gap: 10px; margin-bottom: 20px;">
        <a href="{{ asset('storage/' . $post->image) }}" target="_blank"
           class="btn-pro btn-primary-pro">
            📄 Open PDF
        </a>
        <a href="{{ asset('storage/' . $post->image) }}" download
           class="btn-pro btn-ghost">
            📥 Download
        </a>
    </div>

    <div class="card-pro" style="overflow: hidden;">
        <embed src="{{ asset('storage/' . $post->image) }}"
               type="application/pdf"
               width="100%" height="620px"
               style="display: block; border-radius: var(--radius);" />
    </div>
@else
    <div class="card-pro">
        <div class="empty-state">
            <div class="empty-state-icon">📄</div>
            <p>No PDF file attached to this document.</p>
        </div>
    </div>
@endif
@endsection

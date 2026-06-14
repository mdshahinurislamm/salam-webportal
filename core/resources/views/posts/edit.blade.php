@extends('layouts.master')

@section('page-title', 'Edit PDF')

@section('content')
<a href="{{ route('posts.index') }}" class="back-link">← Back to PDFs</a>

<div style="max-width: 660px;">
    <div class="page-header">
        <div>
            <div class="page-header-title">Edit PDF</div>
            <div class="page-header-sub">Update details for: <strong>{{ $post->title }}</strong></div>
        </div>
    </div>

    <div class="card-pro">
        <div class="card-pro-body">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label required" for="title">Title</label>
                    <input id="title" type="text" name="title"
                           class="form-control-pro"
                           value="{{ old('title', $post->title) }}"
                           required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="type">Age Group</label>
                        <select id="type" name="type" class="form-control-pro">
                            <option value="group_a" {{ old('type', $post->type) === 'group_a' ? 'selected' : '' }}>Group A</option>
                            <option value="group_b" {{ old('type', $post->type) === 'group_b' ? 'selected' : '' }}>Group B</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="languages">Language</label>
                        <select id="languages" name="languages" class="form-control-pro">
                            <option value="english" {{ old('languages', $post->languages) === 'english' ? 'selected' : '' }}>English</option>
                            <option value="arabic"  {{ old('languages', $post->languages) === 'arabic'  ? 'selected' : '' }}>Arabic</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">PDF File</label>
                    @if($post->image)
                        <div style="background: var(--bg); border: 1px solid var(--border); border-radius: 7px; padding: 12px 16px; margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 20px;">📄</span>
                            <div>
                                <div style="font-size: 13px; font-weight: 500;">Current PDF</div>
                                <a href="{{ asset('storage/' . $post->image) }}" target="_blank"
                                   style="font-size: 12px; color: var(--brand);">View / Open PDF</a>
                            </div>
                        </div>
                    @endif
                    <label class="file-input-wrap" for="pdf-file-input">
                        <input type="file" id="pdf-file-input" name="image" accept="application/pdf">
                        <div style="font-size: 22px; margin-bottom: 4px;">📎</div>
                        <div class="file-label" style="font-size: 13.5px; font-weight: 500; color: var(--brand);">
                            {{ $post->image ? 'Replace PDF (optional)' : 'Click to choose a PDF file' }}
                        </div>
                        <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">PDF files only</div>
                    </label>
                    <style>
                        #pdf-file-input { display: block; opacity: 0; width: 0; height: 0; position: absolute; }
                    </style>
                </div>

                <div class="form-group">
                    <label class="check-row">
                        <input type="checkbox" name="is_published" value="1"
                               {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                        <span>Published</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px; padding-top: 6px;">
                    <button type="submit" class="btn-pro btn-warning-pro">Update PDF</button>
                    <a href="{{ route('posts.index') }}" class="btn-pro btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const inp = document.getElementById('pdf-file-input');
    const lbl = document.querySelector('.file-label');
    if (inp && lbl) {
        inp.style = '';
        inp.addEventListener('change', () => {
            lbl.textContent = inp.files[0]?.name ?? 'Replace PDF (optional)';
        });
    }
</script>
@endsection

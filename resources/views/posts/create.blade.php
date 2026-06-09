@extends('layouts.master')

@section('page-title', 'Upload PDF')

@section('content')
<a href="{{ route('posts.index') }}" class="back-link">← Back to PDFs</a>

<div style="max-width: 660px;">
    <div class="page-header">
        <div>
            <div class="page-header-title">Upload New PDF</div>
            <div class="page-header-sub">Fill in the details and attach a PDF file</div>
        </div>
    </div>

    <div class="card-pro">
        <div class="card-pro-body">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label required" for="title">Title</label>
                    <input id="title" type="text" name="title"
                           class="form-control-pro"
                           value="{{ old('title') }}"
                           placeholder="Enter document title"
                           required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="type">Age Group</label>
                        <select id="type" name="type" class="form-control-pro">
                            <option value="group_a" {{ old('type') === 'group_a' ? 'selected' : '' }}>Group A</option>
                            <option value="group_b" {{ old('type') === 'group_b' ? 'selected' : '' }}>Group B</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="languages">Language</label>
                        <select id="languages" name="languages" class="form-control-pro">
                            <option value="english"  {{ old('languages') === 'english'  ? 'selected' : '' }}>English</option>
                            <option value="arabic"   {{ old('languages') === 'arabic'   ? 'selected' : '' }}>Arabic</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">PDF File</label>
                    <label class="file-input-wrap" for="pdf-file-input">
                        <input type="file" id="pdf-file-input" name="image" accept="application/pdf">
                        <div style="font-size: 28px; margin-bottom: 6px;">📄</div>
                        <div class="file-label" style="font-size: 13.5px; font-weight: 500; color: var(--brand);">Click to choose a PDF file</div>
                        <div style="font-size: 12px; color: var(--muted); margin-top: 3px;">PDF files only</div>
                    </label>
                    <style>
                        #pdf-file-input { display: block; opacity: 0; width: 0; height: 0; position: absolute; }
                        .file-input-wrap { cursor: pointer; }
                    </style>
                </div>

                <div class="form-group">
                    <label class="check-row">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publish immediately</span>
                    </label>
                    <div class="form-hint">Unpublished PDFs are saved as drafts and not visible to users.</div>
                </div>

                <div style="display: flex; gap: 10px; padding-top: 6px;">
                    <button type="submit" class="btn-pro btn-primary-pro">Save PDF</button>
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
            lbl.textContent = inp.files[0]?.name ?? 'Click to choose a PDF file';
        });
    }
</script>
@endsection

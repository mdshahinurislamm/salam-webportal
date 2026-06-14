@extends('layouts.master')

@section('page-title', 'Add Banner')

@section('content')
<a href="{{ route('banners.index') }}" class="back-link">← Back to Banners</a>

<div style="max-width: 520px;">
    <div class="page-header">
        <div>
            <div class="page-header-title">Add Banner</div>
            <div class="page-header-sub">Upload a new banner image</div>
        </div>
    </div>

    <div class="card-pro">
        <div class="card-pro-body">
            <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label required" for="name">Banner Name</label>
                    <input id="name" type="text" name="name"
                           class="form-control-pro"
                           value="{{ old('name') }}"
                           placeholder="e.g. Ramadan Promotion"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label required">Banner Image</label>
                    <label class="file-input-wrap" for="banner-img-input" id="banner-drop">
                        <input type="file" id="banner-img-input" name="image" accept="image/*" required>
                        <div id="banner-preview" style="display:none; margin-bottom: 10px;">
                            <img id="preview-img" style="max-width: 100%; max-height: 180px; border-radius: 6px; object-fit: cover;" src="" alt="Preview">
                        </div>
                        <div id="banner-placeholder">
                            <div style="font-size: 28px; margin-bottom: 6px;">🖼</div>
                            <div class="file-label" style="font-size: 13.5px; font-weight: 500; color: var(--brand);">Click to choose image</div>
                            <div style="font-size: 12px; color: var(--muted); margin-top: 3px;">JPG, PNG, GIF, WebP</div>
                        </div>
                    </label>
                </div>

                <div style="display: flex; gap: 10px; padding-top: 6px;">
                    <button type="submit" class="btn-pro btn-primary-pro">Save Banner</button>
                    <a href="{{ route('banners.index') }}" class="btn-pro btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const inp = document.getElementById('banner-img-input');
    inp.style = '';
    inp.addEventListener('change', () => {
        if (inp.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('banner-preview').style.display = 'block';
                document.getElementById('banner-placeholder').style.display = 'none';
            };
            reader.readAsDataURL(inp.files[0]);
        }
    });
</script>
@endsection

@extends('layouts.master')

@section('page-title', 'Edit Banner')

@section('content')
<a href="{{ route('banners.index') }}" class="back-link">← Back to Banners</a>

<div style="max-width: 520px;">
    <div class="page-header">
        <div>
            <div class="page-header-title">Edit Banner</div>
            <div class="page-header-sub">Updating: <strong>{{ $banner->name }}</strong></div>
        </div>
    </div>

    <div class="card-pro">
        <div class="card-pro-body">
            <form action="{{ route('banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label required" for="name">Banner Name</label>
                    <input id="name" type="text" name="name"
                           class="form-control-pro"
                           value="{{ old('name', $banner->name) }}"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">Banner Image</label>
                    @if($banner->image)
                        <div style="margin-bottom: 12px;">
                            <div style="font-size: 12px; color: var(--muted); margin-bottom: 6px; font-weight: 500;">Current image:</div>
                            <img src="{{ asset('storage/' . $banner->image) }}"
                                 alt="{{ $banner->name }}"
                                 style="max-width: 100%; max-height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                        </div>
                    @endif

                    <label class="file-input-wrap" for="banner-img-input">
                        <input type="file" id="banner-img-input" name="image" accept="image/*">
                        <div id="banner-preview" style="display:none; margin-bottom: 10px;">
                            <img id="preview-img" style="max-width: 100%; max-height: 180px; border-radius: 6px; object-fit: cover;" src="" alt="Preview">
                        </div>
                        <div id="banner-placeholder">
                            <div style="font-size: 20px; margin-bottom: 4px;">🔄</div>
                            <div class="file-label" style="font-size: 13.5px; font-weight: 500; color: var(--brand);">Replace image (optional)</div>
                            <div style="font-size: 12px; color: var(--muted); margin-top: 2px;">JPG, PNG, GIF, WebP</div>
                        </div>
                    </label>
                </div>

                <div style="display: flex; gap: 10px; padding-top: 6px;">
                    <button type="submit" class="btn-pro btn-warning-pro">Update Banner</button>
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

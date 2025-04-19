@extends('layouts.admin')

@section('title', 'Új videó feltöltése')

@section('styles')
<style>
    .progress {
        height: 25px;
    }
    .progress-bar {
        line-height: 25px;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Új videó feltöltése</h1>
        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Vissza a listához
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form id="uploadForm" action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Videó címe <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Leírás</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="video" class="form-label">Videó fájl <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('video') is-invalid @enderror" id="video" name="video" required accept="video/mp4,video/avi,video/mpeg,video/quicktime">
                    @error('video')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Támogatott formátumok: MP4, AVI, MPEG, QuickTime. Maximum fájlméret: 500 MB.</small>
                </div>

                <div id="upload-progress" class="mb-3 d-none">
                    <label class="form-label">Feltöltés állapota</label>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_downloadable" name="is_downloadable" {{ old('is_downloadable') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_downloadable">Letölthető</label>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktív</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Videó feltöltése</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('uploadForm');
        const progressBar = document.querySelector('.progress-bar');
        const progressContainer = document.getElementById('upload-progress');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();

            progressContainer.classList.remove('d-none');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Feltöltés folyamatban...';

            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.upload.addEventListener('progress', function (e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percentComplete + '%';
                    progressBar.textContent = percentComplete + '%';
                    progressBar.setAttribute('aria-valuenow', percentComplete);
                }
            });

            xhr.addEventListener('load', function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    window.location.href = '{{ route('admin.videos.index') }}';
                } else {
                    progressBar.classList.remove('bg-info');
                    progressBar.classList.add('bg-danger');
                    progressBar.textContent = 'Hiba történt a feltöltés során!';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Videó feltöltése';
                }
            });

            xhr.addEventListener('error', function () {
                progressBar.classList.remove('bg-info');
                progressBar.classList.add('bg-danger');
                progressBar.textContent = 'Hiba történt a feltöltés során!';
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Videó feltöltése';
            });

            xhr.send(formData);
        });
    });
</script>
@endsection

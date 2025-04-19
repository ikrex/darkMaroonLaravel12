@extends('layouts.admin')

@section('title', 'Videó szerkesztése')

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
        <h1>Videó szerkesztése: {{ $video->title }}</h1>
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

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form id="uploadForm" action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Videó címe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $video->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Leírás</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $video->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video" class="form-label">Videó fájl (csak ha cserélni szeretnéd)</label>
                            <input type="file" class="form-control @error('video') is-invalid @enderror" id="video" name="video" accept="video/mp4,video/avi,video/mpeg,video/quicktime">
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Támogatott formátumok: MP4, AVI, MPEG, QuickTime. Maximum fájlméret: 500 MB.</small>
                            <p class="mt-2">Jelenlegi fájl: <strong>{{ $video->original_filename }}</strong> ({{ number_format($video->file_size / 1048576, 2) }} MB)</p>
                        </div>

                        <div id="upload-progress" class="mb-3 d-none">
                            <label class="form-label">Feltöltés állapota</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_downloadable" name="is_downloadable" {{ old('is_downloadable', $video->is_downloadable) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_downloadable">Letölthető</label>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktív</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Változtatások mentése</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Videó előnézet</h5>
                </div>
                <div class="card-body">
                    <video
                        controls
                        class="w-100 mb-3"
                        poster="{{ asset('images/video-placeholder.jpg') }}"
                    >
                        <source src="{{ asset('storage/' . $video->full_path) }}" type="{{ $video->mime_type }}">
                        A böngésződ nem támogatja a videó lejátszását.
                    </video>

                    <div class="d-grid gap-2">
                        <a href="{{ asset('storage/' . $video->full_path) }}" class="btn btn-sm btn-outline-primary" download="{{ $video->original_filename }}">
                            <i class="bi bi-download"></i> Videó letöltése
                        </a>
                    </div>
                </div>
            </div>
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
        const videoInput = document.getElementById('video');

        form.addEventListener('submit', function (e) {
            // Csak akkor aktiváljuk a progress bar-t, ha van kiválasztott videó fájl
            if (videoInput.files.length > 0) {
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
                        submitBtn.innerHTML = 'Változtatások mentése';
                    }
                });

                xhr.addEventListener('error', function () {
                    progressBar.classList.remove('bg-info');
                    progressBar.classList.add('bg-danger');
                    progressBar.textContent = 'Hiba történt a feltöltés során!';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Változtatások mentése';
                });

                xhr.send(formData);
            }
            // Ha nincs kiválasztott videó fájl, normálisan folytatjuk az űrlap beküldését
        });
    });
</script>
@endsection

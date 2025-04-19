@extends('layouts.admin')

@section('title', 'Videó részletei')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Videó részletei: {{ $video->title }}</h1>
        <div>
            <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-warning me-2">
                <i class="bi bi-pencil"></i> Szerkesztés
            </a>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Vissza a listához
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Videó lejátszása</h5>
                </div>
                <div class="card-body">
                    <video controls class="w-100" poster="{{ asset('images/video-placeholder.jpg') }}">
                        <source src="{{ asset('storage/' . $video->full_path) }}" type="{{ $video->mime_type }}">
                        A böngésződ nem támogatja a videó lejátszását.
                    </video>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Videó információk</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Feltöltve:</strong>
                            <span>{{ $video->created_at->format('Y-m-d H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Utoljára módosítva:</strong>
                            <span>{{ $video->updated_at->format('Y-m-d H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Eredeti fájlnév:</strong>
                            <span>{{ $video->original_filename }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Fájlméret:</strong>
                            <span>{{ number_format($video->file_size / 1048576, 2) }} MB</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>MIME típus:</strong>
                            <span>{{ $video->mime_type }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Állapot:</strong>
                            <span class="badge {{ $video->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $video->is_active ? 'Aktív' : 'Inaktív' }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Letölthető:</strong>
                            <span class="badge {{ $video->is_downloadable ? 'bg-info' : 'bg-secondary' }}">
                                {{ $video->is_downloadable ? 'Igen' : 'Nem' }}
                            </span>
                        </li>
                    </ul>

                    <div class="d-grid gap-2 mt-3">
                        @if($video->is_downloadable)
                            <a href="{{ asset('storage/' . $video->full_path) }}" class="btn btn-primary" download="{{ $video->original_filename }}">
                                <i class="bi bi-download"></i> Videó letöltése
                            </a>
                        @endif

                        <form action="{{ route('admin.videos.toggle-active', $video->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $video->is_active ? 'warning' : 'success' }} w-100">
                                {{ $video->is_active ? 'Deaktiválás' : 'Aktiválás' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.videos.toggle-downloadable', $video->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                {{ $video->is_downloadable ? 'Letöltés tiltása' : 'Letöltés engedélyezése' }}
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Videó törlése
                        </button>
                    </div>
                </div>
            </div>

            @if($video->description)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Leírás</h5>
                    </div>
                    <div class="card-body">
                        {{ $video->description }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Videó törlése</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Biztosan törölni szeretné a(z) <strong>{{ $video->title }}</strong> videót? Ez a művelet nem visszavonható!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Törlés</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

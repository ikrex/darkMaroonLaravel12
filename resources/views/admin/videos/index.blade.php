
@extends('layouts.admin')

@section('title', 'Tanfolyam videók')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tanfolyam videók</h1>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Új videó feltöltése
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cím</th>
                            <th>Eredeti fájlnév</th>
                            <th>Méret</th>
                            <th>Feltöltve</th>
                            <th>Állapot</th>
                            <th>Letölthető</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $video)
                            <tr>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->original_filename }}</td>
                                <td>{{ number_format($video->file_size / 1048576, 2) }} MB</td>
                                <td>{{ $video->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.videos.toggle-active', $video->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $video->is_active ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $video->is_active ? 'Aktív' : 'Inaktív' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.videos.toggle-downloadable', $video->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $video->is_downloadable ? 'btn-info' : 'btn-secondary' }}">
                                            {{ $video->is_downloadable ? 'Letölthető' : 'Nem letölthető' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.videos.show', $video->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $video->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $video->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $video->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $video->id }}">Videó törlése</h5>
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nincsenek feltöltött videók.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@extends('app')

@section('title', 'Tanfolyam videók')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4">Tanfolyam videók</h1>
            <p class="lead">Nézd meg a tanfolyamhoz tartozó oktatóvideókat.</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($videos as $video)
            <div class="col">
                <div class="card h-100">
                    <div class="card-img-top ratio ratio-16x9">
                        <video poster="{{ asset('images/video-thumbnail.jpg') }}" preload="none">
                            <source src="{{ route('course.videos.stream', $video->id) }}" type="{{ $video->mime_type }}">
                            A böngésző nem támogatja a videó lejátszását.
                        </video>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $video->title }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($video->description, 100) }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('course.videos.show', $video->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-play-circle"></i> Megtekintés
                        </a>
                        @if($video->is_downloadable)
                            <a href="{{ route('course.videos.download', $video->id) }}" class="btn btn-outline-secondary btn-sm float-end">
                                <i class="bi bi-download"></i> Letöltés
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <p class="mb-0">Jelenleg nincsenek elérhető videók.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $videos->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Video thumbnail preview on hover
        const videoElements = document.querySelectorAll('.card-img-top video');
        videoElements.forEach(video => {
            video.parentElement.addEventListener('mouseenter', function() {
                video.play();
            });

            video.parentElement.addEventListener('mouseleave', function() {
                video.pause();
                video.currentTime = 0;
            });
        });
    });
</script>
@endsection

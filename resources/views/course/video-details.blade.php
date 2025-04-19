@extends('app')

@section('title', $video->title)

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Kezdőlap</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course.videos') }}">Tanfolyam videók</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $video->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="ratio ratio-16x9">
                        <video controls autoplay poster="{{ asset('images/video-thumbnail.jpg') }}">
                            <source src="{{ route('course.videos.stream', $video->id) }}" type="{{ $video->mime_type }}">
                            A böngésző nem támogatja a videó lejátszását.
                        </video>
                    </div>
                </div>
            </div>

            <h1>{{ $video->title }}</h1>
            <p class="text-muted">Feltöltve: {{ $video->created_at->format('Y-m-d') }}</p>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Leírás</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $video->description ?: 'Nincs leírás.' }}</p>
                </div>
                @if($video->is_downloadable)
                    <div class="card-footer">
                        <a href="{{ route('course.videos.download', $video->id) }}" class="btn btn-primary">
                            <i class="bi bi-download"></i> Videó letöltése
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">További videók</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach(App\Models\CourseVideo::where('is_active', true)
                            ->where('id', '!=', $video->id)
                            ->latest()
                            ->take(5)
                            ->get() as $relatedVideo)
                            <a href="{{ route('course.videos.show', $relatedVideo->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $relatedVideo->title }}</h6>
                                </div>
                                <small class="text-muted">{{ $relatedVideo->created_at->format('Y-m-d') }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('course.videos') }}" class="btn btn-outline-primary btn-sm w-100">Összes videó megtekintése</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

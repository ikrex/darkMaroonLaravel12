<?php

namespace App\Http\Controllers;

use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseVideoController extends Controller
{
    /**
     * Display a listing of the active videos.
     */
    public function index()
    {
        $videos = CourseVideo::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('course.videos', compact('videos'));
    }

    /**
     * Display the specified video.
     */
    public function show($id)
    {
        $video = CourseVideo::where('is_active', true)->findOrFail($id);

        return view('course.video-details', compact('video'));
    }

    /**
     * Download the specified video if it's downloadable.
     */
    public function download($id)
    {
        $video = CourseVideo::where('is_active', true)
            ->where('is_downloadable', true)
            ->findOrFail($id);

        $path = Storage::disk('course_videos')->path($video->stored_filename);

        return response()->download($path, $video->original_filename);
    }

    /**
     * Stream the video content.
     */
    public function stream($id)
    {
        $video = CourseVideo::where('is_active', true)->findOrFail($id);
        $path = Storage::disk('course_videos')->path($video->stored_filename);

        $stream = new StreamedResponse(function() use ($path) {
            $stream = fopen($path, 'rb');
            fpassthru($stream);
            fclose($stream);
        });

        $stream->headers->set('Content-Type', $video->mime_type);
        $stream->headers->set('Accept-Ranges', 'bytes');
        $stream->headers->set('Content-Length', filesize($path));

        return $stream;
    }
}

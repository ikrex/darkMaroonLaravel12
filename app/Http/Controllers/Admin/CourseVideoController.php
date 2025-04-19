<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = CourseVideo::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:524288', // 500 MB max
            'is_downloadable' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Ensure the course videos directory exists
        if (!Storage::disk('course_videos')->exists('')) {
            Storage::disk('course_videos')->makeDirectory('');
        }

        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $originalFilename = $videoFile->getClientOriginalName();
            $extension = $videoFile->getClientOriginalExtension();

            // Generate a unique filename
            $storedFilename = Str::uuid() . '.' . $extension;

            // Store the file
            $path = $videoFile->storeAs('', $storedFilename, 'course_videos');

            // Create database record
            $video = CourseVideo::create([
                'title' => $request->title,
                'description' => $request->description,
                'original_filename' => $originalFilename,
                'stored_filename' => $storedFilename,
                'file_path' => 'courseVideos',
                'mime_type' => $videoFile->getMimeType(),
                'file_size' => $videoFile->getSize(),
                'is_downloadable' => $request->has('is_downloadable'),
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.videos.index')
                ->with('success', 'Videó sikeresen feltöltve!');
        }

        return redirect()->back()
            ->with('error', 'Hiba történt a videó feltöltésekor. Kérjük, próbálja újra.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseVideo $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseVideo $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseVideo $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:524288', // 500 MB max
            'is_downloadable' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_downloadable' => $request->has('is_downloadable'),
            'is_active' => $request->has('is_active'),
        ];

        // Check if a new video file is being uploaded
        if ($request->hasFile('video')) {
            // Delete the old file
            Storage::disk('course_videos')->delete($video->stored_filename);

            $videoFile = $request->file('video');
            $originalFilename = $videoFile->getClientOriginalName();
            $extension = $videoFile->getClientOriginalExtension();

            // Generate a unique filename
            $storedFilename = Str::uuid() . '.' . $extension;

            // Store the file
            $path = $videoFile->storeAs('', $storedFilename, 'course_videos');

            // Update database record with new file information
            $data['original_filename'] = $originalFilename;
            $data['stored_filename'] = $storedFilename;
            $data['mime_type'] = $videoFile->getMimeType();
            $data['file_size'] = $videoFile->getSize();
        }

        $video->update($data);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Videó sikeresen frissítve!');
    }

    /**
     * Toggle the active status of the video.
     */
    public function toggleActive(CourseVideo $video)
    {
        $video->is_active = !$video->is_active;
        $video->save();

        return redirect()->back()
            ->with('success', 'Videó státusza sikeresen módosítva!');
    }

    /**
     * Toggle the downloadable status of the video.
     */
    public function toggleDownloadable(CourseVideo $video)
    {
        $video->is_downloadable = !$video->is_downloadable;
        $video->save();

        return redirect()->back()
            ->with('success', 'Videó letölthetőségi státusza sikeresen módosítva!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseVideo $video)
    {
        // Delete the file
        Storage::disk('course_videos')->delete($video->stored_filename);

        // Delete the database record
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Videó sikeresen törölve!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Registration;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function contentList()
    {
        $contents = Content::orderBy('sort_order')->get();
        return view('admin.content.index', compact('contents'));
    }

    public function contentCreate()
    {
        return view('admin.content.create');
    }

    public function contentStore(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:contents,key|regex:/^[a-zA-Z0-9_]+$/',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'title_english' => 'nullable|string|max:255',
            'content_english' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Content::create($validated);

        return redirect()->route('admin.content.list')
            ->with('success', 'Az új tartalom sikeresen létrehozva!');
    }


    public function contentEdit($id)
    {
        $content = Content::findOrFail($id);
        return view('admin.content.edit', compact('content'));
    }



    public function contentUpdate(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'title_english' => 'nullable|string|max:255',
            'content_english' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $content->update($validated);

        return redirect()->route('admin.content.list')
            ->with('success', 'A tartalom sikeresen frissítve!');
    }



    public function registrationList()
    {
        $registrations = Registration::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function viewRegistration($id)
    {
        $registration = Registration::findOrFail($id);
        return view('admin.registrations.view', compact('registration'));
    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ContactInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                return redirect()->route('home')->with('error', 'Nincs jogosultságod az admin felület eléréséhez.');
            }
            return $next($request);
        });
    }

    public function edit()
    {
        $contactInfo = ContactInfo::first();
        return view('admin.contact_info.edit', compact('contactInfo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'address_hu' => 'nullable|string|max:255',
            'address_en' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
        ]);

        $contactInfo = ContactInfo::first();
        if (!$contactInfo) {
            $contactInfo = new ContactInfo();
        }

        $contactInfo->fill($validated);
        $contactInfo->save();

        // Töröljük a gyorsítótárat, hogy a frissített adatok jelenjenek meg
        Cache::forget('contact_info');

        return redirect()->route('admin.contact_info.edit')
            ->with('success', 'Kapcsolati adatok sikeresen frissítve!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminRegistrationController extends Controller
{
    public function index(Request $request)
    {
        // Alapértelmezett szűrés a "pending" regisztrációkra
        $statusFilter = $request->input('status', 'pending');

        $query = Registration::query();

        // Szűrés állapot szerint
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Egyéb szűrők hozzáadása (pl. keresés név szerint)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.registrations.index', [
            'registrations' => $registrations,
            'statusFilter' => $statusFilter
        ]);
    }

    public function show($id)
    {
        $registration = Registration::findOrFail($id);
        return view('admin.registrations.show', ['registration' => $registration]);
    }

    public function approve($id)
    {
        $registration = Registration::findOrFail($id);

        // Ellenőrzés, hogy ez a regisztráció még nem lett elbírálva
        if ($registration->status !== 'pending') {
            return redirect()->route('admin.registrations.index')
                ->with('error', 'Ez a regisztráció már el lett bírálva.');
        }

        // Ellenőrzés, hogy létezik-e már felhasználó ezzel az email címmel
        $existingUser = User::where('email', $registration->email)->first();
        if ($existingUser) {
            return redirect()->route('admin.registrations.index')
                ->with('error', 'Már létezik felhasználó ezzel az email címmel.');
        }

        // Új felhasználó létrehozása a regisztráció alapján
        $user = new User();
        $user->name = $registration->name;
        $user->email = $registration->email;
        // Véletlenszerű jelszó generálása (amit majd le kell cserélnie)
        $password = substr(md5(rand()), 0, 8);
        $user->password = Hash::make($password);
        // Alap felhasználói szerepkör
        $user->role = 'user';
        $user->save();

        // Regisztráció státusz frissítése
        $registration->status = 'approved';
        $registration->user_id = $user->id;
        $registration->save();

        // TODO: Email küldése a felhasználónak az új fiókról és jelszóról

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Regisztráció jóváhagyva. Felhasználói fiók létrehozva. Jelszó: ' . $password);
    }

    public function reject(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        // Ellenőrzés, hogy ez a regisztráció még nem lett elbírálva
        if ($registration->status !== 'pending') {
            return redirect()->route('admin.registrations.index')
                ->with('error', 'Ez a regisztráció már el lett bírálva.');
        }

        // Elutasítás oka (opcionális)
        $reason = $request->input('reason', '');

        // Regisztráció státusz frissítése
        $registration->status = 'rejected';
        $registration->rejection_reason = $reason;
        $registration->save();

        // TODO: Email küldése a felhasználónak az elutasításról és annak okáról

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Regisztráció elutasítva.');
    }
}

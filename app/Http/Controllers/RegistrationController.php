<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Mail\RegistrationConfirmation;
use App\Mail\NewRegistrationNotification;

class RegistrationController extends Controller
{
    public function showForm()
    {
        $locale = Session::get('locale', 'hu');
        App::setLocale($locale);
        return view('registration');
    }



    public function changeLanguage(Request $request)
    {
        $language = $request->language;
        Session::put('locale', $language);
        App::setLocale($language);

        return redirect()->back();
    }



    public function submitForm(Request $request)
    {
        // Validáció
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_details' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|string|in:bank_transfer,revolut,other',
            'love_language_test' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'question1' => 'nullable|string',
            'question2' => 'nullable|string|in:yes,no',
            'question3' => 'nullable|integer|between:1,5',
            'question4' => 'nullable|string',
            'question5' => 'nullable|string',
            'desire' => 'nullable|string',
        ]);

        // Fájl feltöltés kezelése
        $filePath = null;
        if ($request->hasFile('love_language_test')) {
            $file = $request->file('love_language_test');
            $filePath = $file->store('love_language_tests', 'public');
        }

        // Adatok mentése
        $registration = Registration::create([
            'name' => $validated['name'],
            'birth_details' => $validated['birth_details'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'payment_method' => $validated['payment_method'],
            'love_language_test_file' => $filePath,
            'question1' => $validated['question1'] ?? null,
            'question2' => $validated['question2'] ?? null,
            'question3' => $validated['question3'] ?? null,
            'question4' => $validated['question4'] ?? null,
            'question5' => $validated['question5'] ?? null,
            'desire' => $validated['desire'] ?? null,
        ]);

        // Opcionális: email értesítés küldése
        Mail::to($registration->email)->send(new RegistrationConfirmation($registration));

        // Opcionális: Admin értesítése
        Mail::to('illeskalman77@gmail.com')->send(new NewRegistrationNotification($registration));

        // Sikeres üzenet
        $successMessage = Session::get('locale') === 'en'
            ? 'Registration submitted successfully! Thank you.'
            : 'Regisztráció sikeresen elküldve! Köszönjük.';

        return redirect()->back()->with('success', $successMessage);
    }

}

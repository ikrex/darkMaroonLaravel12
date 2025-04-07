<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
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

    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'tagsagLejar' => 'nullable|date',
            'konzultaciosAlkalmak' => 'required|integer|min:0',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Felhasználó sikeresen létrehozva!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'tagsagLejar' => 'nullable|date',
            'konzultaciosAlkalmak' => 'required|integer|min:0',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Felhasználó adatai sikeresen frissítve!');
    }

    public function destroy(User $user)
    {
        // Ne engedje törölni saját magát
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Nem törölheted saját felhasználói fiókodat!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Felhasználó sikeresen törölve!');
    }

    public function extendMembership(Request $request, User $user)
    {
        $request->validate([
            'months' => 'required|in:1,2,3',
        ]);

        $months = (int) $request->months;

        if ($user->tagsagLejar && $user->tagsagLejar > now()) {
            // Ha a tagság a jövőben jár le, ahhoz adunk hozzá
            $user->tagsagLejar = Carbon::parse($user->tagsagLejar)->addMonths($months);
        } else {
            // Egyébként a mai dátumhoz adunk hozzá
            $user->tagsagLejar = Carbon::now()->addMonths($months);
        }

        $user->save();

        return back()->with('success', "A tagság {$months} hónappal meghosszabbítva!");
    }

    public function addConsultation(Request $request, User $user)
    {
        $request->validate([
            'alkalmak' => 'required|integer|min:1|max:10',
        ]);

        $alkalmak = (int) $request->alkalmak;

        $user->konzultaciosAlkalmak += $alkalmak;
        $user->save();

        return back()->with('success', "{$alkalmak} konzultációs alkalom hozzáadva!");
    }

    public function useConsultation(User $user)
    {
        if ($user->konzultaciosAlkalmak <= 0) {
            return back()->with('error', 'A felhasználónak nincs több konzultációs alkalma!');
        }

        $user->konzultaciosAlkalmak -= 1;
        $user->save();

        return back()->with('success', 'Egy konzultációs alkalom felhasználva!');
    }
}

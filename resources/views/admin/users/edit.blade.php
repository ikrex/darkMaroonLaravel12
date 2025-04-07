@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Felhasználó szerkesztése</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Vissza a listához</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Név</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email cím</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Új jelszó (csak ha változtatni szeretnéd)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Új jelszó megerősítése</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Jogosultság</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Felhasználó</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tagsagLejar" class="form-label">Tagság lejárata</label>
                    <input type="date" class="form-control @error('tagsagLejar') is-invalid @enderror" id="tagsagLejar" name="tagsagLejar" value="{{ old('tagsagLejar', $user->tagsagLejar ? $user->tagsagLejar->format('Y-m-d') : '') }}">
                    @error('tagsagLejar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="konzultaciosAlkalmak" class="form-label">Konzultációs alkalmak száma</label>
                    <input type="number" class="form-control @error('konzultaciosAlkalmak') is-invalid @enderror" id="konzultaciosAlkalmak" name="konzultaciosAlkalmak" value="{{ old('konzultaciosAlkalmak', $user->konzultaciosAlkalmak) }}" min="0" required>
                    @error('konzultaciosAlkalmak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-stanford">Mentés</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tagság hosszabbítása</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.extend-membership', $user->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="months" class="form-label">Válassz hosszabbítási időt:</label>
                            <select class="form-select" name="months" id="months" required>
                                <option value="1">1 hónap</option>
                                <option value="2">2 hónap</option>
                                <option value="3">3 hónap</option>
                            </select>
                        </div>
                        <p class="mb-3">
                            Jelenlegi lejárat:
                            <strong>
                                @if($user->tagsagLejar)
                                    {{ $user->tagsagLejar->format('Y-m-d') }}
                                @else
                                    Nincs beállítva
                                @endif
                            </strong>
                        </p>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-stanford">Hosszabbítás</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Konzultációs alkalmak kezelése</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.add-consultation', $user->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label for="alkalmak" class="form-label">Hozzáadandó alkalmak száma:</label>
                            <input type="number" class="form-control" id="alkalmak" name="alkalmak" min="1" max="10" value="1" required>
                        </div>
                        <p class="mb-3">
                            Jelenlegi alkalmak száma: <strong>{{ $user->konzultaciosAlkalmak }}</strong>
                        </p>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-stanford">Alkalmak hozzáadása</button>
                        </div>
                    </form>

                    <form action="{{ route('admin.users.use-consultation', $user->id) }}" method="POST">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-stanford" {{ $user->konzultaciosAlkalmak <= 0 ? 'disabled' : '' }}>
                                Konzultáció felhasználása (-1)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

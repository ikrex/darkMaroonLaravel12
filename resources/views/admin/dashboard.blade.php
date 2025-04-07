@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Admin Panel</h1>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Felhasználók</h5>
                    <p class="card-text display-4">{{ \App\Models\User::count() }}</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Felhasználók kezelése</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Aktív tagságok</h5>
                    <p class="card-text display-4">{{ \App\Models\User::where('tagsagLejar', '>', now())->count() }}</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Tagságok kezelése</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Tartalmak</h5>
                    <p class="card-text display-4">{{ \App\Models\Content::count() }}</p>
                    <a href="{{ route('admin.content.list') }}" class="btn btn-light">Tartalom szerkesztése</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Hamarosan lejáró tagságok</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @php
                            $expiringUsers = \App\Models\User::where('tagsagLejar', '>', now())
                                ->where('tagsagLejar', '<', now()->addDays(14))
                                ->orderBy('tagsagLejar')
                                ->take(5)
                                ->get();
                        @endphp

                        @forelse($expiringUsers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $user->name }}
                                <span class="badge bg-warning text-dark">
                                    {{ $user->tagsagLejar->format('Y-m-d') }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item">Nincs hamarosan lejáró tagság</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Új felhasználók</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @php
                            $newUsers = \App\Models\User::orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp

                        @forelse($newUsers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $user->name }}
                                <span class="badge bg-primary">
                                    {{ $user->created_at->format('Y-m-d') }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item">Nincs még felhasználó</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

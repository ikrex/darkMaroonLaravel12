@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Felhasználók kezelése</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-stanford">Új felhasználó</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Név</th>
                            <th>Email</th>
                            <th>Jogosultság</th>
                            <th>Tagság lejár</th>
                            <th>Konzultációs alkalmak</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                        {{ $user->role === 'admin' ? 'Admin' : 'Felhasználó' }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->tagsagLejar)
                                        <span class="{{ $user->tagsagLejar < now() ? 'text-danger' : 'text-success' }}">
                                            {{ $user->tagsagLejar->format('Y-m-d') }}
                                        </span>
                                    @else
                                        <span class="text-muted">Nincs beállítva</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $user->konzultaciosAlkalmak }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Műveletek
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">Szerkesztés</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#extendMembershipModal{{ $user->id }}">
                                                    Tagság hosszabbítás
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addConsultationModal{{ $user->id }}">
                                                    Konzultáció hozzáadása
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.users.use-consultation', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item {{ $user->konzultaciosAlkalmak <= 0 ? 'disabled' : '' }}">
                                                        Konzultáció felhasználása
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Biztosan törölni szeretnéd ezt a felhasználót?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Törlés</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Tagság hosszabbítás modal -->
                            <div class="modal fade" id="extendMembershipModal{{ $user->id }}" tabindex="-1" aria-labelledby="extendMembershipModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="extendMembershipModalLabel{{ $user->id }}">Tagság hosszabbítása - {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.users.extend-membership', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="months" class="form-label">Válassz hosszabbítási időt:</label>
                                                    <select class="form-select" name="months" id="months" required>
                                                        <option value="1">1 hónap</option>
                                                        <option value="2">2 hónap</option>
                                                        <option value="3">3 hónap</option>
                                                    </select>
                                                </div>
                                                <p class="mb-0">
                                                    Jelenlegi lejárat:
                                                    <strong>
                                                        @if($user->tagsagLejar)
                                                            {{ $user->tagsagLejar->format('Y-m-d') }}
                                                        @else
                                                            Nincs beállítva
                                                        @endif
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                                                <button type="submit" class="btn btn-primary">Hosszabbítás</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Konzultáció hozzáadása modal -->
                            <div class="modal fade" id="addConsultationModal{{ $user->id }}" tabindex="-1" aria-labelledby="addConsultationModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addConsultationModalLabel{{ $user->id }}">Konzultációs alkalmak hozzáadása - {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.users.add-consultation', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="alkalmak" class="form-label">Hozzáadandó alkalmak száma:</label>
                                                    <input type="number" class="form-control" id="alkalmak" name="alkalmak" min="1" max="10" value="1" required>
                                                </div>
                                                <p class="mb-0">
                                                    Jelenlegi alkalmak száma: <strong>{{ $user->konzultaciosAlkalmak }}</strong>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                                                <button type="submit" class="btn btn-primary">Hozzáadás</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

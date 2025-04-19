@extends('layouts.app')


@section('title', 'Admin Panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Oldalsáv -->
        <div class="col-md-3 col-lg-2 p-0">
            <div class="admin-sidebar p-3">

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            Irányítópult
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}"
                           href="{{ route('admin.content.list') }}">
                            Tartalom kezelése
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}"
                           href="{{ route('admin.registrations.list') }}">
                            Regisztrációk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">
                            Felhasználók
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}" href="{{ route('admin.videos.index') }}">
                            <i class="bi bi-film"></i> Tanfolyam videók
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.contact_info.*') ? 'active' : '' }}"
                            href="{{ route('admin.contact_info.edit') }}">
                            Lábléc szerkesztése
                        </a>
                    </li>
                </ul>



            </div>
        </div>

        <!-- Fő tartalom -->
        <div class="col-md-9 col-lg-10 p-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @yield('styles')
            @yield('scripts')
            @yield('admin_content')
        </div>
    </div>
</div>
@endsection

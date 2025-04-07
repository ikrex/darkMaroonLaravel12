<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Balázs Bettina')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/maroon-style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @yield('styles')

    <style>
        .navbar-sticky {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
    </style>


</head>


<body>
    <!-- Stanford stílusú navigáció -->
    <nav class="navbar navbar-expand-lg stanford-navbar navbar-sticky">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Balázs Bettina</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/about">{{ Session::get('locale') == 'en' ? 'About' : 'Rólam' }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registration') }}">{{ Session::get('locale') == 'en' ? 'Registration' : 'Regisztráció' }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">{{ Session::get('locale') == 'en' ? 'Contact' : 'Kapcsolat' }}</a>
                    </li>

                    <!-- Képzések lenyíló menü -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarTrainingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Session::get('locale') == 'en' ? 'Trainings' : 'Képzések' }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarTrainingDropdown">
                            <li>
                                <a class="dropdown-item" href="/academy">{{ Session::get('locale') == 'en' ? 'MSC AKADEMY' : 'MSC AKADÉMIA' }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/course">{{ Session::get('locale') == 'en' ? '"Speak so that you are understood" course' : '"Beszélj úgy, hogy megértsenek" tanfolyam' }}</a>
                            </li>
                        </ul>
                    </li>


                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ Session::get('locale') == 'en' ? 'Logout' : 'Kijelentkezés' }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ Session::get('locale') == 'en' ? 'Login' : 'Bejelentkezés' }}</a>
                        </li>
                    @endauth

                    <!-- Nyelvválasztás zászlókkal -->
                    <li class="nav-item d-flex align-items-center ms-2">
                        <form action="{{ route('change.language') }}" method="POST" class="me-1">
                            @csrf
                            <button type="submit" name="language" value="hu" class="btn btn-sm p-0 border-0" title="Magyar">
                                <img src="{{ asset('images/hu-flag.webp') }}" alt="Magyar" width="22" height="16">
                            </button>
                        </form>
                        <form action="{{ route('change.language') }}" method="POST">
                            @csrf
                            <button type="submit" name="language" value="en" class="btn btn-sm p-0 border-0" title="English">
                                <img src="{{ asset('images/en-flag.webp') }}" alt="English" width="22" height="16">
                            </button>
                        </form>
                    </li>


                </ul>
            </div>




        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Stanford stílusú footer -->
    @include('partials.footer')



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

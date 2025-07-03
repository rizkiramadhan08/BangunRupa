<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }} - BangunRupa</title>

    <!-- FAVICON -->
    <link rel="icon" href="{{ asset('img/Logo1.png') }}" type="image/png">

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- FONT AWESOME --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

    {{-- BOOTSRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />/>
</head>

<body>
    <style>
        .navbar-nav .nav-link:hover {
            color: #0d6efd !important;
            /* warna biru Bootstrap */
            font-weight: 600;
        }
    </style>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('img/Logo1.png') }}" alt="Logo" />
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('home') ? 'active text-primary fw-semibold' : 'text-secondary' }}"
                            href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('koleksi') ? 'active text-primary fw-semibold' : 'text-secondary' }}"
                            href="{{ route('koleksi') }}">Koleksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('form.faq') ? 'active text-primary fw-semibold' : 'text-secondary' }}"
                            href="{{ route('form.faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active text-primary fw-semibold' : 'text-secondary' }}"
                            href="{{ route('kontak') }}">Kontak Kami</a>
                    </li>
                </ul>
                @guest
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary px-4">Daftar</a>
                    </div>
                @endguest
                @auth
                    <div class="dropdown">
                        <a href="#" class="text-dark fw-semibold text-decoration-none dropdown-toggle"
                            id="userDropdown" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            Halo, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profil') }}">Profil</a></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="{{ route('history') }}">History</a>
                                <a class="dropdown-item" href="#" onclick="confirmLogout(event)">Logout</a>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

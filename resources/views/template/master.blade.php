<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Helpdesk</title>


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{url ('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url ('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('dist/img/Logo_PTPN4.png') }}" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (wajib untuk accordion bekerja) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('css')
    <!-- <style>
        .accordion-body,
        .accordion-body *,
        .accordion-button {
            color: #000 !important;
            background-color: #fff !important;
            opacity: 1 !important;
            font-size: 1rem !important;
            /* Tambahan biar teksnya kelihatan */
            line-height: 1.5 !important;
            /* Biar tinggi baris sesuai isi */
            font-family: inherit !important;
        }

        /* Pastikan p tidak collapse tingginya */
        .accordion-body p {
            margin: 0.25rem 0 !important;
            display: block !important;
        }
    </style> -->
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars ml-2"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <!-- <a href="{{ route('beranda') }}" class="nav-link">Home</a> -->
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Icon Profile -->
                <li class="nav-item mr-4">
                    <a href="{{ route('profile.show') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i> Profile
                    </a>

                </li>

                <!-- Icon Logout -->
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link mr-4" style="padding: 0; color: inherit;">
                            <i class="nav-icon fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>


                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ 
                 auth()->user()->role === 'asisten' ? route('beranda') : 
                 (auth()->user()->role === 'krani' ? route('krani.dashboard') : 
                  (auth()->user()->role === 'pelapor' ? route('pelapor.dashboard') : '#')) 
            }}" class="brand-link">
                <img src="{{ asset('dist/img/Logo_PTPN4.png') }}" alt="Logo PTPN" class="brand-image img-circle elevation-3" style="opacity: .8; max-width: 60px; height: auto;">
                <span class="brand-text font-weight-light">Sistem Helpdesk</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @if(auth()->user()->role === 'asisten')
                        <li class="nav-item">
                            <a href="{{ route('beranda') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('totalLaporan') }}" class="nav-link">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Total Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporanSelesai') }}" class="nav-link">
                                <i class="nav-icon fas fa-check-circle"></i>
                                <p>Laporan Selesai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('antrian') }}" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Antrian Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('proses') }}" class="nav-link">
                                <i class="nav-icon fas fa-spinner"></i>
                                <p>Laporan Diproses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('knowledge.base') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Knowledge Base</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Tambah User</p>
                            </a>
                        </li>

                        @elseif(auth()->user()->role === 'krani')
                        <li class="nav-item">
                            <a href="{{ route('krani.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('totalLaporan') }}" class="nav-link">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Total Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporanSelesai') }}" class="nav-link">
                                <i class="nav-icon fas fa-check-circle"></i>
                                <p>Laporan Selesai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('antrian') }}" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Antrian Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('proses') }}" class="nav-link">
                                <i class="nav-icon fas fa-spinner"></i>
                                <p>Laporan Diproses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('knowledge.base') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Knowledge Base</p>
                            </a>
                        </li>
                        {{-- Krani tidak bisa tambah user --}}

                        @elseif(auth()->user()->role === 'pelapor')
                        <li class="nav-item">
                            <a href="{{ route('pelapor.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('laporan.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Buat Laporan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('totalLaporan') }}" class="nav-link">
                                <i class="nav-icon fas fa-check-circle"></i>
                                <p>Laporan Saya</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pelapor.riwayat') }}" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Riwayat</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('knowledge.base') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Knowledge Base</p>
                            </a>
                        </li>
                        @endif
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>

    <script src="{{url ('plugins/jquery/jquery.min.js')}}"></script>
    <!-- <script src="{{url ('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script> -->
    <script src="{{url ('dist/js/adminlte.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
    @stack('scripts')
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
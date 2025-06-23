<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ request()->routeIs('pelanggan.home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pelanggan.home') }}">Beranda</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Kue Kami
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <h6 class="dropdown-header">Kategori</h6>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('produk.kategori', ['kategori' => 'kering']) }}">🍪 Kue
                            Kering</a></li>
                    <li><a class="dropdown-item" href="{{ route('produk.kategori', ['kategori' => 'basah']) }}">🍰 Kue
                            Basah</a></li>
                </ul>
            </li>


            <li class="nav-item {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pelanggan.riwayat') }}">Riwayat</a>
            </li>


            <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
        </ul>

        <div class="d-flex align-items-center ms-auto">
            {{-- Cart --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link p-0"><i class="fas fa-shopping-cart"></i></a>
                </li>
            </ul>

            {{-- Guest: tampilkan tombol login --}}
            @guest
                <a href="{{ route('login') }}" class="btn btn-pesan ml-3">
                    <i class="fa fa-user"></i> Login
                </a>
            @endguest

            {{-- Auth: tampilkan foto user dan dropdown --}}
            @auth
                @php
                    $foto =
                        Auth::user()->gambar && file_exists(public_path(Auth::user()->gambar))
                            ? Auth::user()->gambar
                            : 'fotos/default.png';
                @endphp

                <div class="dropdown ml-3 position-relative">
                    <a href="#" class="d-flex align-items-center" data-toggle="dropdown" style="padding: 0;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                            <img src="{{ asset($foto) }}" alt="User"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </div>
                    </a>

                    <div class="dropdown-menu mt-2" style="left: 0;">
                        <span class="dropdown-item-text fw-bold">{{ Auth::user()->namalengkap }}</span>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth


        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand"><img src="{{ asset('images/logos.png') }}"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ request()->routeIs('pelanggan.home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pelanggan.home') }}">Beranda</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/tentang') }}">Tentang Kami</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownKue" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Kue Kami
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownKue">
                    <li>
                        <h6 class="dropdown-header">Kategori</h6>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('produk.kategori', ['kategori' => 'kering']) }}" onclick="sessionStorage.setItem('scrollToKategori', true)">🍪 Kue
                            Kering</a></li>
                    <li><a class="dropdown-item" href="{{ route('produk.kategori', ['kategori' => 'basah']) }}" onclick="sessionStorage.setItem('scrollToKategori', true)">🍰 Kue
                            Basah</a></li>
                </ul>
            </li>
            <li class="nav-item {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pelanggan.riwayat') }}" onclick="sessionStorage.setItem('scrollToRiwayat', true)">Riwayat</a>
            </li>
        </ul>
        <div class="d-flex align-items-center ms-auto">
            {{-- Cart --}}
            <ul class="navbar-nav">
                <li class="nav-item dropdown position-relative">
                    <a class="nav-link p-0" href="#" id="dropdownKeranjang" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-shopping-cart"></i>
                        @if ($jumlahKeranjang > 0)
                            <span
                                class="badge bg-danger text-white rounded-pill position-absolute top-0 start-100 translate-middle"
                                style="font-size: 0.6rem;">
                                {{ $jumlahKeranjang }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2 shadow" aria-labelledby="dropdownKeranjang"
                        style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                        @auth
                            @forelse ($items as $item)
                                <li class="border-bottom py-2">
                                    <div class="d-flex align-items-center justify-content-between">
                                        {{-- Gambar Produk --}}
                                        <img src="{{ asset($item->produk->foto_produk ?? 'https://via.placeholder.com/40') }}"
                                            alt="foto" class="rounded"
                                            style="width: 50px; height: 50px; object-fit: cover;">

                                        {{-- Nama dan Harga --}}
                                        <div class="flex-grow-1 mx-2">
                                            <div class="fw-semibold" style="font-size: 0.9rem;">
                                                {{ $item->produk->nama_produk }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.8rem;">
                                                Rp{{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </div>
                                        </div>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('keranjang.hapus', $item->id_keranjang) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-muted px-1 py-0"
                                                style="font-size: 1rem;">&times;</button>
                                        </form>
                                    </div>

                                    {{-- Tombol Pesan Sekarang --}}
                                    <div class="mt-2">
                                        <a href="{{ route('form.pemesanan', $item->produk->id_produk) }}" onclick="sessionStorage.setItem('scrollToProduk', true)"
                                            class="btn btn-success btn-sm w-100">Pesan Sekarang</a>
                                    </div>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text text-muted">Keranjang kosong</span></li>
                            @endforelse
                        @else
                            <li><span class="dropdown-item-text">Silakan <a href="{{ route('login') }}">login</a>
                                    dulu</span></li>
                        @endauth
                    </ul>
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
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPengaturan">
                            <i class="fas fa-cog"></i> Pengaturan
                        </a>
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
<!-- Modal Pengaturan -->
<div class="modal fade" id="modalPengaturan" tabindex="-1" aria-labelledby="modalPengaturanLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPengaturanLabel">Pengaturan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger py-1 px-2 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profil.perbarui') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-center">
                        <label for="gambarInput" style="cursor: pointer;">
                            <img id="previewImage" src="{{ asset(Auth::user()->gambar ?? 'fotos/default.png') }}"
                                alt="Foto Profil" class="rounded-circle"
                                style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ccc;">
                        </label>
                        <input type="file" name="gambar" id="gambarInput" class="form-control d-none"
                            onchange="previewFoto(this)">
                        <small class="form-text text-muted">Klik gambar untuk mengganti foto</small>
                    </div>
                    @auth
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="namalengkap" class="form-control"
                                value="{{ old('namalengkap', Auth::user()->namalengkap) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control"
                                value="{{ old('username', Auth::user()->username) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Password (kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                            value="{{ old('alamat', Auth::user()->alamat) }}">
                        </div>
                        <div class="mb-3">
                            <label>Nomor Telepon</label>
                            <input type="text" name="nomortelepon" class="form-control"
                                value="{{ old('nomortelepon', Auth::user()->nomortelepon) }}" required>
                        </div>
                    @endauth

                    <div class="modal-footer px-0">
                        <button type="submit" class="btn-custom-pesan">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

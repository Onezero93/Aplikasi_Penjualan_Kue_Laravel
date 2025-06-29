<div class="text-center mb-4">
    @auth
        @php
            $foto =
                Auth::user()->gambar && file_exists(public_path(Auth::user()->gambar))
                    ? Auth::user()->gambar
                    : 'fotos/default.png';
        @endphp

        <img src="{{ asset($foto) }}" alt="Foto Profil" class="rounded-circle"
            style="width: 80px; height: 80px; object-fit: cover;">

        <div class="mt-2 font-weight-bold">
            {{ Auth::user()->namalengkap }}
        </div>
    @else
        <i class="fa fa-user-circle fa-3x text-secondary"></i>
        <div class="mt-2 font-weight-bold">Nama Pengguna</div>
    @endauth
</div>
{{-- <a href="index.html" class="mb-2 d-block">Home</a>
<a href="about.html" class="mb-2 d-block">About</a> --}}
<a href="{{ route('admin.dashboard') }}"
    class="mb-2 d-block {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
<a href="{{ route('order.datapemesanan') }}"
    class="mb-2 d-block {{ request()->routeIs('order.datapemesanan') ? 'active' : '' }}">
    Data Order Kue</a>
<a href="{{ route('produk.dataproduk') }}"
    class="mb-2 d-block {{ request()->routeIs('produk.dataproduk') ? 'active' : '' }}">
    Data Kue
</a>

<a href="{{ route('pengguna.datapengguna') }}"
    class="mb-2 d-block {{ request()->routeIs('pengguna.datapengguna') ? 'active' : '' }}">
    Data Pengguna
</a>

{{-- Tombol Logout --}}
@auth
    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn-logout">
            Logout <i class="fa fa-sign-out"></i>
        </button>
    </form>
@endauth


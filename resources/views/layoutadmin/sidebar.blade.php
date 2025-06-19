<div class="text-center mb-4">
    @auth
        {{-- Foto Pengguna dengan fallback default --}}
        @php
            $foto = Auth::user()->gambar ?: 'default.png';
        @endphp
        <img src="{{ asset('images/user/' . $foto) }}"
             alt="Foto Profil"
             class="rounded-circle"
             style="width: 80px; height: 80px; object-fit: cover;">

        {{-- Nama Pengguna --}}
        <div class="mt-2 font-weight-bold">
            {{ Auth::user()->namalengkap }}
        </div>
    @else
        <i class="fa fa-user-circle fa-3x text-secondary"></i>
        <div class="mt-2 font-weight-bold">Nama Pengguna</div>
    @endauth
</div>

<a href="index.html" class="mb-2 d-block">Home</a>
<a href="about.html" class="mb-2 d-block">About</a>
<a href="services.html" class="mb-2 d-block">Services</a>
<a href="blog.html" class="mb-2 d-block">Data Order Kue</a>
<a href="contact.html" class="mb-2 d-block">Data Kue</a>
<a href="contact.html" class="mb-2 d-block">Data Pengguna</a>

{{-- Tombol Logout --}}
@auth
    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-link text-danger p-0 d-block" style="text-decoration: none;">
            Logout <i class="fa fa-sign-out"></i>
        </button>
    </form>
@endauth

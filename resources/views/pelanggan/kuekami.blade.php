@extends('layoutpelanggan.index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="cream_taital">Kue {{ ucfirst($kategori) }}</h1>
            <p class="cream_text">Berikut adalah pilihan kue {{ strtolower($kategori) }} yang kami sajikan khusus untuk Anda.</p>
        </div>
    </div>

    <div class="cream_section_2 py-5">
        <div class="row">
            @forelse ($produk as $item)
                <div class="col-md-4 mb-4">
                    <div class="cream_box">
                        <div class="cream_img">
                            <img src="{{ asset($item->foto_produk ?? 'https://via.placeholder.com/100') }}"
                                 alt="{{ $item->nama_produk }}" class="img-produk">
                        </div>
                        <div class="price_text">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                        <h6 class="strawberry_text">{{ $item->nama_produk }}</h6>
                        <div class="d-flex justify-content-center align-items-center pesan-wrapper">
                            <a href="#" class="icon-only">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                            @guest
                                <a href="{{ route('login') }}" class="btn-pesan">
                                    Pesan
                                </a>
                            @else
                                @if (Auth::user()->status === 'pelanggan')
                                    <a href="{{ route('form.pemesanan', $item->id_produk) }}" class="btn-pesan">
                                        Pesan
                                    </a>
                                @else
                                    <span class="btn-pesan text-muted" style="cursor: not-allowed; opacity: 0.5;">
                                        Pesan
                                    </span>
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada produk untuk kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

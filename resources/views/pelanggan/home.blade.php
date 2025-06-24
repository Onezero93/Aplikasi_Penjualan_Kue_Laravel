@extends('layoutpelanggan.index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="cream_taital">Kue Pilihan Terbaik</h1>
            <p class="cream_text">Kami menyajikan aneka kue istimewa yang dibuat dengan bahan pilihan dan sentuhan rasa yang
                tak terlupakan.</p>
        </div>

    </div>
    <div class="cream_section_2 py-5">
        <div class="row">
            @foreach ($produk as $index => $item)
                <div class="col-md-4 mb-4 {{ $index >= 3 ? 'd-none produk-lain' : '' }}">
                    <div class="cream_box">
                        <div class="cream_img">
                            <img src="{{ asset($item->foto_produk ?? 'https://via.placeholder.com/100') }}"
                                alt="{{ $item->nama_produk }}" class="img-produk">
                        </div>
                        <div class="price_text">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                        <h6 class="strawberry_text">{{ $item->nama_produk }}</h6>
                        <div class="d-flex justify-content-center align-items-center pesan-wrapper">
                            <a href="{{ route('keranjang.simpan', ['id_produk' => $item->id_produk]) }}" class="icon-only">
                                <i class="fas fa-shopping-cart"></i>
                            </a>

                            @guest
                                {{-- Belum login, arahkan ke login --}}
                                <a href="{{ route('login') }}" class="btn-pesan">
                                    <i class=""></i> Pesan
                                </a>
                            @else
                                @if (Auth::user()->status === 'pelanggan')
                                    {{-- Jika pelanggan login, arahkan ke form pemesanan --}}
                                    <a href="{{ route('form.pemesanan', $item->id_produk) }}" class="btn-pesan">
                                        <i class=""></i> Pesan
                                    </a>
                                @else
                                    {{-- Selain pelanggan, nonaktifkan tombol --}}
                                    <span class="btn-pesan text-muted" style="cursor: not-allowed; opacity: 0.5;">
                                        <i class=""></i> Pesan
                                    </span>
                                @endif
                            @endguest
                            {{-- <a href="#" class="icon-only">
                                <i class="fas fa-shopping-cart"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="seemore_bt text-center">
        <a href="#" id="lihat-semua">Lihat Semua Produk</a>
    </div>

    @push('scripts')
    @endpush
@endsection

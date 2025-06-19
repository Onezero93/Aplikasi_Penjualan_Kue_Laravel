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
                            <a href="#" class="icon-only">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                            <a href="#" class="btn-pesan">Pesan</a>
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

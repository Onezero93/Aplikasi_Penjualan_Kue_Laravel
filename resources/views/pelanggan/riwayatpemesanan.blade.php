@extends('layoutpelanggan.index')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4 text-center">Riwayat Pemesanan Anda</h3>

        @if ($orders->isEmpty())
            <div class="alert alert-info text-center">Belum ada riwayat pemesanan.</div>
        @else
            <div class="row g-3">
                @foreach ($orders as $order)
                    <div class="col-md-12">
                        <div class="card shadow-sm border rounded">
                            <div class="row g-0 align-items-center p-3">
                                <div class="col-md-2 text-center">
                                    <img src="{{ asset($order->produk->foto_produk ?? 'https://via.placeholder.com/100') }}"
                                        class="img-fluid rounded" style="max-height: 100px;" alt="Gambar Kue">
                                </div>
                                <div class="col-md-7">
                                    <h5 class="mb-1">{{ $order->produk->nama_produk }}</h5>
                                    <small class="text-muted">Pesan: {{ $order->created_at->format('d-m-Y H:i') }} |
                                        Ambil: {{ $order->tanggal_ambil }}</small>
                                    <div class="mt-2">
                                        <div><strong>Jumlah:</strong> {{ $order->jumlah }}</div>
                                        <div><strong>Harga Satuan:</strong> Rp
                                            {{ number_format($order->produk->harga, 0, ',', '.') }}</div>
                                        <div><strong>Total:</strong> Rp
                                            {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                                        <div><strong>Metode:</strong> {{ $order->metode_pembayaran }}
                                            ({{ $order->jenis_pembayaran }})</div>
                                        @if ($order->metode_pembayaran == 'DP')
                                            <div><strong>DP:</strong> Rp
                                                {{ number_format($order->nominal_dp, 0, ',', '.') }}</div>
                                            <div><strong>Sisa:</strong> Rp
                                                {{ number_format($order->sisa_pembayaran, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span
                                        class="badge mb-2 {{ $order->status == 'setuju' ? 'bg-success' : ($order->status == 'lunas' ? 'bg-primary' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>

                                    {{-- Bukti Transfer --}}
                                    @if ($order->bukti_transfer)
                                        <div class="mt-2">
                                            <p class="mb-1"><strong>Bukti Transfer:</strong></p>
                                            <a href="{{ asset('storage/' . $order->bukti_transfer) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $order->bukti_transfer) }}"
                                                    class="img-thumbnail" style="max-width: 100px;" alt="Bukti Transfer">
                                            </a>
                                        </div>
                                    @endif

                                    {{-- Bukti Pelunasan --}}
                                    @if ($order->bukti_pelunasan)
                                        <div class="mt-2">
                                            <p class="mb-1"><strong>Bukti Pelunasan:</strong></p>
                                            <a href="{{ asset('storage/' . $order->bukti_pelunasan) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $order->bukti_pelunasan) }}"
                                                    class="img-thumbnail" style="max-width: 100px;" alt="Bukti Pelunasan">
                                            </a>
                                        </div>
                                    @endif
                                    {{-- Tombol Upload Pelunasan --}}
                                    @if (
                                        $order->status == 'setuju' &&
                                            $order->metode_pembayaran == 'DP' &&
                                            $order->sisa_pembayaran > 0 &&
                                            !$order->bukti_pelunasan)
                                        <button class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal"
                                            data-bs-target="#uploadPelunasanModal{{ $order->id_pemesanan }}">
                                            Upload Pelunasan
                                        </button>
                                    @endif

                                    {{-- Modal Upload Pelunasan --}}
                                    <div class="modal fade" id="uploadPelunasanModal{{ $order->id_pemesanan }}"
                                        tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('pelunasan.kirim', $order->id_pemesanan) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Upload Bukti Pelunasan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Silakan unggah bukti pelunasan untuk pesanan:
                                                            <strong>{{ $order->produk->nama_produk }}</strong>
                                                        </p>

                                                        <div class="mb-3">
                                                            <label for="bukti_pelunasan" class="form-label">Bukti Pelunasan
                                                                (JPG/PNG)</label>
                                                            <input type="file" class="form-control"
                                                                name="bukti_pelunasan" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tombol Aksi Tambahan --}}
                                    <div class="mt-2">
                                        {{-- Tombol Pesan Lagi --}}
                                        <a href="{{ route('form.pemesanan', $order->produk->id_produk) }}"
                                            class="btn btn-success btn-sm">
                                            Pesan Lagi
                                        </a>

                                        {{-- Tombol Batalkan Pesanan (hanya jika belum setuju/lunas) --}}
                                        @if (in_array($order->status, ['pending']))
                                            <!-- Tombol trigger modal -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalBatalkan{{ $order->id_pemesanan }}">
                                                Batalkan
                                            </button>

                                            <!-- Modal Konfirmasi Batalkan -->
                                            <div class="modal fade" id="modalBatalkan{{ $order->id_pemesanan }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('batalkan.pesanan', $order->id_pemesanan) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin membatalkan pesanan
                                                                    <strong>{{ $order->produk->nama_produk }}</strong>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">Ya,
                                                                    Batalkan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

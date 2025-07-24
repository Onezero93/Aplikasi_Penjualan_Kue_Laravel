@extends('layoutadmin.index')
@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Data Pesanan Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-warning text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Nama Kue</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Tanggal Ambil</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $order->user->namalengkap }}
                                    </td>

                                    <td>{{ $order->produk->nama_produk }}</td>
                                    <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-center">{{ $order->tanggal_ambil }}</td>
                                    <td>{{ $order->metode_pembayaran }}</td>
                                    <td>
                                        <form action="{{ route('order.updateStatus', $order->id_pemesanan) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                class="form-select form-select-sm no-arrow text-center {{ $order->status === 'setuju' ? 'bg-success text-white' : 'bg-pink' }}"
                                                onchange="this.form.submit()"
                                                {{ $order->status === 'setuju' ? 'disabled' : '' }}>
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="setuju" {{ $order->status == 'setuju' ? 'selected' : '' }}>
                                                    Setuju</option>
                                            </select>

                                        </form>
                                    </td>

                                    <td class="text-center">
                                        @if ($order->status === 'setuju')
                                            <form action="{{ route('order.kirimwa', $order->id_pemesanan) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm me-1" title="Kirim WA">
                                                    <i class="fab fa-whatsapp"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm me-1"
                                                title="WA Tersedia setelah disetujui" disabled>
                                                <i class="fab fa-whatsapp"></i>
                                            </button>
                                        @endif
                                        <a href="#" class="btn btn-primary btn-sm" title="Detail Pesanan"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $order->id_pemesanan }}">
                                            <i class="fas fa-book"></i>
                                        </a>
                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="detailModal{{ $order->id_pemesanan }}" tabindex="-1"
                                            aria-labelledby="detailModalLabel{{ $order->id_pemesanan }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title"
                                                            id="detailModalLabel{{ $order->id_pemesanan }}">Detail Pesanan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="row mb-2">
                                                            <div class="col-5"><strong>Nama Pelanggan</strong></div>
                                                            <div class="col-1">:</div>
                                                            <div class="col-6">{{ $order->user->namalengkap }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-5"><strong>Produk</strong></div>
                                                            <div class="col-1">:</div>
                                                            <div class="col-6">{{ $order->produk->nama_produk }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-5"><strong>Tanggal Pesan</strong></div>
                                                            <div class="col-1">:</div>
                                                            <div class="col-6">
                                                                {{ $order->created_at->format('d-m-Y H:i') }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-5"><strong>Tanggal Ambil</strong></div>
                                                            <div class="col-1">:</div>
                                                            <div class="col-6">{{ $order->tanggal_ambil }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-5"><strong>Jumlah</strong></div>
                                                            <div class="col-1">:</div>
                                                            <div class="col-6">{{ $order->jumlah }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-5"><strong>Total Harga</strong></div>
                                                            <div class="col-1">:</div>
                                                            <div class="col-6">Rp
                                                                {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-5"><strong>Metode</strong></div>
                                                            <div class="col-1">:</div>
                                                            <div class="col-6">{{ $order->metode_pembayaran }}
                                                                ({{ $order->jenis_pembayaran }})
                                                            </div>
                                                        </div>

                                                        @if ($order->metode_pembayaran === 'DP')
                                                            <div class="row mb-2">
                                                                <div class="col-5"><strong>Nominal DP</strong></div>
                                                                <div class="col-1">:</div>
                                                                <div class="col-6">Rp
                                                                    {{ number_format($order->nominal_dp, 0, ',', '.') }}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-5"><strong>Sisa Bayar</strong></div>
                                                                <div class="col-1">:</div>
                                                                <div class="col-6">Rp
                                                                    {{ number_format($order->sisa_pembayaran, 0, ',', '.') }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($order->bukti_transfer)
                                                            <p class="text-center mt-3"><strong>Bukti Transfer</strong></p>
                                                            <div class="text-center">
                                                                <img src="{{ asset($order->bukti_transfer) }}"
                                                                    class="img-fluid rounded" alt="Bukti Transfer"
                                                                    style="max-width: 300px;">
                                                            </div>
                                                        @endif
                                                        @if ($order->bukti_pelunasan)
                                                            <p class="text-center mt-3"><strong>Bukti Pelunasan</strong></p>
                                                            <div class="text-center">
                                                                <img src="{{ asset($order->bukti_pelunasan) }}"
                                                                    class="img-fluid rounded" alt="Bukti Pelunasan"
                                                                    style="max-width: 300px;">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

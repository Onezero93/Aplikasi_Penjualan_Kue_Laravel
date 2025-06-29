@extends('layoutadmin.index')

@section('content')
    <div class="container">
        <h2 class="mb-4"></h4>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5>Total Produk</h5>
                        <h2>{{ $totalProduk }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5>Total Pelanggan</h5>
                        <h2>{{ $totalPelanggan }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5>Total Pesanan</h5>
                        <h2>{{ $totalPesanan }}</h2>
                        <p class="mb-0">Disetujui: {{ $totalSetuju }}</p>
                        <p class="mb-0">Pending: {{ $totalPending }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5>Total Pendapatan</h5>
                        <h2>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h5>Grafik Penjualan per Bulan</h5>
            <canvas id="penjualanChart"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('penjualanChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($penjualanBulanan->keys()), // Nama bulan
                datasets: [{
                    label: 'Total Penjualan',
                    data: @json($penjualanBulanan->values()),
                    backgroundColor: 'rgba(252, 149, 196, 0.7)',
                    borderColor: 'rgba(252, 149, 196, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection

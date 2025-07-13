@extends('layoutpelanggan.index')

@section('content')
    <div class="row" id="pesankue">
        <div class="col-12"> <!-- full width -->
            <div class="services_box">
                <div class="container py-4">
                    <div class="row">
                        <!-- Kolom Formulir -->
                        <div class="col-md-6">
                            <form action="{{ route('pemesanan.simpan', $produk->id_produk) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nama Pemesan</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->namalengkap }}"
                                        readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->nomortelepon }}"
                                        readonly>
                                </div>

                                {{-- Alamat --}}
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2" required>{{ Auth::user()->alamat }}</textarea>
                                </div>

                                {{-- Tanggal Ambil --}}
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Ambil</label>
                                    <input type="date" name="tanggal_ambil" class="form-control" required
                                        min="{{ date('Y-m-d') }}">
                                </div>


                                {{-- Jumlah Pesanan --}}
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Pesanan</label>
                                    <div class="input-group" style="max-width: 160px;">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="kurangiJumlah()">−</button>
                                        <input type="number" id="jumlah" name="jumlah" class="form-control text-center"
                                            value="1" min="1">
                                        <button type="button" class="btn btn-outline-secondary"
                                            onclick="tambahJumlah()">+</button>
                                    </div>
                                </div>

                                {{-- Total Harga --}}
                                <div class="mb-3">
                                    <label class="form-label">Total Harga</label>
                                    <input type="text" id="total_harga_display" class="form-control" readonly>
                                    <input type="hidden" name="total_harga" id="total_harga">
                                </div>

                                {{-- Metode Pembayaran --}}
                                <div class="mb-3">
                                    <label class="form-label">Metode Pembayaran</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="dp" value="DP" required>
                                        <label class="form-check-label" for="dp">DP</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran"
                                            id="lunas" value="Lunas">
                                        <label class="form-check-label" for="lunas">Lunas</label>
                                    </div>
                                </div>

                                {{-- Jenis Pembayaran --}}
                                <div class="mb-3">
                                    <label class="form-label">Jenis Pembayaran</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_pembayaran"
                                            id="transfer" value="Transfer" required>
                                        <label class="form-check-label" for="transfer">Transfer</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_pembayaran"
                                            id="tunai" value="Tunai">
                                        <label class="form-check-label" for="tunai">Tunai</label>
                                    </div>
                                </div>

                                {{-- Form DP --}}
                                <div id="dp_fields" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Nominal DP</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="nominal_dp" id="nominal_dp" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sisa Pembayaran</label>
                                        <div class="input-group">
                                            <input type="text" id="sisa_pembayaran" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="bukti_transfer" class="form-label">Upload Bukti
                                        Pembayaran</label>
                                    <input type="file" name="bukti_transfer" class="form-control" id="bukti_transfer"
                                        accept="image/*" required>
                                </div>

                                <!-- Modal Bukti Transfer -->
                                <div class="modal fade" id="transferModal" tabindex="-1"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Transfer & Bukti Pembayaran</h5>
                                                <button type="button" class="btn-close-custom" data-bs-dismiss="modal"
                                                    aria-label="Close">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Silakan transfer ke:</p>
                                                <ul>
                                                    <li><strong>Bank BCA</strong> - 1234567890 - a.n. Toko Kue Lezat
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-custom-pesan mb-4">Kirim Pesanan</button>
                            </form>
                        </div>
                        <!-- Kolom Gambar & Harga -->
                        <div class="col-md-6">
                            <div class="card">
                                <img src="{{ asset($produk->foto_produk ?? 'https://via.placeholder.com/300') }}"
                                    alt="Kue Pilihan" class="card-img-top" alt="{{ $produk->nama_produk }}">
                                <div class="card-body">
                                    <h4 class="card-title text-center">{{ $produk->nama_produk }}</h4>
                                    <h3 class="card-text">Harga: <strong>Rp
                                            {{ number_format($produk->harga, 0, ',', '.') }}</strong></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        const hargaSatuan = {{ $produk->harga }};
        const jumlahInput = document.getElementById('jumlah');
        const totalHargaInput = document.getElementById('total_harga');
        const totalHargaDisplay = document.getElementById('total_harga_display');
        const radioDp = document.getElementById('dp');
        const radioLunas = document.getElementById('lunas');
        const dpFields = document.getElementById('dp_fields');
        const nominalDpInput = document.getElementById('nominal_dp');
        const sisaPembayaran = document.getElementById('sisa_pembayaran');

        const radioTransfer = document.getElementById('transfer');
        const radioTunai = document.getElementById('tunai');
        const transferInfo = document.getElementById('transfer_info');

        function tambahJumlah() {
            jumlahInput.value = parseInt(jumlahInput.value) + 1;
            updateTotal();
        }

        function kurangiJumlah() {
            if (parseInt(jumlahInput.value) > 1) {
                jumlahInput.value = parseInt(jumlahInput.value) - 1;
                updateTotal();
            }
        }

        function updateTotal() {
            const jumlah = parseInt(jumlahInput.value) || 1;
            const total = hargaSatuan * jumlah;
            totalHargaInput.value = total;
            totalHargaDisplay.value = formatRupiah(total);
            hitungSisaPembayaran();
        }

        function toggleDPFields() {
            if (radioDp.checked) {
                dpFields.style.display = 'block';
                const total = parseInt(totalHargaInput.value) || 0;
                const defaultDP = Math.floor(total * 0.5);
                nominalDpInput.value = defaultDP;
                hitungSisaPembayaran();
            } else {
                dpFields.style.display = 'none';
                nominalDpInput.value = '';
                sisaPembayaran.value = '';
            }
        }

        function toggleTransferInfo() {
            if (radioTransfer.checked) {
                const modal = new bootstrap.Modal(document.getElementById('transferModal'));
                modal.show();
            }
        }


        function hitungSisaPembayaran() {
            if (!radioDp.checked) return;

            const total = parseInt(totalHargaInput.value) || 0;
            let dp = parseInt(nominalDpInput.value) || 0;

            if (dp > total) {
                dp = total;
                nominalDpInput.value = total;
                alert('Nominal DP tidak boleh lebih dari total harga!');
            }

            const sisa = Math.max(total - dp, 0);
            sisaPembayaran.value = formatRupiah(sisa);
        }

        function formatRupiah(angka) {
            return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Event listeners
        jumlahInput.addEventListener('input', updateTotal);
        nominalDpInput.addEventListener('input', hitungSisaPembayaran);
        radioDp.addEventListener('change', toggleDPFields);
        radioLunas.addEventListener('change', toggleDPFields);
        radioTransfer.addEventListener('change', toggleTransferInfo);
        radioTunai.addEventListener('change', toggleTransferInfo);

        document.addEventListener('DOMContentLoaded', () => {
            updateTotal();
            toggleDPFields();
            toggleTransferInfo();
        });

        document.addEventListener('DOMContentLoaded', function () {
        if (sessionStorage.getItem('scrollToProduk')) {
            const element = document.getElementById('pesankue');
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
            sessionStorage.removeItem('scrollToProduk');
        }
    });
    </script>

@endsection

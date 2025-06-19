@extends('layoutadmin.index')
@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Data Produk</h5>
                <!-- Tombol trigger modal -->
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    Tambah Produk
                </button>
                <!-- Modal Tambah Pengguna -->
                <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('produk.tambah') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-white" id="modalTambahLabel">Tambah Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Upload Gambar -->
                                    <div class="mb-3 text-center">
                                        <label for="fotoInput" style="cursor: pointer;">
                                            <img id="previewFoto" src="https://via.placeholder.com/100" alt="Preview"
                                                class="rounded-circle mb-2"
                                                style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ccc;">
                                        </label>
                                        <input type="file" id="fotoInput" name="foto_produk" accept="image/*"
                                            class="d-none" onchange="previewGambar(this)">
                                    </div>

                                    <div class="mb-2">
                                        <label>Nama Produk</label>
                                        <input type="text" name="nama_produk" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Harga</label>
                                        <input type="number" name="harga" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Stok</label>
                                        <input type="number" name="stok" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Kategori</label>
                                        <select name="kategori" class="form-control" required>
                                            <option value="basah">Kue Basah</option>
                                            <option value="kering">Kue Kering</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-warning">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $pr)
                                <tr>
                                    <td>
                                        <img src="{{ asset($pr->foto_produk ?? 'https://via.placeholder.com/100') }}"
                                            alt="Foto" class="rounded-circle me-2"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        {{ $pr->nama_produk }}
                                    </td>

                                    <td>Rp {{ $pr->harga }} / Satuan</td>
                                    <td>{{ $pr->stok }}</td>
                                    <td>
                                        @if ($pr->kategori == 'basah')
                                            <span class="badge bg-warning text-white">Kue Basah</span>
                                        @else
                                            <span class="badge" style="background-color: #fc95c4;">Kue Kering</span>
                                        @endif
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $pr->id_produk }}">
                                            Edit
                                        </button>

                                        <!-- Modal Edit Pengguna -->
                                        <div class="modal fade" id="modalEdit{{ $pr->id_produk }}" tabindex="-1"
                                            aria-labelledby="modalEditLabel{{ $pr->id_produk }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('produk.perbarui', $pr->id_produk) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="modalEditLabel{{ $pr->id_produk }}">
                                                                Edit Produk</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 text-center">
                                                                <label for="fotoInput{{ $pr->id_produk }}"
                                                                    style="cursor: pointer;">
                                                                    <img id="previewEditFoto{{ $pr->id_produk }}"
                                                                        src="{{ asset($pr->foto_produk ?? 'https://via.placeholder.com/100') }}"
                                                                        alt="Preview" class="rounded-circle mb-2"
                                                                        style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ccc;">
                                                                </label>
                                                                <input type="file" id="fotoInput{{ $pr->id_produk }}"
                                                                    name="foto_produk" accept="image/*" class="d-none"
                                                                    onchange="previewEditGambar(this, '{{ $pr->id_produk }}')">
                                                            </div>

                                                            <div class="mb-2">
                                                                <label>Nama Produk</label>
                                                                <input type="text" name="nama_produk"
                                                                    class="form-control" value="{{ $pr->nama_produk }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Harga</label>
                                                                <input type="number" name="harga" class="form-control"
                                                                    value="{{ $pr->harga }}" required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Stok</label>
                                                                <input type="number" name="stok" class="form-control"
                                                                    value="{{ $pr->stok }}" required>
                                                            </div>

                                                            <div class="mb-2">
                                                                <label>Kategori</label>
                                                                <select name="kategori" class="form-control" required>
                                                                    <option value="basah"
                                                                        {{ $pr->kategori == 'basah' ? 'selected' : '' }}>
                                                                        Kue Basah</option>
                                                                    <option value="kering"
                                                                        {{ $pr->kategori == 'kering' ? 'selected' : '' }}>
                                                                        Kue Kering</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <!-- Tombol Hapus -->
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalHapus{{ $pr->id_produk }}">
                                            Hapus
                                        </button>
                                        <!-- Modal Hapus Pengguna -->
                                        <div class="modal fade" id="modalHapus{{ $pr->id_produk }}" tabindex="-1"
                                            aria-labelledby="modalHapusLabel{{ $pr->id_produk }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('produk.hapus', $pr->id_produk) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="modalHapusLabel{{ $pr->id_produk }}">Konfirmasi Hapus
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus pengguna
                                                            <strong>{{ $pr->nama_produk }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya,
                                                                Hapus</button>
                                                        </div>
                                                    </div>
                                                </form>
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
    </div>
    <script>
        function previewGambar(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewFoto').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function previewEditGambar(input, id) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewEditFoto' + id).src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection

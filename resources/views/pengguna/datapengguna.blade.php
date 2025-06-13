@extends('layoutadmin.index')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Data Pengguna</h5>
                <!-- Tombol trigger modal -->
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    Tambah Pengguna
                </button>
                <!-- Modal Tambah Pengguna -->
                <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('pengguna.tambah') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-white" id="modalTambahLabel">Tambah Pengguna</h5>
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
                                        <input type="file" id="fotoInput" name="gambar" accept="image/*" class="d-none"
                                            onchange="previewGambar(this)">
                                    </div>

                                    <div class="mb-2">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="namalengkap" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" id="inputPassword"
                                                required>
                                            <button type="button" class="btn btn-outline-warning"
                                                onclick="togglePassword()">
                                                <i class="bi bi-eye" id="iconEye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Nomor Telepon</label>
                                        <input type="number" name="nomortelepon" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="admin">Admin</option>
                                            <option value="pelanggan">Pelanggan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
                                <th>Nama Pengguna</th>
                                <th>Nama Akses</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengguna as $pdk)
                                <tr>
                                    <td>
                                        <img src="{{ asset($pdk->gambar ?? 'https://via.placeholder.com/100') }}"
                                            alt="Foto" class="rounded-circle me-2"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        {{ $pdk->namalengkap }}
                                    </td>

                                    <td>{{ $pdk->username }}</td>
                                    <td>{{ $pdk->alamat }}</td>
                                    <td>{{ $pdk->nomortelepon }}</td>
                                    <td>
                                        @if ($pdk->status == 'admin')
                                            <span class="badge bg-warning text-white">Admin</span>
                                        @else
                                            <span class="badge" style="background-color: #fc95c4;">Pelanggan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $pdk->id_user }}">
                                            Edit
                                        </button>

                                        <!-- Modal Edit Pengguna -->
                                        <div class="modal fade" id="modalEdit{{ $pdk->id_user }}" tabindex="-1"
                                            aria-labelledby="modalEditLabel{{ $pdk->id_user }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('pengguna.perbarui', $pdk->id_user) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"
                                                                id="modalEditLabel{{ $pdk->id_user }}">Edit Pengguna</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- Upload Foto --}}
                                                            <div class="mb-3 text-center">
                                                                <label for="fotoInput{{ $pdk->id_user }}"
                                                                    style="cursor: pointer;">
                                                                    <img id="previewEditFoto{{ $pdk->id_user }}"
                                                                        src="{{ asset($pdk->gambar ?? 'https://via.placeholder.com/100') }}"
                                                                        alt="Preview" class="rounded-circle mb-2"
                                                                        style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ccc;">
                                                                </label>
                                                                <input type="file" id="fotoInput{{ $pdk->id_user }}"
                                                                    name="gambar" accept="image/*" class="d-none"
                                                                    onchange="previewEditGambar(this, '{{ $pdk->id_user }}')">
                                                            </div>

                                                            <div class="mb-2">
                                                                <label>Nama Lengkap</label>
                                                                <input type="text" name="namalengkap"
                                                                    class="form-control" value="{{ $pdk->namalengkap }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Username</label>
                                                                <input type="text" name="username"
                                                                    class="form-control" value="{{ $pdk->username }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Password (Opsional)</label>
                                                                <div class="input-group">
                                                                    <input type="password" name="password"
                                                                        class="form-control"
                                                                        id="editPassword{{ $pdk->id_user }}">
                                                                    <button type="button" class="btn btn-outline-primary"
                                                                        onclick="toggleEditPassword('{{ $pdk->id_user }}')">
                                                                        <i class="bi bi-eye"
                                                                            id="iconEditEye{{ $pdk->id_user }}"></i>
                                                                    </button>
                                                                </div>
                                                                <small class="text-muted">Kosongkan jika tidak ingin
                                                                    mengubah password.</small>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Alamat</label>
                                                                <textarea name="alamat" class="form-control" rows="2" required>{{ $pdk->alamat }}</textarea>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Nomor Telepon</label>
                                                                <input type="text" name="nomortelepon"
                                                                    class="form-control" value="{{ $pdk->nomortelepon }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label>Status</label>
                                                                <select name="status" class="form-control" required>
                                                                    <option value="admin"
                                                                        {{ $pdk->status == 'admin' ? 'selected' : '' }}>
                                                                        Admin</option>
                                                                    <option value="pelanggan"
                                                                        {{ $pdk->status == 'pelanggan' ? 'selected' : '' }}>
                                                                        Pelanggan</option>
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
                                            data-bs-target="#modalHapus{{ $pdk->id_user }}">
                                            Hapus
                                        </button>
                                        <!-- Modal Hapus Pengguna -->
                                        <div class="modal fade" id="modalHapus{{ $pdk->id_user }}" tabindex="-1"
                                            aria-labelledby="modalHapusLabel{{ $pdk->id_user }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('pengguna.hapus', $pdk->id_user) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="modalHapusLabel{{ $pdk->id_user }}">Konfirmasi Hapus
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus pengguna
                                                            <strong>{{ $pdk->namalengkap }}</strong>?
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
        function togglePassword() {
            const input = document.getElementById('inputPassword');
            const icon = document.getElementById('iconEye');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

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

        function toggleEditPassword(id) {
            const input = document.getElementById('editPassword' + id);
            const icon = document.getElementById('iconEditEye' + id);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
@endsection

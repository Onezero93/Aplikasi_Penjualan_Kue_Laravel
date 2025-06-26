<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleadmin.css') }}">
    <link rel="icon" href="{{ asset('images/logoaplikasi.png')}}" type="image/gif" />
</head>

<body>
    <div class="login-wrapper d-flex justify-content-center align-items-center"
        style="min-height: 100vh; padding-top: 10px;">
        <div class="container">
            <div class="col-md-5 mx-auto">
                <div class="card shadow">
                    <div class="card-header text-white text-center">
                        <h5 class="mb-0">Registrasi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register.proses') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-2 text-center">
                                <label for="gambar">Foto Profil (Opsional)</label><br>

                                <input type="file" id="gambar" name="gambar" accept="image/*"
                                    onchange="previewFoto(event)" style="display: none;">

                                <label for="gambar" style="cursor: pointer;">
                                    <img id="preview-image" src="{{ asset('fotos/default.png') }}" alt="Preview Foto"
                                        class="img-thumbnail rounded-circle"
                                        style="width: 70px; height: 70px; object-fit: cover; border: 2px dashed #ccc;">
                                </label>

                                <div class="form-text text-muted mt-1">Klik gambar untuk memilih foto</div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="namalengkap">Nama Lengkap</label>
                                <input type="text" name="namalengkap" class="form-control" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="nomortelepon">Nomor Telepon</label>
                                <input type="text" name="nomortelepon" class="form-control" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <input type="hidden" name="status" value="pelanggan">
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>

                        @if (session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif

                        <div class="text-center mt-3">
                            <small>
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-decoration-none">Login di sini</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewFoto(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('preview-image');
                preview.src = reader.result;
            }

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>

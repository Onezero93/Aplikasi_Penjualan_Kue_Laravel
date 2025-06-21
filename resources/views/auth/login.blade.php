<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleadmin.css') }}">
</head>

<body>
    <div class="login-wrapper">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header text-white text-center">
                        <h5 class="mb-0">Login</h5>
                    </div>
                    <div class="card-body">
                        {{-- @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif --}}

                        <form action="{{ route('login.proses') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Username" required autofocus>
                            </div>
                            <div class="form-group mb-4">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="Password"
                                    class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        {{-- Menampilkan pesan error --}}
                        @if (session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif


                        <div class="text-center mt-3">
                            <small>
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-decoration-none">Daftar Sekarang</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

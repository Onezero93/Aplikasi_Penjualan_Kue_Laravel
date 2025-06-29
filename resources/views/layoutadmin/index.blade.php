<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Aplikasi Anuro Admin</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logoaplikasi.png') }}" type="image/gif" />

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #fc95c4;
            padding: 20px;
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 80px;
            left: 0;
            transition: all 0.3s ease;
            overflow-y: auto;
            /* Tambahkan scroll jika tinggi melebihi layar */
            max-height: calc(100vh - 10px);
            /* Batasi tinggi agar tidak melebihi layar */
            z-index: 1000;
        }


        .sidebar a {
            display: block;
            padding: 10px 0;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-image: linear-gradient(0deg, #ffffff, #faf0c7 20%);
            border-radius: 4px;
            padding-left: 10px;
            color: black;
        }

        .sidebar.hidden {
            left: -250px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px;
            transition: all 0.3s ease;
        }

        .content.shifted {
            margin-left: 0;
        }

        #toggleSidebar {
            display: none;
            /* disembunyikan default */
            border: none;
            background: none;
        }

        .navbar-toggler-icon {
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%280, 0, 0, 0.7%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        /* Untuk tampilan kecil, atur posisi sidebar dan content */
        @media (max-width: 1268px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .content.shifted {
                margin-left: 250px;
            }
        }

        select.no-arrow {
            -webkit-appearance: none;
            /* Safari & Chrome */
            -moz-appearance: none;
            /* Firefox */
            appearance: none;
            /* Standard */
            background-image: none !important;
            padding-right: 0.5rem;
            /* Tambahkan padding kanan secukupnya */
        }

        select.text-center {
            text-align: center;
            text-align-last: center;
            /* Untuk browser modern */
        }

        .btn-logout {
            background: none;
            border: none;
            color: #dc3545;
            display: inline-block;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        .btn-logout:hover {
            border-radius: 4px;
            padding: 8px 68px;
            /* Sama seperti default agar tidak bergeser */
            background-image: linear-gradient(0deg, #ffffff, #faf0c7 20%);
            color: #a71d2a;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-light fixed-top d-flex justify-content-between align-items-center px-3">
        <button id="toggleSidebar" class="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logoadmin.png') }}" alt="Logo" style="height: 50px;" />
        </a>
    </nav>

    <div class="sidebar">
        @include('layoutadmin.sidebar')
    </div>

    <div class="content">
        @yield('content')
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');

        // Fungsi toggle sidebar
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            content.classList.toggle('shifted');
        });

        // Fungsi untuk tampilkan tombol toggle hanya saat tampilan kecil (termasuk zoom)
        function updateToggleButton() {
            if (window.innerWidth <= 1268) {
                toggleBtn.style.display = 'block';
                // Kembalikan sidebar ke posisi tertutup saat masuk mode kecil
                sidebar.classList.remove('active');
                content.classList.remove('shifted');
            } else {
                toggleBtn.style.display = 'none';
                // Pastikan sidebar selalu terlihat saat layar besar
                sidebar.classList.remove('hidden');
            }
        }

        window.addEventListener('load', updateToggleButton);
        window.addEventListener('resize', updateToggleButton);
    </script>
</body>

</html>

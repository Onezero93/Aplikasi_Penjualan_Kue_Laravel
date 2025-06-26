<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sidebar Tanpa Script</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logoaplikasi.png')}}" type="image/gif" />

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        #sidebarToggle {
            display: none;
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
        }

        .sidebar a {
            display: block;
            padding: 10px 0;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-image: linear-gradient(0deg, #ffffff, #faf0c7 20%);
            border-radius: 4px;
            padding-left: 10px;
            color: black;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px;
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            #sidebarToggle:checked~.sidebar {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            #sidebarToggle:checked~.content {
                margin-left: 250px;
            }
        }

        .toggle-btn {
            cursor: pointer;
        }

        .sidebar a.active {
            background-image: linear-gradient(0deg, #ffffff, #faf0c7 20%);
            border-radius: 4px;
            padding-left: 10px;
            color: black;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            min-width: 1000px;
        }

        th {
            white-space: nowrap;
        }
        .form-select-sm.bg-pink {
            background-color: #fc95c4;
            color: #fff;
            font-weight: bold;
        }

        .form-select-sm.bg-success {
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
        }
        /* Hilangkan icon select di semua browser umum */
select.no-arrow {
    -webkit-appearance: none;  /* Safari & Chrome */
    -moz-appearance: none;     /* Firefox */
    appearance: none;          /* Standard */
    background-image: none !important;
    padding-right: 0.5rem;     /* Tambahkan padding kanan secukupnya */
}
select.text-center {
    text-align: center;
    text-align-last: center; /* Untuk browser modern */
}

    </style>
</head>

<body>
    <input type="checkbox" id="sidebarToggle">
    <nav class="navbar navbar-light bg-light fixed-top d-flex justify-content-between">
        <label for="sidebarToggle" class="navbar-toggler d-md-none mb-0 toggle-btn">
            <span class="navbar-toggler-icon"></span>
        </label>
        <a class="navbar-brand ps-5 pe-5" href="#">
    <img src="{{ asset('images/logoadmin.png') }}" alt="Logo" style="height: 50px;">
</a>

    </nav>
    <div class="sidebar">
        @include('layoutadmin.sidebar')
    </div>
    <div class="content">
        @yield('content')
    </div>
    <!-- Bootstrap JS (wajib pakai versi bundle) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>

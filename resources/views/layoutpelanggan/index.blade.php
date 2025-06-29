<!DOCTYPE html>
<html>

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Aplikasi Anuro</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <!-- Responsive-->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- fevicon -->
    <link rel="icon" href="{{ asset('images/logoaplikasi.png')}}" type="image/gif" />
    <!-- font css -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="header_section">
        <div class="container">
            @include('layoutpelanggan.navbar')
        </div>
        <!-- banner section start -->
        <div class="banner_section layout_padding">
            <div class="container">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">01</li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1">02</li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2">03</li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3">04</li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h1 class="banner_taital">Ice Cream</h1>
                                    <p class="banner_text">It is a long established fact that a reader will be
                                        distracted by the readable content of a page when looking at its layout. The
                                        point of using Lorem</p>
                                    <div class="started_text"><a href="#">Order Now</a></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="banner_img"><img src="images/banner-img.png"></div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h1 class="banner_taital">Ice Cream</h1>
                                    <p class="banner_text">It is a long established fact that a reader will be
                                        distracted by the readable content of a page when looking at its layout. The
                                        point of using Lorem</p>
                                    <div class="started_text"><a href="#">Order Now</a></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="banner_img"><img src="images/banner-img.png"></div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h1 class="banner_taital">Ice Cream</h1>
                                    <p class="banner_text">It is a long established fact that a reader will be
                                        distracted by the readable content of a page when looking at its layout. The
                                        point of using Lorem</p>
                                    <div class="started_text"><a href="#">Order Now</a></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="banner_img"><img src="images/banner-img.png"></div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h1 class="banner_taital">Ice Cream</h1>
                                    <p class="banner_text">It is a long established fact that a reader will be
                                        distracted by the readable content of a page when looking at its layout. The
                                        point of using Lorem</p>
                                    <div class="started_text"><a href="#">Order Now</a></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="banner_img"><img src="images/banner-img.png"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- banner section end -->
    </div>
    <div class="cream_section layout_padding mb-4">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <!-- copyright section start -->
    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text">2020 All Rights Reserved. Design by <a href="https://html.design">Free Html
                    Templates</a> Distribution by <a href="https://themewagon.com">ThemeWagon</a></p>
        </div>
    </div>
    <!-- copyright section end -->
    <!-- Javascript files-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/plugin.js') }}"></script>
    <!-- sidebar -->
    <script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- javascript -->
    <script>
        document.getElementById('lihat-semua').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.produk-lain').forEach(function(item) {
                item.classList.remove('d-none');
            });
            this.style.display = 'none';
        });
        function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewImage').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>

</html>

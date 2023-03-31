<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!--<link href="{{ asset('assets/img/favicon.png') }}" rel="icon">-->

        <!-- Fonts
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        -->
         <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    </head>
    <body>
                 <!-- ======= Header ======= -->
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="/">INOVA</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="getstarted scrollto" href="/admin">Tableau de bord</a></li>
                </ul>
            </nav><!-- .navbar -->

            </div>
        </header><!-- End Header -->
         <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex align-items-center">
            <div class="container-fluid" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 pt-3 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1>Gestionnaire de Parc Informatique</h1>
                        <h2>Gérer plus éfficassement votre parc informatique</h2>
                        <div>
                            <a href="/admin" class="btn-get-started scrollto">Allez au tableau de bord</a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="150">
                        <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>
        </section><!-- End Hero -->



        <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>

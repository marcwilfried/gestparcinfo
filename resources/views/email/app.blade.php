<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; --bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity));">
    <div style="display: none;">Nouvelle Notificationc</div>
    <div role="article" aria-roledescription="email" aria-label="Reset your Password" lang="en">
        <table style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td align="center"
                    style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;"
                    bgcolor="rgba(236, 239, 241, var(--bg-opacity))">
                    <table class="sm-w-full" style="font-family: 'Montserrat', Arial, sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <td class="sm-py-32 sm-px-24" style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; padding: 48px; text-align: center;" align="center">
                                <a href="{{ route('welcome') }}">
                                    <img src="{{ asset('assets/img/features.svg') }}" width="155" alt="GPI" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;" />
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="sm-px-24" style="font-family: 'Montserrat', Arial, sans-serif;">
                                <table style="font-family: 'Montserrat', Arial, sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td
                                            class="sm-px-24"
                                            style="
                                                --bg-opacity: 1;
                                                background-color: #ffffff;
                                                background-color: rgba(255, 255, 255, var(--bg-opacity));
                                                border-radius: 4px;
                                                font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;
                                                font-size: 14px;
                                                line-height: 24px;
                                                padding: 48px;
                                                text-align: left;
                                                --text-opacity: 1;
                                                color: #626262;
                                                color: rgba(98, 98, 98, var(--text-opacity));
                                            " bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                                            <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">{{ auth()->user()->name }}</p>
                                            <p style="font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(255, 88, 80, var(--text-opacity));">
                                                Vient d'éffectuer une modification dans <span style="font-size: 24px;">GPI</span>.
                                            </p>
                                            {{-- <p style="margin: 0 0 24px;">
                                                <p>Adresse IP : <span style="font-weight: 600;">{{ request()->ip(); }}</span></p>
                                            </p> --}}
                                            <p style="margin: 0 0 24px;">
                                                Cliquez sur ce lien pour aller voir
                                            </p>
                                            <a href="{{ route('welcome') }}" style="display: block; font-size: 14px; line-height: 100%; margin-bottom: 24px; --text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">
                                               <button class="btn btn-outline-primary">Voir</button>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: 'Montserrat', Arial, sans-serif; height: 16px;" height="16"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>



<script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>
</html>

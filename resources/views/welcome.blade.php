<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon-->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
        rel="stylesheet"
    />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<!-- ==== HEADER ==== -->
<header class="container header">
    <!-- ==== NAVBAR ==== -->
    <nav class="nav">
        <div class="logo">
            <h2>GAMA</h2>
        </div>
    </nav>
</header>

<section class="wrapper">
    <div class="container">
        <div class="grid-cols-2">
            <div class="grid-item-1">
                <h1 class="main-heading">Bienvenido a <span>GAMA.</span></h1>
                <br />
                <h3>Gestión, Administración y Manejo de Activos.</h3>
                <p class="info-text">
                    La herramienta definitiva para la gestión eficiente de tus
                    activos. Simplifica tu vida empresarial al rastrear, administrar y
                    optimizar todos tus recursos.
                </p>
                <a href="{{ route('filament.admin.auth.login') }}">
                    <div class="btn_wrapper">
                        <button class="btn view_more_btn">
                            Ingresar <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
                </a>
            </div>
            <div class="grid-item-2">
                <div class="team_img_wrapper">
                    <img src={{ asset('GAMA.svg') }} alt="GAMA-img" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="wrapper">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <div class="grid-cols-3">
            <div class="grid-col-item">
                <div class="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                    </svg>
                </div>
                <div class="featured_info">
                    <span>Seguimiento en tiempo real </span>
                    <p>
                        Con nuestra tecnología de vanguardia, mantén un control absoluto
                        sobre tus activos en todo momento. Desde equipos hasta
                        propiedades, GAMA te proporciona datos precisos y actualizados
                        al instante.
                    </p>
                </div>
            </div>
            <div class="grid-col-item">
                <div class="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"
                        />
                    </svg>
                </div>
                <div class="featured_info">
                    <span>Facilidad de uso</span>
                    <p>
                        Diseñada pensando en la simplicidad, nuestra plataforma es
                        intuitiva y accesible para usuarios de todos los niveles.
                    </p>
                </div>
            </div>

            <div class="grid-col-item">
                <div class="icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"
                        />
                    </svg>
                </div>
                <div class="featured_info">
                    <span>Seguridad de alto nivel</span>
                    <p>
                        Tus datos son nuestra prioridad. GAMA utiliza las últimas
                        medidas de seguridad para garantizar la protección de tu
                        información confidencial.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <p>
        © Todos los Derechos Reservados GAMA Services / Gestión Corporativa -
        2024
    </p>
</footer>

<!-- ==== ANIMATE ON SCROLL JS CDN -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- ==== GSAP CDN ==== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
<!-- ==== SCRIPT.JS ==== -->
</body>
</html>

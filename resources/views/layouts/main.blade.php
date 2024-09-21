<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta name="referrer" content="no-referrer">
    <!-- PWA  -->
    <meta name="theme-color" content="#317671"/>
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PelajarNU{{ isset($title) ? ' - ' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : '' }}</title>



    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>

    <!-- Minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Minified Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Styles with Manual Cache Buster -->
    <link rel="stylesheet" href="{{ asset('css/layoutsmain.css') }}">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="body--no-scroll">
    <!-- Include Navbar Partial -->
    @include('partials.navbar')

    <!-- Main Content -->
    <div id="main-content">
        @yield('container')

        {{-- Tampilkan hanya pada halaman home dan faq --}}
        @if (request()->is('/') || request()->is('faq'))
            @include('partials.sosmed')
        @endif

    </div>

    {{-- Jangan tampilkan footer di halaman login --}}
    @if (!request()->is('login'))
        @include('partials.footer')
    @endif
    
    <!-- Minified Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Script with Manual Cache Buster -->
    <script>
        window.addEventListener('load', function () {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('main-content').style.display = 'block';
            document.body.classList.remove('body--no-scroll');
        });
    </script>

<script src="{{ asset('/sw.js') }}"></script>
<script>
   if ("serviceWorker" in navigator) {
      // Register a service worker hosted at the root of the
      // site using the default scope.
      navigator.serviceWorker.register("/sw.js").then(
      (registration) => {
         console.log("Service worker registration succeeded:", registration);
      },
      (error) => {
         console.error(`Service worker registration failed: ${error}`);
      },
    );
  } else {
     console.error("Service workers are not supported.");
  }
</script>
</body>

</html>

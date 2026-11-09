<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Pondok Pesantren Nurur Rahmah — Membentuk Generasi Qur\'ani')</title>
    <meta name="description" content="@yield('description', 'Pondok Pesantren Nurur Rahmah memadukan tahfidz Al-Qur\'an, kajian kitab kuning, dan pendidikan formal dalam lingkungan yang hangat dan penuh keberkahan.')">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Pondok Pesantren Nurur Rahmah">
    <meta property="og:title" content="@yield('title', 'Pondok Pesantren Nurur Rahmah')">
    <meta property="og:description" content="@yield('description', 'Pondok Pesantren Nurur Rahmah memadukan tahfidz Al-Qur\'an, kajian kitab kuning, dan pendidikan formal dalam lingkungan yang hangat dan penuh keberkahan.')">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream-50 font-sans text-ink antialiased">
    <a href="#konten" class="sr-only z-[60] rounded-full bg-emerald-900 px-4 py-2 text-sm font-semibold text-cream-50 focus:not-sr-only focus:fixed focus:left-4 focus:top-4">
        Lewati ke konten utama
    </a>

    <x-header :nav-prefix="$navPrefix ?? ''" :brand-href="$brandHref ?? '#beranda'" :logo="$logo ?? null" />

    <main id="konten">
        @yield('content')
    </main>

    @include('landing.partials.footer', ['navItems' => $navItems, 'programs' => $programs, 'contact' => $contact, 'logo' => $logo ?? null])
</body>
</html>

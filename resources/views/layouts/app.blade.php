<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Kelurahan Petamburan') – {{ __('ui.meta_suffix') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <meta name="description" content="@yield('meta_description', __('ui.meta_default'))">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&family=OpenDyslexic:wght@400;700&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body>

    <!-- ===== ACCESSIBILITY WIDGET ===== -->
    @include('partials.accessibility')

    <!-- ===== TOP BAR ===== -->
    @include('partials.topbar')

    <!-- ===== HEADER ===== -->
    @include('partials.header')

    <!-- ===== MAIN CONTENT ===== -->
    @yield('content')

    <!-- ===== FOOTER ===== -->
    @include('partials.footer')

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>

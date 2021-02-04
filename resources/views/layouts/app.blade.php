<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
        <!-- Scripts -->
        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script src="{{ asset('assets/js/select2/select2.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/sweetalert2.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/custom.js') }}" defer></script>
        <script>
            window.web_url = '{{asset("/".env('DASHBOARD_PREFIX'))}}';
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

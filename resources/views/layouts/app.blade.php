<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laravel - CV Generator</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS (make sure it's included) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/add-sections.js"></script>

    <style>
        .container {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
    <header class="min-h-[60px] flex justify-center items-center shadow-md bg-white sticky top-0 z-50">
        <div>
            <h1 class="text-3xl font-extrabold text-blue-600 tracking-wide">CV Generator</h1>
        </div>
    </header>

    <main class="container p-8 my-10 bg-white rounded-lg shadow-lg">
        @yield("content")
    </main>
</body>

@stack("scripts")

</html>
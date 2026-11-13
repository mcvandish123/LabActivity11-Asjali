<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Barangay Bulletin – Purok Asjali')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-800">
    <header class="bg-blue-700 text-white">
        <div class="max-w-5xl mx-auto px-4 py-4">
            <a href="{{ route('posts.index') }}" class="text-xl font-bold">Barangay Bulletin – Purok Asjali</a>
            <p class="text-sm text-blue-100">Barangay Matina Crossing, Davao City</p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>
</html>

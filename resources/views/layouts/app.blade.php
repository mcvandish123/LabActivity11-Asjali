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
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <a href="{{ route('posts.index') }}" class="text-xl font-bold">Barangay Bulletin – Purok Asjali</a>
                <p class="text-sm text-blue-100">Barangay Matina Crossing, Davao City</p>
            </div>
            <nav class="text-sm">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center gap-3">
                        @csrf
                        <span>{{ auth()->user()->name }}</span>
                        <button type="submit" class="underline">Log out</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="underline">Log in</a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>
</html>
